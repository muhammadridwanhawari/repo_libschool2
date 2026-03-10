<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaTransaksiController extends Controller
{
    /**
     * Menampilkan riwayat transaksi peminjaman siswa
     */
    public function index()
    {
        $transactions = Borrowing::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('siswa.transaksi', compact('transactions'));
    }
}
