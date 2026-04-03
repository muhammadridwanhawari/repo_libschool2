<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            
        // [MEDIUM-F05] Fix: Gunakan private method untuk kalkulasi estimasi denda
        ['estimasiAmount' => $dendaEstimasi, 'lateLoans' => $lateLoansEstimasi] = $this->getEstimatedFineData($userId);
        
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
        // 1. Buku Dipinjam (Total semua peminjaman by user)
        $totalBorrowed = Borrowing::where('user_id', $userId)->count();

        // 3. Pernah Terlambat = jumlah peminjaman yang punya fine atau pernah terlambat
        $totalTerlambat = Borrowing::where('user_id', $userId)
            ->where(function ($q) {
                $q->whereHas('fine')
                  ->orWhere(function ($q2) {
                      $q2->where('status', 'dikembalikan')
                         ->whereColumn('return_date', '>', 'deadline');
                  });
            })
            ->count();

        // 2. Tepat Waktu = Dikembalikan tapi tidak termasuk kriteria terlambat di atas
        $totalTepatWaktu = Borrowing::where('user_id', $userId)
            ->where('status', 'dikembalikan')
            ->whereDoesntHave('fine')
            ->where(function($q) {
                $q->whereColumn('return_date', '<=', 'deadline')
                  ->orWhereNull('deadline');
            })
            ->count();

        // Denda yang sudah dicatat di DB (Lunas + Belum Lunas) untuk Total Denda Semua
        $totalSemuaDendaDB = abs(\App\Models\Fine::whereHas('borrowing', fn($q) => $q->where('user_id', $userId))
            ->sum('amount'));
        $dendaDariDB = abs(\App\Models\Fine::whereHas('borrowing', fn($q) => $q->where('user_id', $userId))
            ->where('payment_status', 'unpaid')
            ->sum('amount'));

        // [MEDIUM-F05] Fix: Kalkulasi menggunakan private method agar DRY
        ['estimasiAmount' => $dendaEstimasi, 'lateLoans' => $lateLoansEstimasi] = $this->getEstimatedFineData($userId);

        $totalDenda = $dendaDariDB + $dendaEstimasi; // Ini untuk unpaid
        $totalSemuaDenda = $totalSemuaDendaDB + $dendaEstimasi; // Ini untuk keseluruhan (histori)

        // Rincian tagihan = fines yang belum lunas + pinjaman telat tanpa fine
        $unpaidFines = \App\Models\Fine::with('borrowing.book')
            ->whereHas('borrowing', fn($q) => $q->where('user_id', $userId))
            ->where('paid', false)
            ->get();

        // Pinjaman aktif terlambat tanpa fine (estimasi)
        $lateWithoutFine = $lateLoansEstimasi;

        $activeBorrowed = $activeLoans->count();

        return view('siswa.riwayat', compact(
            'activeLoans', 'recentHistory',
            'totalBorrowed', 'activeBorrowed', 'totalDenda',
            'totalTepatWaktu', 'totalTerlambat', 'totalSemuaDenda',
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

        // Cek apakah ada pembayaran yang sedang di-'pending' (sedang diverifikasi logikanya)
        $isPending = \App\Models\Fine::whereHas('borrowing', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('paid', false)->where('payment_status', 'pending')->exists();

        if ($isPending) {
            return back()->with('error', 'Pembayaran denda terbaru kamu sedang diproses oleh penjaga. Harap tunggu verifikasinya selesai sebelum submit lagi.');
        }

        // Get all unpaid fines that are NOT pending
        $unpaidFines = \App\Models\Fine::whereHas('borrowing', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->where('paid', false)->where('payment_status', '!=', 'pending')->get();

        if ($unpaidFines->isEmpty()) {
            // [LOW-F10] Fix: pesan error konsisten dalam Bahasa Indonesia
            return back()->with('error', 'Tidak ada tagihan denda yang perlu dibayar saat ini.');
        }

        $paymentCode = 'PAY-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        $proofPath = null;

        if ($request->payment_method === 'digital' && $request->hasFile('payment_proof')) {
            // Hapus file bukti lampau dari Storage jika ada untuk mencegah Storage Bloat (sampah)
            foreach ($unpaidFines as $fine) {
                if ($fine->payment_proof && Storage::disk('public')->exists($fine->payment_proof)) {
                    Storage::disk('public')->delete($fine->payment_proof);
                }
            }
            
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

        return back()->with('success', 'terimakasih sudah membayar denda! pembayaran kamu akan segera di proses oleh Penjaga perpustakaan.');
    }

    /**
     * [MEDIUM-F05] Fix: Helper method untuk menghitung estimasi denda (DRY)
     */
    private function getEstimatedFineData(int $userId): array
    {
        $lateLoans = Borrowing::with('fine')
            ->where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', now()->toDateString())
            ->doesntHave('fine')
            ->get();

        $estimasiAmount = $lateLoans->sum(function ($loan) {
            return abs(now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($loan->deadline)->startOfDay())) * 2000;
        });

        return [
            'estimasiAmount' => $estimasiAmount,
            'lateLoans'      => $lateLoans,
        ];
    }
}
