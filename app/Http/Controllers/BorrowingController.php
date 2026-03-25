<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $borrowings = Borrowing::with(['user', 'book', 'fine'])
            ->where(function($q) {
                $q->where('status', 'dikembalikan')
                  ->orWhereNull('deadline')
                  ->orWhere('deadline', '>=', \Carbon\Carbon::today());
            })
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                  ->orWhereHas('book', fn($b) => $b->where('title', 'like', "%$search%"));
            })
            ->latest()
            ->paginate(10);

        return view('admin.peminjaman.index', compact('borrowings', 'search'));
    }

    public function show(Borrowing $peminjaman)
    {
        $peminjaman->load(['user', 'book', 'fine']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }
}
