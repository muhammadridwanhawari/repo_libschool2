<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $from  = $request->input('from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $until = $request->input('until', Carbon::now()->format('Y-m-d'));

        $query = Borrowing::with(['user', 'book', 'fine'])
            ->whereBetween('borrow_date', [$from, $until]);

        $borrowings = $query->orderBy('borrow_date')->paginate(10)->withQueryString();

        // Statistik dari query yang sama (tanpa paginate)
        $allInRange = Borrowing::with('fine')
            ->whereBetween('borrow_date', [$from, $until])
            ->get();

        $totalPeminjaman   = $allInRange->count();
        $statusTerlambat   = $allInRange->filter(fn($b) => $b->fine !== null)->count();
        $statusDikembalikan = $allInRange->filter(fn($b) => $b->status === 'dikembalikan')->count();
        $statusDipinjam   = $allInRange->filter(fn($b) => $b->status === 'dipinjam')->count();

        return view('admin.laporan.index', compact(
            'borrowings', 'from', 'until',
            'totalPeminjaman', 'statusTerlambat', 'statusDikembalikan', 'statusDipinjam'
        ));
    }

    /**
     * Export data untuk print / PDF (semua data sesuai filter, tanpa paginasi)
     */
    public function export(Request $request)
    {
        $from  = $request->input('from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $until = $request->input('until', Carbon::now()->format('Y-m-d'));
        $type  = $request->input('type', 'print'); // print | pdf | excel

        $borrowings = Borrowing::with(['user', 'book', 'fine'])
            ->whereBetween('borrow_date', [$from, $until])
            ->orderBy('borrow_date')
            ->get();

        $totalPeminjaman    = $borrowings->count();
        $statusTerlambat    = $borrowings->filter(fn($b) => $b->fine !== null)->count();
        $statusDikembalikan = $borrowings->filter(fn($b) => $b->status === 'dikembalikan')->count();
        $statusDipinjam     = $borrowings->filter(fn($b) => $b->status === 'dipinjam')->count();

        if ($type === 'excel') {
            // Export sebagai CSV (bisa dibuka di Excel)
            $filename = 'laporan-peminjaman-' . $from . '-sd-' . $until . '.csv';
            $headers  = [
                'Content-Type'        => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $callback = function () use ($borrowings) {
                $handle = fopen('php://output', 'w');
                // BOM untuk Excel agar bisa baca UTF-8
                fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
                fputcsv($handle, ['Nama Peminjam', 'Judul Buku', 'Tgl Pinjam', 'Deadline', 'Status', 'Denda'], ';');
                foreach ($borrowings as $b) {
                    fputcsv($handle, [
                        $b->user?->name ?? '-',
                        $b->book?->title ?? '-',
                        $b->borrow_date?->format('Y-m-d') ?? '-',
                        $b->deadline?->format('Y-m-d') ?? '-',
                        ucfirst($b->status_display),
                        $b->fine ? 'Rp. ' . number_format($b->fine->amount, 0, ',', '.') : '-',
                    ], ';');
                }
                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);
        }

        if ($type === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.print', compact(
                'borrowings', 'from', 'until',
                'totalPeminjaman', 'statusTerlambat', 'statusDikembalikan', 'statusDipinjam', 'type'
            ));
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('laporan-peminjaman-' . $from . '-sd-' . $until . '.pdf');
        }

        // Untuk print: tampilkan view cetak
        return view('admin.laporan.print', compact(
            'borrowings', 'from', 'until',
            'totalPeminjaman', 'statusTerlambat', 'statusDikembalikan', 'statusDipinjam', 'type'
        ));
    }
}
