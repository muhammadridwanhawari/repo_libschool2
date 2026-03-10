<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaKatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        // Search
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Sort
        $sort = $request->sort ?? 'title';
        $query->orderBy($sort);

        $books      = $query->paginate(12);
        $categories = Category::all();

        // Selected book
        $selected = null;
        if ($request->selected) {
            $selected = Book::with('category')->find($request->selected);
        }

        // ID buku yang sudah difavoritkan oleh user yang login
        $favoritedIds = Favorite::where('user_id', Auth::id())
            ->pluck('book_id')
            ->toArray();

        return view('siswa.katalog', compact('books', 'categories', 'selected', 'favoritedIds'));
    }

    /**
     * AJAX: Proses peminjaman — generate kode booking
     */
    public function pinjam(Request $request, $id)
    {
        $book = Book::findOrFail($id);

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