@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    .breadcrumb { font-size: 0.85rem; color: #4361ee; margin-bottom: 20px; }

    /* Search */
    .search-box {
        background: #f8f9fb; border-radius: 14px;
        padding: 20px 24px; margin-bottom: 24px;
        border: 1px solid #eee;
    }
    .search-box h2 { font-size: 1.1rem; font-weight: 700; color: #222; margin: 0 0 12px; }
    .search-input-wrap {
        display: flex; align-items: center; gap: 10px;
        background: #fff; border-radius: 10px; border: 1px solid #ddd;
        padding: 10px 16px;
    }
    .search-input-wrap svg { color: #bbb; flex-shrink: 0; }
    .search-input-wrap input {
        flex: 1; border: none; outline: none;
        font-size: 0.9rem; color: #555; background: transparent;
        font-family: inherit;
    }

    /* Stat Cards */
    .stat-cards {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 16px; margin-bottom: 28px;
    }
    .stat-card {
        background: #fff; border-radius: 14px;
        padding: 20px; border-left: 4px solid;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .stat-card:nth-child(1) { border-color: #4361ee; }
    .stat-card:nth-child(2) { border-color: #4361ee; }
    .stat-card:nth-child(3) { border-color: #f59e0b; }
    .stat-card:nth-child(4) { border-color: #10b981; }
    .stat-card-icon {
        width: 40px; height: 40px;
        border-radius: 10px; display: flex;
        align-items: center; justify-content: center;
        margin-bottom: 10px;
    }
    .stat-card:nth-child(1) .stat-card-icon { background: #eef0ff; color: #4361ee; }
    .stat-card:nth-child(2) .stat-card-icon { background: #eef0ff; color: #4361ee; }
    .stat-card:nth-child(3) .stat-card-icon { background: #fef3c7; color: #f59e0b; }
    .stat-card:nth-child(4) .stat-card-icon { background: #d1fae5; color: #10b981; }
    .stat-card-label { font-size: 0.78rem; color: #888; margin: 0 0 4px; font-weight: 500; }
    .stat-card-value { font-size: 1.6rem; font-weight: 700; color: #222; margin: 0; }
    .stat-card-value.danger { color: #ef4444; }

    /* Table section */
    .table-section {
        background: #f8f9fb; border-radius: 14px;
        padding: 24px; border: 1px solid #eee;
    }
    .table-section h3 { font-size: 1rem; font-weight: 700; color: #222; margin: 0 0 16px; }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th {
        text-align: left; font-size: 0.75rem; font-weight: 700;
        color: #888; text-transform: uppercase;
        padding: 10px 14px; border-bottom: 2px solid #e5e7eb;
    }
    .data-table td {
        padding: 12px 14px; font-size: 0.85rem; color: #444;
        border-bottom: 1px solid #f0f0f0;
    }
    .data-table tr:hover td { background: #f0f3ff; }
    .badge {
        display: inline-block; padding: 4px 14px;
        border-radius: 20px; font-size: 0.72rem;
        font-weight: 600;
    }
    .badge-danger { background: #fee2e2; color: #dc2626; }
    .badge-warning { background: #fef9c3; color: #b45309; }
    .badge-success { background: #d1fae5; color: #059669; }

    .pagination-wrap {
        display: flex; align-items: center; gap: 6px;
        margin-top: 16px;
    }
    .pagination-wrap a, .pagination-wrap span {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px; border-radius: 6px;
        font-size: 0.82rem; text-decoration: none;
        color: #666; border: 1px solid #e5e7eb;
    }
    .pagination-wrap .active { background: #4361ee; color: #fff; border-color: #4361ee; }

    .empty-state {
        text-align: center; padding: 40px;
        color: #999; font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
    {{-- Breadcrumb --}}
    <div class="breadcrumb">Dashboard</div>

    {{-- Search --}}
    <div class="search-box">
        <h2>Cari</h2>
        <div class="search-input-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" placeholder="Cari Berdasarkan Nama Koleksi">
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <p class="stat-card-label">Total Buku</p>
            <p class="stat-card-value">{{ $totalBuku }}</p>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="stat-card-label">Total Pengguna</p>
            <p class="stat-card-value">{{ $totalPengguna }}</p>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="stat-card-label">Peminjaman Aktif</p>
            <p class="stat-card-value">{{ $peminjamanAktif }}</p>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="stat-card-label">Total Denda</p>
            <p class="stat-card-value">IDR {{ number_format($totalDenda, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Tabel Peminjaman --}}
    <div class="table-section">
        <h3>Tabel Peminjaman</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $p)
                <tr>
                    <td>{{ $p->user->name ?? '-' }}</td>
                    <td>{{ $p->user->email ?? '-' }}</td>
                    <td>{{ $p->borrow_date }}</td>
                    <td>{{ $p->return_date ?? '-' }}</td>
                    <td>
                        @if($p->status == 'terlambat')
                            <span class="badge badge-danger">Terlambat</span>
                        @elseif($p->status == 'dipinjam')
                            <span class="badge badge-warning">Dipinjam</span>
                        @elseif($p->status == 'dikembalikan')
                            <span class="badge badge-success">Dikembalikan</span>
                        @else
                            <span class="badge">{{ ucfirst($p->status) }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-state">Belum ada data peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if(method_exists($peminjaman, 'links'))
        <div class="pagination-wrap">
            {{ $peminjaman->links() }}
        </div>
        @endif
    </div>
@endsection
