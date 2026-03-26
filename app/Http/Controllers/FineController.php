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
        $search = $request->input('search');
        $month = $request->input('month');

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

        // Pembayaran Pending
        $pendingPayments = Fine::with(['borrowing.user', 'borrowing.book'])
            ->where('payment_status', 'pending')
            ->latest()
            ->get()
            ->groupBy('payment_code');

        // Riwayat Denda
        $riwayatDenda = Fine::with(['borrowing.user', 'borrowing.book'])
            ->when($search, function ($q) use ($search) {
                $q->whereHas('borrowing.user', fn($u) => $u->where('name', 'like', "%$search%"))
                  ->orWhereHas('borrowing.book', fn($b) => $b->where('title', 'like', "%$search%"));
            })
            ->when($month, function ($q) use ($month) {
                $q->whereMonth('updated_at', substr($month, 5, 2))
                  ->whereYear('updated_at', substr($month, 0, 4));
            })
            ->latest()
            ->paginate(10, ['*'], 'riwayat_page');

        // Total Denda Dibayar
        $totalDendaDibayar = Fine::where('paid', true)
            ->when($month, function ($q) use ($month) {
                $q->whereMonth('updated_at', substr($month, 5, 2))
                  ->whereYear('updated_at', substr($month, 0, 4));
            })
            ->sum('amount');

        // Siswa dengan denda belum dibayar
        $unpaidFines = Fine::with(['borrowing.user', 'borrowing.book'])
            ->where('paid', false)
            ->where(function ($q) {
                $q->whereNull('payment_status')
                  ->orWhere('payment_status', '!=', 'pending');
            })
            ->when($search, function ($q) use ($search) {
                $q->whereHas('borrowing.user', fn($u) => $u->where('name', 'like', "%$search%"))
                  ->orWhereHas('borrowing.book', fn($b) => $b->where('title', 'like', "%$search%"));
            })
            ->latest()
            ->paginate(10, ['*'], 'unpaid_page');

        return view('admin.denda.index', compact('dendaList', 'search', 'month', 'pendingPayments', 'riwayatDenda', 'totalDendaDibayar', 'unpaidFines'));
    }

    public function show(Borrowing $denda)
    {
        $denda->load(['user', 'book', 'fine']);
        return view('admin.denda.show', compact('denda'));
    }

    public function kembalikan(Borrowing $denda)
    {
        if ($denda->status === 'dikembalikan') {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        $hariTerlambat = 0;
        $amount = 0;
        if ($denda->deadline && now()->startOfDay()->gt(Carbon::parse($denda->deadline)->startOfDay())) {
            $hariTerlambat = now()->startOfDay()->diffInDays(Carbon::parse($denda->deadline)->startOfDay());
            $amount = $hariTerlambat * 2000;

            Fine::create([
                'borrowing_id' => $denda->id,
                'amount'       => $amount,
                'paid'         => false,
            ]);
        }

        $denda->update([
            'status'      => 'dikembalikan',
            'return_date' => now()->toDateString(),
        ]);

        $denda->book->increment('stock');

        $msg = "Buku \"{$denda->book->title}\" berhasil dikembalikan.";
        if ($amount > 0) {
            $msg .= " Denda Rp " . number_format($amount, 0, ',', '.') . " telah ditambahkan.";
        }

        return redirect()->route('admin.denda.index')->with('success', $msg);
    }

    public function verifikasi($payment_code)
    {
        $fines = Fine::where('payment_code', $payment_code)->where('payment_status', 'pending')->get();
        
        if ($fines->isEmpty()) {
            return back()->with('error', 'Data pembayaran tidak ditemukan atau sudah diverifikasi.');
        }

        Fine::where('payment_code', $payment_code)
            ->where('payment_status', 'pending')
            ->update([
                'paid' => true,
                'payment_status' => 'verified',
            ]);

        return back()->with('success', 'Pembayaran dengan kode ' . $payment_code . ' berhasil diverifikasi.');
    }
}
