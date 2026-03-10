@extends('layouts.admin')

@section('title', 'Laporan')

@push('styles')
<style>
    .breadcrumb { font-size: 0.85rem; color: #4361ee; margin-bottom: 20px; }

    /* Search / Filter Box */
    .filter-box {
        background: #f8f9fb; border-radius: 14px;
        padding: 20px 24px; margin-bottom: 20px;
        border: 1px solid #eee;
    }
    .filter-box h2 { font-size: 1rem; font-weight: 700; color: #222; margin: 0 0 12px; }
    .filter-label { font-size: 0.78rem; color: #666; margin-bottom: 8px; }
    .filter-row {
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    }
    .date-input-wrap {
        display: flex; align-items: center; gap: 8px;
        background: #fff; border-radius: 8px; border: 1px solid #ddd;
        padding: 8px 14px; min-width: 180px;
    }
    .date-input-wrap svg { color: #4361ee; flex-shrink: 0; }
    .date-input-wrap input[type="date"] {
        border: none; outline: none; font-size: 0.85rem;
        color: #444; background: transparent; font-family: inherit;
    }
    .filter-sep {
        font-size: 0.82rem; color: #888; font-weight: 500;
    }
    .btn-filter {
        background: #4361ee; color: #fff; border: none;
        border-radius: 8px; padding: 9px 20px;
        font-size: 0.84rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        transition: background 0.15s;
    }
    .btn-filter:hover { background: #3a56d4; }

    /* Stat Cards */
    .stat-cards {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 16px; margin-bottom: 20px;
    }
    .stat-card {
        background: #fff; border-radius: 14px;
        padding: 20px 24px; border: 1.5px solid #e5e7eb;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .stat-card-info {}
    .stat-card-label { font-size: 0.8rem; color: #666; margin: 0 0 4px; font-weight: 500; }
    .stat-card-value { font-size: 2rem; font-weight: 700; color: #222; margin: 0; }
    .stat-card-value.danger { color: #ef4444; }
    .stat-card-value.success { color: #22c55e; }
    .stat-card-icon {
        width: 44px; height: 44px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; flex-shrink: 0;
    }
    .stat-card:nth-child(1) .stat-card-icon { background: #eef0ff; color: #4361ee; }
    .stat-card:nth-child(2) .stat-card-icon { background: #fee2e2; color: #ef4444; }
    .stat-card:nth-child(3) .stat-card-icon { background: #dcfce7; color: #16a34a; }

    /* Preview Table Section */
    .preview-section {
        background: #fff; border-radius: 14px;
        border: 1px solid #eee; overflow: hidden;
    }
    .preview-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 20px; border-bottom: 1px solid #f0f0f0;
    }
    .preview-header h3 { font-size: 0.95rem; font-weight: 700; color: #222; margin: 0; }
    .export-btns { display: flex; gap: 8px; }
    .btn-export {
        display: inline-flex; align-items: center; gap: 6px;
        border: 1px solid #ddd; background: #fff; color: #444;
        border-radius: 7px; padding: 7px 14px;
        font-size: 0.78rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        text-decoration: none; transition: background 0.15s;
    }
    .btn-export:hover { background: #f5f5f5; }
    .btn-export svg { width: 15px; height: 15px; flex-shrink: 0; }

    /* Table */
    .laporan-table { width: 100%; border-collapse: collapse; }
    .laporan-table th {
        text-align: left; font-size: 0.72rem;
        font-weight: 700; color: #888;
        text-transform: uppercase; padding: 12px 16px;
        border-bottom: 1px solid #f0f0f0;
        background: #fafafa;
    }
    .laporan-table td {
        padding: 12px 16px; font-size: 0.84rem;
        color: #444; border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .laporan-table tr:last-child td { border-bottom: none; }
    .laporan-table tr:hover td { background: #f8f9ff; }

    /* Badges */
    .badge {
        display: inline-block; padding: 4px 14px;
        border-radius: 20px; font-size: 0.72rem; font-weight: 700;
    }
    .badge-danger { background: #fee2e2; color: #dc2626; }
    .badge-success { background: #d1fae5; color: #059669; }
    .badge-warning { background: #fef9c3; color: #92400e; }

    .denda-text { font-size: 0.83rem; color: #444; }
    .denda-none { color: #999; }

    /* Pagination */
    .pagination-wrap {
        padding: 14px 16px; border-top: 1px solid #f0f0f0;
        display: flex; align-items: center; gap: 4px;
    }
    .pagination-wrap a, .pagination-wrap span {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: 6px;
        font-size: 0.8rem; text-decoration: none;
        color: #666; border: 1px solid #e5e7eb;
    }
    .pagination-wrap .active { background: #4361ee; color: #fff; border-color: #4361ee; }

    .empty-state { text-align: center; padding: 40px; color: #999; font-size: 0.9rem; }
</style>
@endpush

@section('content')
    {{-- Breadcrumb --}}
    <div class="breadcrumb">Laporan</div>

    {{-- Filter Box --}}
    <div class="filter-box">
        <h2>Cari Transaksi</h2>
        <p class="filter-label">Filter Berdasarkan Tanggal</p>
        <form method="GET" action="{{ route('admin.laporan.index') }}">
            <div class="filter-row">
                <div class="date-input-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <input type="date" name="from" value="{{ $from }}">
                </div>
                <span class="filter-sep">From</span>
                <div class="date-input-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <input type="date" name="until" value="{{ $until }}">
                </div>
                <span class="filter-sep">Until</span>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
        </form>
    </div>

    {{-- Stat Cards --}}
    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Total Peminjaman</p>
                <p class="stat-card-value">{{ $totalPeminjaman }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Status Terlambat</p>
                <p class="stat-card-value danger">{{ $statusTerlambat }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Status Dikembalikan</p>
                <p class="stat-card-value success">{{ $statusDikembalikan }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Preview Table --}}
    <div class="preview-section">
        <div class="preview-header">
            <h3>Pratinjau Laporan (Peminjaman)</h3>
            <div class="export-btns">
                <a href="{{ route('admin.laporan.export', ['from' => $from, 'until' => $until, 'type' => 'pdf']) }}"
                   class="btn-export" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Pdf
                </a>
                <a href="{{ route('admin.laporan.export', ['from' => $from, 'until' => $until, 'type' => 'excel']) }}"
                   class="btn-export">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M3 14h18M10 3v18M14 3v18M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                    </svg>
                    Excel
                </a>
                <a href="{{ route('admin.laporan.export', ['from' => $from, 'until' => $until, 'type' => 'print']) }}"
                   class="btn-export" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </a>
            </div>
        </div>

        <table class="laporan-table">
            <thead>
                <tr>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowings as $b)
                @php $sd = $b->status_display; @endphp
                <tr>
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
                            <span class="denda-text">Rp. {{ number_format($b->fine->amount, 0, ',', '.') }}</span>
                        @else
                            <span class="denda-none">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-state">Tidak ada data pada rentang tanggal ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($borrowings->hasPages())
        <div class="pagination-wrap">
            {{ $borrowings->appends(['from' => $from, 'until' => $until])->links() }}
        </div>
        @endif
    </div>
@endsection
