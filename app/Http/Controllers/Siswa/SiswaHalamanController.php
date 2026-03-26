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

        // Top 3 Buku
        $topBooksIds = DB::table('borrowings')
            ->select('book_id', DB::raw('COUNT(id) as total_borrowed'))
            ->whereMonth('borrow_date', $month)
            ->whereYear('borrow_date', $year)
            ->groupBy('book_id')
            ->orderByDesc('total_borrowed')
            ->limit(5)
            ->get();

        $booksData = \App\Models\Book::with(['categories', 'category'])
            ->whereIn('id', $topBooksIds->pluck('book_id'))
            ->get()
            ->keyBy('id');

        $topBooks = $topBooksIds->map(function($item) use ($booksData) {
            $book = $booksData->get($item->book_id);
            if ($book) {
                $book->total_borrowed = $item->total_borrowed;
                return $book;
            }
            return null;
        })->filter();

        // Top 3 Siswa berdasarkan poin
        $topStudents = DB::table('users')
            ->select('id', 'name', 'avatar', 'points',
                DB::raw('(SELECT COUNT(*) FROM borrowings WHERE borrowings.user_id = users.id AND MONTH(borrow_date) = ' . $month . ' AND YEAR(borrow_date) = ' . $year . ') as total_borrowed')
            )
            ->where('role', 'siswa')
            ->where('points', '>', 0)
            ->orderByDesc('points')
            ->limit(3)
            ->get();

        // Data Stat Cards untuk Auth User
        $userId = Auth::id();
        $userPoints = \App\Models\User::find($userId)->points ?? 0;
        
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
            return now()->startOfDay()->diffInDays(Carbon::parse($loan->deadline)->startOfDay()) * 2000;
        });

        $totalDenda = $dendaDariDB + $dendaEstimasi;

        // Cek apakah siswa punya denda yang belum lunas
        $hasUnpaidFine = \App\Models\Fine::whereHas(
            'borrowing', fn($q) => $q->where('user_id', $userId)
        )->where('paid', false)->exists();

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
            'topBooks', 'topStudents', 'now', 
            'totalSelesai', 'activeBorrowed', 'totalDenda', 'deadlineLoans',
            'hasUnpaidFine', 'userPoints'
        ));
    }
}
