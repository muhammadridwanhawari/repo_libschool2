<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FineController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        // Denda: hanya tampilkan peminjaman yang terlambat (deadline < hari ini dan belum dikembalikan)
        $dendaList = Borrowing::with(['user', 'book', 'fine'])
            ->where('status', '!=', 'dikembalikan')
            ->where('deadline', '<', Carbon::today())
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                  ->orWhereHas('book', fn($b) => $b->where('title', 'like', "%$search%"));
            })
            ->latest()
            ->paginate(10);

        return view('admin.denda.index', compact('dendaList', 'search'));
    }

    public function show(Borrowing $denda)
    {
        $denda->load(['user', 'book', 'fine']);
        return view('admin.denda.show', compact('denda'));
    }
}
