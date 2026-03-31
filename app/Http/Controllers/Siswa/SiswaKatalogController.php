<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookReview;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiswaKatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['category', 'categories']);

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%')
                  ->orWhere('isbn', 'like', '%' . $search . '%');
            });
        }

        // Filter by category
        if ($request->category) {
            $query->where(function ($q) use ($request) {
                $q->where('category_id', $request->category)
                  ->orWhereHas('categories', function ($q2) use ($request) {
                      $q2->where('categories.id', $request->category);
                  });
            });
        }


        // Sort: stock habis paling bawah, lalu A-Z
        $query->orderByRaw('stock <= 0 ASC')->orderBy('title');

        $books      = $query->paginate(10);
        $categories = Category::all();

        // Selected book
        $selected = null;
        if ($request->selected) {
            $selected = Book::with(['category', 'categories'])->find($request->selected);
        }

        // ID buku yang sudah difavoritkan oleh user yang login
        $favoritedIds = Favorite::where('user_id', Auth::id())
            ->pluck('book_id')
            ->toArray();

        // Jumlah pinjaman aktif siswa
        $activeCount = Borrowing::where('user_id', Auth::id())
            ->whereIn('status', ['booking', 'dipinjam'])
            ->count();

        return view('siswa.katalog', compact('books', 'categories', 'selected', 'favoritedIds', 'activeCount'));
    }

    /**
     * Tampilkan halaman detail buku
     */
    public function show($id)
    {
        $book    = Book::with(['category', 'categories', 'reviews.user'])->findOrFail($id);
        $reviews = $book->reviews()->with('user')->latest()->get();

        $avgRating = $reviews->avg('rating');

        // Apakah user sudah memberikan ulasan?
        $myReview = $reviews->where('user_id', Auth::id())->first();

        // Apakah difavoritkan?
        $isFav = Favorite::where('user_id', Auth::id())
            ->where('book_id', $book->id)->exists();

        // Cek apakah user sudah pernah meminjam buku ini (status dipinjam atau dikembalikan)
        $hasBorrowed = Borrowing::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->whereIn('status', ['dipinjam', 'dikembalikan'])
            ->exists();

        // Cek apakah user punya denda belum lunas
        $hasUnpaidFine = \App\Models\Fine::whereHas(
            'borrowing', fn($q) => $q->where('user_id', Auth::id())
        )->where('paid', false)->exists();

        // Hitung pinjaman aktif (booking + dipinjam)
        $activeCount = Borrowing::where('user_id', Auth::id())
            ->whereIn('status', ['booking', 'dipinjam'])
            ->count();

        return view('siswa.katalog.show', compact('book', 'reviews', 'avgRating', 'myReview', 'isFav', 'hasBorrowed', 'hasUnpaidFine', 'activeCount'));
    }

    /**
     * Submit ulasan & rating buku
     */
    public function review(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'pesan'  => 'nullable|string|max:1000',
        ]);

        BookReview::updateOrCreate(
            ['book_id' => $id, 'user_id' => Auth::id()],
            ['rating' => $request->rating, 'pesan' => $request->pesan]
        );

        return redirect()->route('siswa.katalog.show', $id)
            ->with('success', 'Ulasan kamu berhasil disimpan!');
    }

    /**
     * AJAX: Proses peminjaman — generate kode booking
     */
    public function pinjam(Request $request, $id)
    {
        // Validasi input tambahan (menghindari durasi ekstrem)
        $request->validate([
            'durasi' => 'nullable|integer|min:1|max:14',
        ]);

        // [H-04] Cek verifikasi akun siswa
        if (!Auth::user()->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Akun kamu belum diverifikasi oleh admin. Silakan hubungi petugas perpustakaan.',
            ], 403);
        }

        // Cek apakah siswa punya denda yang belum dilunasi
        $hasUnpaidFine = \App\Models\Fine::whereHas(
            'borrowing', fn($q) => $q->where('user_id', Auth::id())
        )->where('paid', false)->exists();

        if ($hasUnpaidFine) {
            return response()->json([
                'success' => false,
                'message' => 'Akun kamu dibatasi karena memiliki tagihan denda yang belum dilunasi. Silakan lunasi denda terlebih dahulu di menu Riwayat & Denda.',
            ], 403);
        }

        // Cek apakah siswa sudah punya booking/peminjaman aktif untuk buku ini
        $existing = Borrowing::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->whereIn('status', ['booking', 'dipinjam'])
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah memiliki peminjaman/booking aktif untuk buku ini.',
                'booking_code' => $existing->booking_code,
            ], 422);
        }

        // [H-01] Bungkus dalam DB transaction + lockForUpdate untuk cegah race condition
        try {
            $result = DB::transaction(function () use ($id, $request) {
                // Kalkulasi batasan aktif siswa secara real-time (mencegah bypass)
                $activeCount = Borrowing::where('user_id', Auth::id())
                    ->whereIn('status', ['booking', 'dipinjam'])
                    ->lockForUpdate()
                    ->count();

                if ($activeCount >= 5) {
                    return [
                        'success' => false,
                        'message' => 'Kamu sudah mencapai batas maksimal 5 pinjaman aktif.',
                        'status'  => 422,
                    ];
                }

                // Lock baris buku agar tidak bisa diubah proses lain secara bersamaan
                $book = Book::lockForUpdate()->findOrFail($id);

                // Cek stok buku di dalam transaction (setelah lock)
                if ($book->stock < 1) {
                    return [
                        'success' => false,
                        'message' => 'Stok buku sudah habis.',
                        'status'  => 422,
                    ];
                }

                // Generate kode booking unik
                $bookingCode = Borrowing::generateBookingCode();

                // Simpan booking
                Borrowing::create([
                    'user_id'      => Auth::id(),
                    'book_id'      => $id,
                    'booking_code' => $bookingCode,
                    'borrow_date'  => now()->toDateString(),
                    'duration'     => $request->input('durasi', 7),
                    'status'       => 'booking',
                ]);

                // Kurangi stok buku di dalam transaction
                $book->decrement('stock');

                return [
                    'success'      => true,
                    'booking_code' => $bookingCode,
                    'book_title'   => $book->title,
                    'book_author'  => $book->author,
                    'message'      => 'Kode booking berhasil dibuat! Tunjukkan kode ini kepada penjaga perpustakaan.',
                    'status'       => 200,
                ];
            });

            $status = $result['status'];
            unset($result['status']);
            return response()->json($result, $status);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses booking. Silakan coba lagi.',
            ], 500);
        }
    }
    /**
     * AJAX: Batal Booking
     */
    public function batalBooking($id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                /** @var \App\Models\Borrowing $borrowing */
                $borrowing = Borrowing::with('book')
                    ->where('id', $id)
                    ->where('user_id', Auth::id())
                    ->where('status', 'booking')
                    ->lockForUpdate()
                    ->firstOrFail();

                // Kembalikan stok buku
                if ($borrowing->book) {
                    $borrowing->book->increment('stock');
                }

                // Hapus data booking
                $borrowing->delete();

                return ['success' => true, 'message' => 'Booking berhasil dibatalkan dan stok buku telah dikembalikan.'];
            });

            return response()->json($result);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan.'], 404);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Gagal membatalkan booking. Silakan coba lagi.'], 500);
        }
    }
}