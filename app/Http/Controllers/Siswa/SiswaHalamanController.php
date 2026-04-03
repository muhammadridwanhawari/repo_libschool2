<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Borrowing;
use Carbon\Carbon;

class SiswaHalamanController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;

        // Top Siswa berdasarkan poin
        $topStudents = DB::table('users')
            ->select('id', 'name', 'avatar', 'points',
                DB::raw('(SELECT COUNT(*) FROM borrowings WHERE borrowings.user_id = users.id AND MONTH(borrow_date) = ' . $month . ' AND YEAR(borrow_date) = ' . $year . ') as total_borrowed')
            )
            ->where('role', 'siswa')
            ->where('points', '>', 0)
            ->orderByDesc('points')
            ->orderByDesc('total_borrowed')
            ->limit(10)
            ->get();

        // Data Stat Cards untuk Auth User & Penentuan Gelar
        $userId = Auth::id();
        $userModel = \App\Models\User::find($userId);
        $userPoints = $userModel ? $userModel->points : 0;

        // Cari status peringkat user saat ini
        $userRankIndex = $topStudents->search(function ($student) use ($userId) {
            return $student->id == $userId;
        });

        $userTitle = 'Pemula';
        if ($userRankIndex !== false) {
            $rank = $userRankIndex + 1;
            if ($rank === 1) $userTitle = 'Duta literasi';
            elseif ($rank === 2) $userTitle = 'Pakar literasi';
            elseif ($rank === 3) $userTitle = 'Kontributor';
            elseif ($rank >= 4 && $rank <= 10) $userTitle = 'Pembaca aktif';
        }
        
        $totalSelesai = Borrowing::where('user_id', $userId)
            ->where('status', 'dikembalikan')
            ->count();

        $activeBorrowed = Borrowing::where('user_id', $userId)
            ->whereIn('status', ['booking', 'dipinjam'])
            ->count();

        $dendaDariDB = abs(\App\Models\Fine::whereHas('borrowing', fn($q) => $q->where('user_id', $userId))
            ->where('payment_status', 'unpaid')
            ->sum('amount'));

        $lateLoansEstimasi = Borrowing::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', now())
            ->doesntHave('fine')
            ->get();

        $dendaEstimasi = $lateLoansEstimasi->sum(function ($loan) {
            return abs(now()->startOfDay()->diffInDays(Carbon::parse($loan->deadline)->startOfDay())) * 2000;
        });

        $totalDenda = $dendaDariDB + $dendaEstimasi;

        // Cek apakah siswa punya denda yang belum lunas (belum dibayar ATAU ditolak, exclude pending)
        $hasUnpaidFine = \App\Models\Fine::whereHas(
            'borrowing', fn($q) => $q->where('user_id', $userId)
        )->where('paid', false)
         ->where(function ($q) {
             $q->where('payment_status', '!=', 'pending')->orWhereNull('payment_status');
         })->exists();

        // Buku yang sudah mau deadline atau telat
        $deadlineLoans = Borrowing::with('book')
            ->where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->whereNotNull('deadline')
            ->get()
            ->filter(function ($loan) {
                $deadlineDate = Carbon::parse($loan->deadline)->startOfDay();
                $diff = now()->startOfDay()->diffInDays($deadlineDate, false);
                return $diff <= 1; // 1 (H-1), 0 (Hari Ini), < 0 (Telat)
            });

        return view('siswa.halaman.index', compact(
            'topStudents', 'now', 
            'totalSelesai', 'activeBorrowed', 'totalDenda', 'deadlineLoans',
            'hasUnpaidFine', 'userPoints', 'userTitle'
        ));
    }
}
