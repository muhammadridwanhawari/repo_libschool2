@extends('layouts.penjaga')

@section('title', 'Pengembalian Buku - Penjaga')

@push('styles')
<style>
    /* Pagination */
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
    .pagination-wrap nav p.text-sm.text-gray-700 { display: none !important; }

    /* Stat Cards */
    .stat-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px 24px;
        border: 1.5px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .stat-card-label { font-size: 0.8rem; color: #666; margin: 0 0 4px; font-weight: 500; }
    .stat-card-value { font-size: 2rem; font-weight: 700; color: #222; margin: 0; }
    .stat-card-value.primary  { color: #4361ee; }
    .stat-card-value.success  { color: #10b981; }
    .stat-card-value.danger   { color: #ef4444; }
    .stat-card-icon {
        width: 44px; height: 44px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; flex-shrink: 0;
    }
    .stat-card:nth-child(1) .stat-card-icon { background: #f0fdf4; color: #10b981; }
    .stat-card:nth-child(2) .stat-card-icon { background: #eef0ff; color: #4361ee; }
    .stat-card:nth-child(3) .stat-card-icon { background: #fee2e2; color: #ef4444; }

    /* Responsive */
    @media (max-width: 1024px) {
        .stat-cards { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .stat-cards { grid-template-columns: 1fr; }
        .stat-card-value { font-size: 1.6rem; }
    }
</style>
@endpush

@section('content')
<div>

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-[1.35rem] font-bold text-sky-950">Manajemen Pengembalian</h1>
        <p class="text-slate-500 text-[0.875rem] mt-1">Daftar buku yang sedang dipinjam beserta perhitungan denda keterlambatan.</p>
    </div>

    {{-- Flash Messages --}}

    {{-- Stat Cards --}}
    <div class="stat-cards">
        {{-- Card 1: Belum Dikembalikan --}}
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Belum Dikembalikan</p>
                <p class="stat-card-value success">{{ $statBelumDikembalikan }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        {{-- Card 2: Sedang Dipinjam (tepat waktu) --}}
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Sedang Dipinjam</p>
                <p class="stat-card-value primary">{{ $statSedangDipinjam }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
        {{-- Card 3: Sudah Terlambat --}}
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Sudah Terlambat</p>
                <p class="stat-card-value danger">{{ $statSudahTerlambat }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Pencarian --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] p-6 mb-6">
        <form method="GET" action="{{ route('penjaga.pengembalian') }}" class="flex gap-3 flex-wrap">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari berdasarkan Kode Booking, Nama Siswa, atau Judul Buku..."
                class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-[0.88rem] outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all"
                style="min-width: 200px;"
            >
            <button
                type="submit"
                class="text-white font-semibold rounded-xl px-6 py-3 text-[0.88rem] transition-colors flex items-center gap-2 w-full sm:w-auto justify-center"
                style="background:#4361ee;"
                onmouseover="this.style.background='#3a56d4'" onmouseout="this.style.background='#4361ee'"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                Cari
            </button>
            @if($search)
            <a href="{{ route('penjaga.pengembalian') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl px-4 py-3 text-[0.88rem] transition-colors flex items-center justify-center w-full sm:w-auto">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Tabel Pengembalian Aktif --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-slate-800 text-[1rem]">Daftar Buku Sedang Dipinjam</h2>
                <p class="text-[0.78rem] text-slate-400 mt-0.5">{{ $peminjaman->total() }} data aktif</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">KODE BOOKING</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">BUKU</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">SISWA</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">TGL PINJAM</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">DEADLINE</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">STATUS</th>
                        <th class="px-5 py-3 text-center text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($peminjaman as $p)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        {{-- Kode Booking --}}
                        <td class="px-5 py-3.5 align-middle">
                            @if($p->booking_code)
                            <span class="font-mono text-[0.75rem] text-slate-500 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                {{ $p->booking_code }}
                            </span>
                            @else
                            <span class="text-slate-400 text-[0.8rem]">—</span>
                            @endif
                        </td>
                        {{-- Buku --}}
                        <td class="px-5 py-3.5 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-11 rounded bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200 flex items-center justify-center">
                                    @if($p->book && $p->book->cover)
                                        <img src="{{ asset('storage/' . $p->book->cover) }}" alt="Cover" class="w-full h-full object-cover">
                                    @elseif($p->book && $p->book->cover_image)
                                        <img src="{{ asset('storage/' . $p->book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[150px]">
                                        {{ $p->book->title ?? '-' }}
                                    </p>
                                    <p class="text-[0.7rem] text-slate-400 truncate max-w-[150px]">
                                        {{ $p->book->author ?? '' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        {{-- Siswa --}}
                        <td class="px-5 py-3.5 align-middle">
                            <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[150px]">
                                {{ $p->user->name ?? '-' }}
                            </p>
                            <p class="text-[0.7rem] text-slate-400 truncate max-w-[150px]">
                                {{ $p->user->email ?? '' }}
                            </p>
                        </td>
                        {{-- Tgl Pinjam --}}
                        <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                            {{ $p->borrow_date ? $p->borrow_date->format('d M Y') : '—' }}
                        </td>
                        {{-- Deadline --}}
                        <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                            @if($p->deadline)
                                <span class="{{ $p->hari_terlambat > 0 ? 'text-red-500 font-semibold' : '' }}">
                                    {{ \Carbon\Carbon::parse($p->deadline)->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                        {{-- Status & Denda --}}
                        <td class="px-5 py-3.5 align-middle">
                            @if($p->hari_terlambat > 0)
                                <div class="inline-flex flex-col">
                                    <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fee2e2] text-[#dc2626] mb-1">TERLAMBAT {{ $p->hari_terlambat }} HARI</span>
                                    <span class="text-red-500 font-bold text-[0.72rem]">Rp {{ number_format($p->denda_estimasi, 0, ',', '.') }}</span>
                                </div>
                            @else
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#dcfce7] text-[#16a34a]">TEPAT WAKTU</span>
                            @endif
                        </td>
                        {{-- Aksi --}}
                        <td class="px-5 py-3.5 text-center align-middle">
                            @php
                                $pesanConfirm = "Konfirmasi pengembalian buku ini?";
                                if($p->hari_terlambat > 0) {
                                    $pesanConfirm .= "\\n\\nPERHATIAN: Buku ini terlambat dan akan dikenakan denda Rp " . number_format($p->denda_estimasi, 0, ',', '.');
                                }
                            @endphp
                            <form method="POST" action="{{ route('penjaga.pengembalian.kembalikan', $p->id) }}" onsubmit="confirmAction(event, '{{ addslashes($pesanConfirm) }}', 'Ya, Kembalikan', 'Konfirmasi Pengembalian', false); return false;">
                                @csrf
                                <button type="submit"
                                    class="text-white text-[0.75rem] font-semibold rounded-lg px-3 py-1.5 transition-colors inline-flex items-center gap-1.5"
                                    style="background:#4361ee;" onmouseover="this.style.background='#3a56d4'" onmouseout="this.style.background='#4361ee'"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    Terima Buku
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                </svg>
                                <p class="text-slate-400 text-[0.85rem]">Tidak ada buku yang sedang dipinjam saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($peminjaman->hasPages())
        <div class="pagination-wrap">
            {{ $peminjaman->links() }}
        </div>
        @endif
    </div>

    {{-- Tabel Daftar Keterlambatan --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-slate-800 text-[1rem]">Daftar Keterlambatan</h2>
                <p class="text-[0.78rem] text-slate-400 mt-0.5">{{ $dendaList->total() }} data terlambat</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">KODE BOOKING</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">BUKU</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">SISWA</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">TGL PINJAM</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">DEADLINE</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">STATUS</th>
                        <th class="px-5 py-3 text-center text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($dendaList as $p)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        {{-- Kode Booking --}}
                        <td class="px-5 py-3.5 align-middle">
                            @if($p->booking_code)
                            <span class="font-mono text-[0.75rem] text-slate-500 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                {{ $p->booking_code }}
                            </span>
                            @else
                            <span class="text-slate-400 text-[0.8rem]">—</span>
                            @endif
                        </td>
                        {{-- Buku --}}
                        <td class="px-5 py-3.5 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-11 rounded bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200 flex items-center justify-center">
                                    @if($p->book && $p->book->cover)
                                        <img src="{{ asset('storage/' . $p->book->cover) }}" alt="Cover" class="w-full h-full object-cover">
                                    @elseif($p->book && $p->book->cover_image)
                                        <img src="{{ asset('storage/' . $p->book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[150px]">{{ $p->book->title ?? '-' }}</p>
                                    <p class="text-[0.7rem] text-slate-400 truncate max-w-[150px]">{{ $p->book->author ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        {{-- Siswa --}}
                        <td class="px-5 py-3.5 align-middle">
                            <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[150px]">{{ $p->user->name ?? '-' }}</p>
                            <p class="text-[0.7rem] text-slate-400 truncate max-w-[150px]">{{ $p->user->email ?? '' }}</p>
                        </td>
                        {{-- Tgl Pinjam --}}
                        <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                            {{ $p->borrow_date ? $p->borrow_date->format('d M Y') : '—' }}
                        </td>
                        {{-- Deadline --}}
                        <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                            <span class="text-red-500 font-semibold">{{ $p->deadline ? \Carbon\Carbon::parse($p->deadline)->format('d M Y') : '—' }}</span>
                        </td>
                        {{-- Status & Denda --}}
                        <td class="px-5 py-3.5 align-middle">
                            <div class="inline-flex flex-col">
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fee2e2] text-[#dc2626] mb-1">TERLAMBAT {{ $p->hari_terlambat }} HARI</span>
                                <span class="text-red-500 font-bold text-[0.72rem]">Rp {{ number_format($p->denda_estimasi, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        {{-- Aksi --}}
                        <td class="px-5 py-3.5 text-center align-middle">
                            @php
                                $pesanConfirm = "Konfirmasi pengembalian buku ini?\\n\\nPERHATIAN: Buku ini terlambat dan akan dikenakan denda Rp " . number_format($p->denda_estimasi, 0, ',', '.');
                            @endphp
                            <form method="POST" action="{{ route('penjaga.pengembalian.kembalikan', $p->id) }}" onsubmit="confirmAction(event, '{{ addslashes($pesanConfirm) }}', 'Ya, Kembalikan', 'Konfirmasi Pengembalian', false); return false;">
                                @csrf
                                <button type="submit"
                                    class="text-white text-[0.75rem] font-semibold rounded-lg px-3 py-1.5 transition-colors inline-flex items-center gap-1.5"
                                    style="background:#ef4444;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    Terima & Denda
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                <p class="text-slate-400 text-[0.85rem]">Tidak ada buku yang terlambat saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($dendaList->hasPages())
        <div class="pagination-wrap">
            {{ $dendaList->appends(['search' => $search, 'denda_page' => request('denda_page')])->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
