<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function adminDashboard()
    {
        $totalBuku = Book::count();
        $totalPengguna = User::count();
        $peminjamanAktif = Borrowing::where('status', 'dipinjam')->count();
        $totalDenda = Fine::where('paid', true)->sum('amount') ?? 0;
        $peminjaman = Borrowing::with(['user', 'fine'])->latest()->paginate(10);

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalPengguna',
            'peminjamanAktif',
            'totalDenda',
            'peminjaman'
        ));
    }
}
