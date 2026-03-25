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
        $userId = Auth::id();
        $transactions = Borrowing::with('book')
            ->where('user_id', $userId)
            ->whereIn('status', ['booking', 'dipinjam'])
            ->latest()
            ->paginate(10);

        $totalActive = Borrowing::where('user_id', $userId)->where('status', 'dipinjam')->count();
        $totalSegeraKembali = Borrowing::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->whereNotNull('deadline')
            ->get()
            ->filter(function ($loan) {
                $deadlineDate = \Carbon\Carbon::parse($loan->deadline)->startOfDay();
                $diff = now()->startOfDay()->diffInDays($deadlineDate, false);
                return $diff <= 1;
            })->count();
        $totalSelesai = Borrowing::where('user_id', $userId)->where('status', 'dikembalikan')->count();

        $dendaDariDB = abs(\App\Models\Fine::whereHas('borrowing', fn($q) => $q->where('user_id', $userId))
            ->where('payment_status', 'unpaid')->sum('amount'));
        $lateLoansEstimasi = Borrowing::where('user_id', $userId)
            ->where('status', 'dipinjam')->whereNotNull('deadline')->whereDate('deadline', '<', now())
            ->doesntHave('fine')->get();
        $dendaEstimasi = $lateLoansEstimasi->sum(function ($loan) {
            return now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($loan->deadline)->startOfDay()) * 2000;
        });
        $totalDenda = $dendaDariDB + $dendaEstimasi;

        return view('siswa.transaksi', compact('transactions', 'totalActive', 'totalSegeraKembali', 'totalSelesai', 'totalDenda'));
    }

    public function riwayat()
    {
        $userId = Auth::id();
        $user   = Auth::user();

        // Pinjaman aktif (booking + dipinjam)
        $activeLoans = Borrowing::with('book')
            ->where('user_id', $userId)
            ->whereIn('status', ['booking', 'dipinjam'])
            ->latest()
            ->get();

        // Riwayat dikembalikan
        $recentHistory = Borrowing::with(['book', 'fine'])
            ->where('user_id', $userId)
            ->where('status', 'dikembalikan')
            ->latest('return_date')
            ->get();

        // ── Stat cards ──────────────────────────────────────────────
        // Buku Selesai = total dikembalikan
        $totalSelesai = Borrowing::where('user_id', $userId)
            ->where('status', 'dikembalikan')
            ->count();

        // Pernah Terlambat = jumlah peminjaman yang punya fine atau pernah terlambat
        $totalTerlambat = Borrowing::where('user_id', $userId)
            ->where(function ($q) {
                $q->whereHas('fine')
                  ->orWhere(function ($q2) {
                      $q2->where('status', 'dikembalikan')
                         ->whereColumn('return_date', '>', 'deadline');
                  });
            })
            ->count();

        // Denda yang sudah dicatat di DB
        $dendaDariDB = abs(\App\Models\Fine::whereHas('borrowing', fn($q) => $q->where('user_id', $userId))
            ->where('payment_status', 'unpaid')
            ->sum('amount'));

        // Estimasi denda real-time untuk pinjaman aktif terlambat (belum ada fine)
        $lateLoansEstimasi = Borrowing::with('fine')
            ->where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', now())
            ->doesntHave('fine')
            ->get();

        $dendaEstimasi = $lateLoansEstimasi->sum(function ($loan) {
            return now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($loan->deadline)->startOfDay()) * 2000;
        });

        $totalDenda = $dendaDariDB + $dendaEstimasi;

        // Rincian tagihan = fines yang belum lunas + pinjaman telat tanpa fine
        $unpaidFines = \App\Models\Fine::with('borrowing.book')
            ->whereHas('borrowing', fn($q) => $q->where('user_id', $userId))
            ->where('paid', false)
            ->get();

        // Pinjaman aktif terlambat tanpa fine (estimasi)
        $lateWithoutFine = $lateLoansEstimasi;

        // Stat lama (masih dipakai di stat cards bawah)
        $totalBorrowed  = Borrowing::where('user_id', $userId)->count();
        $activeBorrowed = $activeLoans->count();

        return view('siswa.riwayat', compact(
            'activeLoans', 'recentHistory',
            'totalBorrowed', 'activeBorrowed', 'totalDenda',
            'totalSelesai', 'totalTerlambat',
            'unpaidFines', 'lateWithoutFine', 'user'
        ));
    }

    public function bayarDenda(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:diperpus,digital',
            'payment_proof'  => 'required_if:payment_method,digital|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $userId = Auth::id();

        // Get all unpaid fines
        $unpaidFines = \App\Models\Fine::whereHas('borrowing', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('paid', false)->get();

        if ($unpaidFines->isEmpty()) {
            return back()->with('error', 'Tidak ada tagihan denda yang perlu di bayar at the moment.');
        }

        $paymentCode = 'PAY-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        $proofPath = null;

        if ($request->payment_method === 'digital' && $request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payments', 'public');
        }

        foreach ($unpaidFines as $fine) {
            $fine->update([
                'payment_code'   => $paymentCode,
                'payment_method' => $request->payment_method,
                'payment_proof'  => $proofPath,
                'payment_status' => 'pending',
            ]);
        }

        return back()->with('success', 'Terimakasih sudah melunasi denda! Pembayaran kamu akan segera di proses oleh Penjaga perpustakaan');
    }
}
