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

        // Filter by series
        if ($request->series) {
            $query->where('book_series_id', $request->series);
        }

        // Out of stock terkahir
        $query->orderByRaw('stock <= 0 ASC');

        // Sort
        $sort = $request->sort ?? 'title';
        if ($sort === 'terbaru') {
            $query->latest();
        } else {
            $query->orderBy($sort);
        }

        $books      = $query->paginate(10);
        $categories = Category::all();
        $series     = \App\Models\BookSeries::all();

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

        return view('siswa.katalog', compact('books', 'categories', 'series', 'selected', 'favoritedIds', 'activeCount'));
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
        $book = Book::findOrFail($id);

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

        // Cek batas maksimal pinjaman aktif
        $activeCount = Borrowing::where('user_id', Auth::id())
            ->whereIn('status', ['booking', 'dipinjam'])
            ->count();

        if ($activeCount >= 5) {
            return response()->json([
                'success' => false,
                'message' => 'Kamu sudah mencapai batas maksimal 5 pinjaman aktif. Kembalikan salah satu buku terlebih dahulu sebelum meminjam buku baru.',
            ], 422);
        }

        // Cek stok buku
        if ($book->stock < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Stok buku sudah habis.',
            ], 422);
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

        // Generate kode booking
        $bookingCode = Borrowing::generateBookingCode();

        // Simpan booking (stok belum dikurangi, penjaga yang akan konfirmasi)
        Borrowing::create([
            'user_id'      => Auth::id(),
            'book_id'      => $id,
            'booking_code' => $bookingCode,
            'borrow_date'  => now()->toDateString(),
            'duration'     => $request->input('durasi', 7),
            'status'       => 'booking',
        ]);

        return response()->json([
            'success'      => true,
            'booking_code' => $bookingCode,
            'book_title'   => $book->title,
            'book_author'  => $book->author,
            'message'      => 'Kode booking berhasil dibuat! Tunjukkan kode ini kepada penjaga perpustakaan.',
        ]);
    }
}