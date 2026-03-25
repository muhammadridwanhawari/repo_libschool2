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
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-5 text-[0.85rem] flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-5 text-[0.85rem] flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Pencarian --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] p-6 mb-6">
        <form method="GET" action="{{ route('penjaga.pengembalian') }}" class="flex gap-3">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari berdasarkan Kode Booking, Nama Siswa, atau Judul Buku..."
                class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-[0.88rem] outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all"
            >
            <button
                type="submit"
                class="text-white font-semibold rounded-xl px-6 py-3 text-[0.88rem] transition-colors flex items-center gap-2"
                style="background:#4361ee;"
                onmouseover="this.style.background='#3a56d4'" onmouseout="this.style.background='#4361ee'"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                Cari
            </button>
            @if($search)
            <a href="{{ route('penjaga.pengembalian') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl px-4 py-3 text-[0.88rem] transition-colors flex items-center justify-center">
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
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">KODE BOOKING</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">BUKU</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">SISWA</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">TGL PINJAM</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">DEADLINE</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">STATUS</th>
                        <th class="px-5 py-3 text-center text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">AKSI</th>
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

</div>
@endsection
