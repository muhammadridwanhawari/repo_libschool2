<?php

namespace App\Http\Controllers\Penjaga;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjagaPeminjamanController extends Controller
{
    /**
     * Halaman utama peminjaman penjaga
     * Menampilkan form input kode booking + tabel peminjaman aktif
     */
    public function index()
    {
        $totalBuku      = Book::sum('stock');
        $sedangDipinjam = Borrowing::where('status', 'dipinjam')->count();
        $belumKembali   = Borrowing::where('status', 'dipinjam')
                            ->whereNotNull('deadline')
                            ->whereDate('deadline', '<', now())
                            ->count();
        $menungguBooking = Borrowing::where('status', 'booking')->count();

        $peminjaman = Borrowing::with(['user', 'book'])
            ->where(function($q) {
                $q->where('status', 'booking')
                  ->orWhere('status', 'dipinjam');
            })
            ->orderByRaw("CASE status WHEN 'booking' THEN 0 ELSE 1 END")
            ->latest()
            ->paginate(10);

        return view('penjaga.peminjaman', compact(
            'peminjaman', 'totalBuku', 'sedangDipinjam', 'belumKembali', 'menungguBooking'
        ));
    }

    /**
     * AJAX: Cari booking berdasarkan kode booking
     */
    public function cariBooking(Request $request)
    {
        $request->validate(['booking_code' => 'required|string']);

        $borrowing = Borrowing::with(['user', 'book'])
            ->where('booking_code', strtoupper(trim($request->booking_code)))
            ->where('status', 'booking')
            ->first();

        if (!$borrowing) {
            return response()->json(['success' => false, 'message' => 'Kode booking tidak ditemukan atau sudah diproses.'], 404);
        }

        return response()->json([
            'success'      => true,
            'id'           => $borrowing->id,
            'booking_code' => $borrowing->booking_code,
            'book_title'   => $borrowing->book?->title,
            'book_author'  => $borrowing->book?->author,
            'book_stock'   => $borrowing->book?->stock,
            'student_name' => $borrowing->user?->name,
            'student_email'=> $borrowing->user?->email,
            'duration'     => $borrowing->duration,
        ]);
    }

    /**
     * Konfirmasi pinjam: ubah status booking → dipinjam, kurangi stok buku
     */
    public function konfirmasi(Request $request)
    {
        $request->validate([
            'borrowing_id' => 'required|exists:borrowings,id',
        ]);

        // [H-02] Gunakan DB transaction + lockForUpdate untuk cegah double-konfirmasi
        try {
            DB::transaction(function () use ($request) {
                $borrowing = Borrowing::with('book')
                    ->lockForUpdate()
                    ->findOrFail($request->borrowing_id);

                if ($borrowing->status !== 'booking') {
                    throw new \Exception('Peminjaman ini sudah diproses sebelumnya.');
                }

                // Update borrowing: booking → dipinjam
                // (stok TIDAK dikurangi lagi, sudah dikurangi saat booking)
                $borrowing->update([
                    'status'      => 'dipinjam',
                    'borrow_date' => now()->toDateString(),
                    'deadline'    => now()->addDays($borrowing->duration ?? 7)->toDateString(),
                ]);
            });

            $borrowing = Borrowing::with('book')->findOrFail($request->borrowing_id);
            return redirect()->route('penjaga.peminjaman')
                ->with('success', "Peminjaman buku \"{$borrowing->book->title}\" berhasil dikonfirmasi! Deadline: " . now()->addDays($borrowing->duration ?? 7)->format('d M Y'));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage() ?: 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}
