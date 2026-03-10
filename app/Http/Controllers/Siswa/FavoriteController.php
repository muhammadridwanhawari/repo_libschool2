<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Tampilkan daftar buku favorit siswa yang login.
     */
    public function index()
    {
        $favorites = Favorite::with('book.category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('siswa.favorite', compact('favorites'));
    }

    /**
     * Toggle favorit: tambah jika belum ada, hapus jika sudah ada.
     */
    public function toggle(Request $request, $bookId)
    {
        $userId = Auth::id();

        $existing = Favorite::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->first();

        if ($existing) {
            $existing->delete();
            $isFavorited = false;
            $message = 'Buku dihapus dari favorit.';
        } else {
            Favorite::create([
                'user_id' => $userId,
                'book_id' => $bookId,
            ]);
            $isFavorited = true;
            $message = 'Buku ditambahkan ke favorit!';
        }

        // Kalau request AJAX (dari fetch JS), kembalikan JSON
        if ($request->expectsJson()) {
            return response()->json([
                'favorited' => $isFavorited,
                'message'   => $message,
            ]);
        }

        // Kalau form POST biasa, redirect balik
        return back()->with('success', $message);
    }

    /**
     * Hapus favorit tertentu dari halaman favorit.
     */
    public function destroy($bookId)
    {
        Favorite::where('user_id', Auth::id())
            ->where('book_id', $bookId)
            ->delete();

        return back()->with('success', 'Buku dihapus dari favorit.');
    }
}
