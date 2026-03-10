@extends('layouts.admin')

@section('title', 'Peminjaman')

@push('styles')
<style>
    .breadcrumb { font-size: 0.85rem; margin-bottom: 20px; }
    .breadcrumb a { color: #4361ee; text-decoration: none; }
    .breadcrumb span { color: #666; }

    .content-panel {
        background: #fff; border-radius: 14px;
        border: 1px solid #eee; overflow: hidden;
    }

    .search-wrap {
        display: flex; align-items: center; gap: 10px;
        background: #fff; border-radius: 10px;
        border: 1px solid #ddd; padding: 10px 16px;
        margin: 16px 16px 0;
    }
    .search-wrap svg { color: #bbb; flex-shrink: 0; }
    .search-wrap input {
        flex: 1; border: none; outline: none;
        font-size: 0.9rem; color: #555; background: transparent;
        font-family: inherit;
    }

    .pinjam-table { width: 100%; border-collapse: collapse; }
    .pinjam-table th {
        text-align: left; font-size: 0.72rem;
        font-weight: 700; color: #888;
        text-transform: uppercase; padding: 14px 16px;
        border-bottom: 1px solid #f0f0f0;
        background: #fafafa;
    }
    .pinjam-table td {
        padding: 12px 16px; font-size: 0.85rem;
        color: #444; border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .pinjam-table tr:last-child td { border-bottom: none; }
    .pinjam-table tr:hover td { background: #f8f9ff; }

    .name-main { font-weight: 600; color: #222; }
    .name-sub { font-size: 0.75rem; color: #888; }

    /* Badges */
    .badge {
        display: inline-block; padding: 4px 14px;
        border-radius: 20px; font-size: 0.72rem;
        font-weight: 700; white-space: nowrap;
    }
    .badge-danger { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
    .badge-warning { background: #fef9c3; color: #92400e; border: 1px solid #fde68a; }
    .badge-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }

    /* Action buttons */
    .action-btns { display: flex; gap: 6px; align-items: center; }
    .btn-detail {
        border: 1px solid #ddd; background: #fff; color: #444;
        border-radius: 6px; padding: 5px 14px;
        font-size: 0.78rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        text-decoration: none; display: inline-block;
        transition: background 0.15s;
    }
    .btn-detail:hover { background: #f5f5f5; color: #222; }
    .btn-denda {
        border: 1px solid #fca5a5; background: #fff; color: #dc2626;
        border-radius: 6px; padding: 5px 14px;
        font-size: 0.78rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        text-decoration: none; display: inline-block;
        transition: background 0.15s;
    }
    .btn-denda:hover { background: #fee2e2; }

    .pagination-wrap {
        padding: 16px; border-top: 1px solid #f0f0f0;
        display: flex; align-items: center; gap: 4px;
    }
    .pagination-wrap a, .pagination-wrap span {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: 6px;
        font-size: 0.8rem; text-decoration: none;
        color: #666; border: 1px solid #e5e7eb;
    }
    .pagination-wrap .active { background: #4361ee; color: #fff; border-color: #4361ee; }
</style>
@endpush

@section('content')
    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Kelola Data</a>
        <span> / Peminjaman</span>
    </div>

    <div class="content-panel">
        {{-- Search --}}
        <form action="{{ route('admin.peminjaman.index') }}" method="GET">
            <div class="search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Nama Peminjam atau Judul Buku..">
            </div>
        </form>

        {{-- Table --}}
        <table class="pinjam-table">
            <thead>
                <tr>
                    <th>NAMA PEMINJAM</th>
                    <th>JUDUL BUKU</th>
                    <th>TGL PINJAM</th>
                    <th>DEADLINE</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowings as $p)
                @php
                    $statusDisplay = $p->status_display;
                @endphp
                <tr>
                    <td>
                        <div class="name-main">{{ $p->user->name ?? '-' }}</div>
                        {{-- <div class="name-sub">{{ $p->user->email ?? '' }}</div> --}}
                    </td>
                    <td>{{ $p->book->title ?? '-' }}</td>
                    <td>{{ $p->borrow_date ? $p->borrow_date->format('Y-m-d') : '-' }}</td>
                    <td>{{ $p->deadline ? $p->deadline->format('Y-m-d') : '-' }}</td>
                    <td>
                        @if($statusDisplay === 'terlambat')
                            <span class="badge badge-danger">Terlambat</span>
                        @elseif($statusDisplay === 'dipinjam')
                            <span class="badge badge-warning">Dipinjam</span>
                        @else
                            <span class="badge badge-success">Dikembalikan</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.peminjaman.show', $p->id) }}" class="btn-detail">Detail</a>
                            @if($statusDisplay === 'terlambat')
                                <a href="{{ route('admin.denda.show', $p->id) }}" class="btn-denda">Denda</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:40px; color:#999;">
                        Belum ada data peminjaman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($borrowings->hasPages())
        <div class="pagination-wrap">
            {{ $borrowings->appends(['search' => $search])->links() }}
        </div>
        @endif
    </div>
@endsection
