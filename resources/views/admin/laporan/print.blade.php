<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman - LibSchool</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px; color: #222;
            padding: 20px 30px;
            background: #fff;
        }

        .report-header {
            text-align: center; margin-bottom: 24px;
            padding-bottom: 14px; border-bottom: 2px solid #4361ee;
        }
        .report-header h1 {
            font-size: 18px; font-weight: 700; color: #4361ee; margin-bottom: 4px;
        }
        .report-header p { font-size: 11px; color: #666; }

        .meta-row {
            display: flex; gap: 20px; margin-bottom: 16px; flex-wrap: wrap;
        }
        .meta-item { font-size: 11px; color: #555; }
        .meta-item strong { color: #222; }

        /* Stat summary */
        .stat-row {
            display: flex; gap: 12px; margin-bottom: 20px;
        }
        .stat-card {
            flex: 1; border: 1px solid #e5e7eb; border-radius: 8px;
            padding: 10px 14px;
        }
        .stat-label { font-size: 10px; color: #888; font-weight: 600; text-transform: uppercase; }
        .stat-value { font-size: 22px; font-weight: 700; margin-top: 2px; }
        .stat-value.blue { color: #4361ee; }
        .stat-value.red { color: #ef4444; }
        .stat-value.green { color: #16a34a; }

        /* Table */
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        thead tr { background: #4361ee; color: #fff; }
        th {
            padding: 8px 10px; font-size: 10px;
            font-weight: 700; text-align: left;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        td {
            padding: 8px 10px; font-size: 11px;
            border-bottom: 1px solid #f0f0f0; color: #333;
        }
        tr:nth-child(even) td { background: #f8f9ff; }

        .badge {
            display: inline-block; padding: 2px 10px;
            border-radius: 20px; font-size: 9px; font-weight: 700;
        }
        .badge-danger { background: #fee2e2; color: #dc2626; }
        .badge-success { background: #d1fae5; color: #059669; }
        .badge-warning { background: #fef9c3; color: #92400e; }

        .footer {
            margin-top: 20px; text-align: right;
            font-size: 10px; color: #888;
            border-top: 1px solid #e5e7eb; padding-top: 10px;
        }

        @media print {
            body { padding: 10px 20px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    {{-- Print / Close action (hidden saat print) --}}
    <div class="no-print" style="margin-bottom:16px; display:flex; gap:8px;">
        @if($type === 'print')
        <button onclick="window.print()"
            style="background:#4361ee; color:#fff; border:none; border-radius:6px; padding:8px 18px; font-size:12px; font-weight:600; cursor:pointer;">
            🖨️ Cetak
        </button>
        @endif
        <button onclick="window.close()"
            style="background:#f3f4f6; color:#444; border:1px solid #ddd; border-radius:6px; padding:8px 18px; font-size:12px; font-weight:600; cursor:pointer;">
            ✕ Tutup
        </button>
    </div>

    {{-- Header --}}
    <div class="report-header">
        <h1>Laporan Peminjaman Buku</h1>
        <p>LibSchool – Sistem Informasi Perpustakaan</p>
    </div>

    {{-- Meta --}}
    <div class="meta-row">
        <div class="meta-item">Periode: <strong>{{ $from }}</strong> s/d <strong>{{ $until }}</strong></div>
        <div class="meta-item">Dicetak: <strong>{{ now()->format('Y-m-d H:i') }}</strong></div>
    </div>

    {{-- Stat Summary --}}
    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-label">Total Peminjaman</div>
            <div class="stat-value blue">{{ $totalPeminjaman }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Status Terlambat</div>
            <div class="stat-value red">{{ $statusTerlambat }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Status Dikembalikan</div>
            <div class="stat-value green">{{ $statusDikembalikan }}</div>
        </div>
    </div>

    {{-- Table --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $i => $b)
            @php $sd = $b->status_display; @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $b->user?->name ?? '-' }}</td>
                <td>{{ $b->book?->title ?? '-' }}</td>
                <td>{{ $b->borrow_date?->format('Y-m-d') ?? '-' }}</td>
                <td>{{ $b->deadline?->format('Y-m-d') ?? '-' }}</td>
                <td>
                    @if($sd === 'terlambat')
                        <span class="badge badge-danger">Terlambat</span>
                    @elseif($sd === 'dikembalikan')
                        <span class="badge badge-success">Dikembalikan</span>
                    @else
                        <span class="badge badge-warning">Dipinjam</span>
                    @endif
                </td>
                <td>
                    @if($b->fine)
                        Rp. {{ number_format($b->fine->amount, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding:20px; color:#999;">
                    Tidak ada data pada rentang tanggal ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        LibSchool &copy; {{ date('Y') }} – Laporan Peminjaman Buku
    </div>

    @if($type === 'print')
    <script>
        window.addEventListener('load', function() {
            setTimeout(function() { window.print(); }, 300);
        });
    </script>
    @endif
</body>
</html>
