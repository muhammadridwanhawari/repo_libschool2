<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman - LibSchool</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px; color: #222;
            padding: 20px 30px;
            background: #fff;
        }

        /* typography */
        .page-title { font-size: 16px; font-weight: bold; color: #4361ee; margin-bottom: 2px; text-transform: uppercase; }
        .subtitle { font-size: 9px; color: #666; margin-bottom: 3px; }
        .sub-info { font-size: 10px; color: #333; font-weight: bold; }
        .divider { height: 2px; background-color: #4361ee; margin-top: 5px; margin-bottom: 12px; }

        /* header table (top stats) */
        .info-table {
            width: 100%; border-collapse: collapse; margin-bottom: 12px;
            border: 1px solid #d1d5db;
        }
        .info-table td {
            border: 1px solid #e5e7eb; padding: 8px 12px;
            vertical-align: top;
            width: 25%;
        }
        .info-label { font-size: 8px; color: #6b7280; text-transform: uppercase; font-weight: bold; margin-bottom: 2px;}
        .info-value { font-size: 11px; color: #111827; font-weight: bold; }
        
        /* big stats row */
        .stat-table {
            width: 100%; border-collapse: collapse; margin-bottom: 16px;
            border: 1px solid #d1d5db;
        }
        .stat-table td {
            border: 1px solid #e5e7eb; padding: 12px;
            text-align: center; width: 25%;
        }
        .stat-number { font-size: 20px; font-weight: bold; margin-bottom: 2px; }
        .stat-text { font-size: 8px; color: #6b7280; text-transform: uppercase; }

        .text-primary { color: #4361ee; }
        .text-red { color: #dc2626; }
        .text-green { color: #16a34a; }
        .text-blue { color: #0f766e; }

        /* main data table */
        .data-table {
            width: 100%; border-collapse: collapse; margin-bottom: 20px;
        }
        .data-table th {
            background-color: #4361ee; color: #fff;
            font-size: 9px; font-weight: bold; text-transform: uppercase;
            padding: 8px; text-align: left;
        }
        .data-table th.center { text-align: center; }
        .data-table td {
            padding: 8px; font-size: 10px; color: #374151;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
        .data-table tr:nth-child(even) td { background-color: #f9fafb; }
        
        .book-list { margin-left: 14px; color: #4b5563; }
        
        /* badges for dompdf (inline blocks with padding) */
        .badge {
            display: inline-block; padding: 3px 8px; 
            border-radius: 4px; font-size: 8px; font-weight: bold;
        }
        .badge-booking { background-color: #dbeafe; color: #1e40af; }
        .badge-terlambat { background-color: #fee2e2; color: #991b1b; }
        .badge-deadline { background-color: #ffedd5; color: #9a3412; }
        .badge-aktif { background-color: #e0f2fe; color: #075985; border: 1px solid #bae6fd; } /* light blue like Dipinjam */
        .badge-dikembalikan { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

        .footer-text { font-size: 8px; color: #9ca3af; margin-top: 30px;}
        .signature-box { text-align: right; font-size: 10px; color: #374151; width: 250px; float: right; margin-top: -15px; }
        
        @media print {
            body { padding: 10px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    @if($type === 'print')
    <div class="no-print" style="margin-bottom:16px; padding:10px; background:#f9fafb; border:1px solid #e5e7eb;">
        <button onclick="window.print()" style="background:#4361ee; color:#fff; border:none; padding:8px 16px; cursor:pointer; font-weight:bold; border-radius:4px; margin-right: 5px;">Cetak Dokumen</button>
        <button onclick="window.close()" style="background:#fff; color:#374151; border:1px solid #d1d5db; padding:8px 16px; cursor:pointer; font-weight:bold; border-radius:4px;">Tutup</button>
    </div>
    @endif

    {{-- Header --}}
    <div class="page-title">LAPORAN SISTEM PERPUSTAKAAN DIGITAL</div>
    <div class="subtitle">Dokumen Resmi &mdash; Dicetak Otomatis oleh Sistem</div>
    <div class="sub-info">Jenis: Peminjaman &nbsp;|&nbsp; Periode: {{ \Carbon\Carbon::parse($from)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($until)->format('d/m/Y') }}</div>
    
    <div class="divider"></div>

    {{-- Info Table --}}
    <table class="info-table">
        <tr>
            <td>
                <div class="info-label">JENIS LAPORAN</div>
                <div class="info-value">Peminjaman</div>
            </td>
            <td>
                <div class="info-label">PERIODE</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($from)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($until)->format('d M Y') }}</div>
            </td>
            <td>
                <div class="info-label">TOTAL DATA</div>
                <div class="info-value">{{ $totalPeminjaman }} record</div>
            </td>
            <td>
                <div class="info-label">DICETAK PADA</div>
                <div class="info-value">{{ now()->format('d M Y, H:i') }} WIB</div>
            </td>
        </tr>
    </table>

    {{-- Stats Table --}}
    <table class="stat-table">
        <tr>
            <td>
                <div class="stat-number text-primary">{{ $totalPeminjaman }}</div>
                <div class="stat-text">TOTAL TRANSAKSI</div>
            </td>
            <td>
                <div class="stat-number text-red">{{ $statusTerlambat }}</div>
                <div class="stat-text">TERLAMBAT</div>
            </td>
            <td>
                <div class="stat-number text-green">{{ $statusDikembalikan }}</div>
                <div class="stat-text">DIKEMBALIKAN</div>
            </td>
            <td>
                <div class="stat-number text-blue">{{ $statusDipinjam }}</div>
                <div class="stat-text">MASIH DIPINJAM</div>
            </td>
        </tr>
    </table>

    {{-- Data Table --}}
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="center">NO</th>
                <th width="18%">PEMINJAM</th>
                <th width="25%">BUKU</th>
                <th width="12%" class="center">TGL PINJAM</th>
                <th width="12%" class="center">TGL KEMBALI</th>
                <th width="13%" class="center">STATUS</th>
                <th width="15%" class="center">DENDA</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($borrowings as $i => $b)
            @php
                $isLate = false;
                $isDeadline = false;
                
                if ($b->status === 'dipinjam' && $b->deadline) {
                    $deadlineDate = \Carbon\Carbon::parse($b->deadline)->startOfDay();
                    $today = now()->startOfDay();
                    $diff = $today->diffInDays($deadlineDate, false);
                    
                    if ($diff < 0) {
                        $isLate = true;
                    } elseif ($diff >= 0 && $diff <= 1) {
                        $isDeadline = true;
                    }
                }
            @endphp
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $b->user?->name ?? '-' }}</td>
                <td>
                    <ul class="book-list">
                        <li>{{ $b->book?->title ?? '-' }}</li>
                    </ul>
                </td>
                <td class="center">{{ $b->borrow_date ? $b->borrow_date->format('d/m/Y') : '-' }}</td>
                <td class="center">
                    @if($b->status === 'dikembalikan')
                        {{ $b->updated_at ? $b->updated_at->format('d/m/Y') : '-' }}
                    @else
                        -
                    @endif
                </td>
                <td class="center">
                    @if($b->status === 'booking')
                        <span class="badge badge-booking">Booking</span>
                    @elseif($isLate)
                        <span class="badge badge-terlambat">Terlambat</span>
                    @elseif($isDeadline)
                        <span class="badge badge-deadline">Deadline</span>
                    @elseif($b->status === 'dipinjam')
                        <span class="badge badge-aktif">Dipinjam</span>
                    @elseif($b->status === 'dikembalikan')
                        <span class="badge badge-dikembalikan">Dikembalikan</span>
                    @endif
                </td>
                <td class="center">
                    @if($b->fine)
                        Rp. {{ number_format($b->fine->amount, 0, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="center" style="padding: 20px; color:#6b7280;">Tidak ada data peminjaman untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-text">
        Dokumen digenerate otomatis oleh Sistem Perpustakaan Digital pada {{ now()->format('d M Y') }} pukul {{ now()->format('H:i') }} WIB
    </div>

    <div class="signature-box">
        Admin Perpustakaan,<br>
        <div style="margin-top: 60px; border-bottom: 1px solid #000; width: 100%;"></div>
        <p style="text-align: center; margin-top:2px;">(_________________________)</p>
    </div>

    @if($type === 'print')
    <script>
        window.addEventListener('load', function() {
            setTimeout(function() { window.print(); }, 500);
        });
    </script>
    @endif
</body>
</html>
