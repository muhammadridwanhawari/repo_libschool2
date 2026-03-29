<?php

namespace App\Http\Controllers\Penjaga;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PenjagaPengembalianController extends Controller
{
    /**
     * Halaman utama pengembalian penjaga
     * Menampilkan tabel peminjaman aktif yang siap dikembalikan
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Mengambil peminjaman dengan status 'dipinjam' saja yang belum terlambat
        $peminjaman = Borrowing::with(['user', 'book'])
            ->where('status', 'dipinjam')
            ->where(function($q) {
                $q->whereNull('deadline')
                  ->orWhere('deadline', '>=', Carbon::today());
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($subQ) use ($search) {
                    $subQ->where('booking_code', 'like', "%$search%")
                         ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                         ->orWhereHas('book', fn($b) => $b->where('title', 'like', "%$search%"));
                });
            })
            ->latest()
            ->paginate(10);

        // Menghitung denda secara dinamis untuk tampilan (Rp 2.000 per hari keterlambatan)
        foreach ($peminjaman as $p) {
            $p->denda_estimasi = 0;
            $p->hari_terlambat = 0;
            if ($p->deadline && now()->startOfDay()->gt(Carbon::parse($p->deadline)->startOfDay())) {
                $p->hari_terlambat = now()->startOfDay()->diffInDays(Carbon::parse($p->deadline)->startOfDay());
                $p->denda_estimasi = $p->hari_terlambat * 2000;
            }
        }

        // Daftar Keterlambatan
        $dendaList = Borrowing::with(['user', 'book', 'fine'])
            ->where('status', 'dipinjam')
            ->where('deadline', '<', Carbon::today())
            ->when($search, function ($q) use ($search) {
                $q->where(function ($subQ) use ($search) {
                    $subQ->where('booking_code', 'like', "%$search%")
                         ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                         ->orWhereHas('book', fn($b) => $b->where('title', 'like', "%$search%"));
                });
            })
            ->latest()
            ->paginate(10, ['*'], 'denda_page');

        // Stat counts
        $statBelumDikembalikan = Borrowing::where('status', 'dipinjam')->count();

        $statSedangDipinjam = Borrowing::where('status', 'dipinjam')
            ->where(function($q) {
                $q->whereNull('deadline')
                  ->orWhere('deadline', '>=', Carbon::today());
            })->count();

        $statSudahTerlambat = Borrowing::where('status', 'dipinjam')
            ->where('deadline', '<', Carbon::today())
            ->count();

        foreach ($dendaList as $p) {
            $p->denda_estimasi = 0;
            $p->hari_terlambat = 0;
            if ($p->deadline && now()->startOfDay()->gt(Carbon::parse($p->deadline)->startOfDay())) {
                $p->hari_terlambat = now()->startOfDay()->diffInDays(Carbon::parse($p->deadline)->startOfDay());
                $p->denda_estimasi = $p->hari_terlambat * 2000;
            }
        }

        return view('penjaga.pengembalian', compact('peminjaman', 'dendaList', 'search', 'statBelumDikembalikan', 'statSedangDipinjam', 'statSudahTerlambat'));
    }

    /**
     * Proses pengembalian buku dan kalkulasi denda
     */
    public function kembalikan(Request $request, $id)
    {
        $borrowing = Borrowing::with('book')->findOrFail($id);

        if ($borrowing->status !== 'dipinjam') {
            return back()->with('error', 'Status peminjaman ini bukan "dipinjam".');
        }

        $dendaMessage = "";
        $hariTerlambat = 0;

        // Hitung denda jika terlambat
        if ($borrowing->deadline && now()->startOfDay()->gt(Carbon::parse($borrowing->deadline)->startOfDay())) {
            $hariTerlambat = now()->startOfDay()->diffInDays(Carbon::parse($borrowing->deadline)->startOfDay());
            $amount = $hariTerlambat * 2000; // Rp 2.000 per hari

            Fine::create([
                'borrowing_id' => $borrowing->id,
                'amount'       => $amount,
                'paid'         => false,
            ]);

            $dendaMessage = " Terlambat $hariTerlambat hari. Denda Rp " . number_format($amount, 0, ',', '.') . " telah ditambahkan.";
        }

        $borrowing->update([
            'status'      => 'dikembalikan',
            'return_date' => now()->toDateString(),
        ]);

        // Kembalikan stok buku
        $borrowing->book->increment('stock');

        // Award poin kepada siswa
        if ($borrowing->user) {
            $poin = ($hariTerlambat > 0) ? 5 : 10;
            $borrowing->user->increment('points', $poin);
        }

        return redirect()->route('penjaga.pengembalian')
            ->with('success', "Buku \"{$borrowing->book->title}\" berhasil dikembalikan." . $dendaMessage);
    }

    /**
     * Halaman Riwayat Transaksi untuk Penjaga
     * Menampilkan semua data peminjaman (termasuk yang sudah dikembalikan)
     */
    public function riwayat(Request $request)
    {
        $search = $request->input('search');

        $riwayat = Borrowing::with(['user', 'book', 'fine'])
            ->when($search, function ($q) use ($search) {
                $q->where('booking_code', 'like', "%$search%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                  ->orWhereHas('book', fn($b) => $b->where('title', 'like', "%$search%"));
            })
            ->latest()
            ->paginate(10);

        return view('penjaga.riwayat', compact('riwayat', 'search'));
    }
}
