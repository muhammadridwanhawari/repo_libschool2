@extends('layouts.admin')

@section('title', 'Denda')

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

    .denda-table { width: 100%; border-collapse: collapse; }
    .denda-table th {
        text-align: left; font-size: 0.72rem;
        font-weight: 700; color: #888;
        text-transform: uppercase; padding: 14px 16px;
        border-bottom: 1px solid #f0f0f0;
        background: #fafafa;
    }
    .denda-table td {
        padding: 12px 16px; font-size: 0.85rem;
        color: #444; border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .denda-table tr:last-child td { border-bottom: none; }
    .denda-table tr:hover td { background: #fff5f5; }

    .name-main { font-weight: 600; color: #222; }

    .badge {
        display: inline-block; padding: 4px 14px;
        border-radius: 20px; font-size: 0.72rem;
        font-weight: 700;
    }
    .badge-danger { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }

    .btn-detail {
        border: 1px solid #ddd; background: #fff; color: #444;
        border-radius: 6px; padding: 5px 14px;
        font-size: 0.78rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        text-decoration: none; display: inline-block;
        transition: background 0.15s;
    }
    .btn-detail:hover { background: #f5f5f5; color: #222; }

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
        <span> / Denda</span>
    </div>

    <div class="content-panel">
        {{-- Search --}}
        <form action="{{ route('admin.denda.index') }}" method="GET">
            <div class="search-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                </svg>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Nama Peminjam atau Judul Buku..">
            </div>
        </form>

        {{-- Table --}}
        <table class="denda-table">
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
                @forelse($dendaList as $p)
                <tr>
                    <td>
                        <div class="name-main">{{ $p->user->name ?? '-' }}</div>
                    </td>
                    <td>{{ $p->book->title ?? '-' }}</td>
                    <td>{{ $p->borrow_date ? $p->borrow_date->format('Y-m-d') : '-' }}</td>
                    <td>{{ $p->deadline ? $p->deadline->format('Y-m-d') : '-' }}</td>
                    <td>
                        <span class="badge badge-danger">Terlambat</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.denda.show', $p->id) }}" class="btn-detail">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:40px; color:#999;">
                        Tidak ada denda saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($dendaList->hasPages())
        <div class="pagination-wrap">
            {{ $dendaList->appends(['search' => $search])->links() }}
        </div>
        @endif
    </div>
@endsection
