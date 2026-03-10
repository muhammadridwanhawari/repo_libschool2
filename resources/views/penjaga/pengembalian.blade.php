@extends('layouts.penjaga')

@section('title', 'Pengembalian Buku - Penjaga')

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
                class="bg-sky-500 hover:bg-sky-600 text-white font-semibold rounded-xl px-6 py-3 text-[0.88rem] transition-colors flex items-center gap-2"
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
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <div>
                <p class="text-[0.95rem] font-bold text-sky-950">Daftar Buku Sedang Dipinjam</p>
                <p class="text-[0.78rem] text-slate-400 mt-0.5">Konfirmasi pengembalian buku di sini</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-[0.82rem]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Kode Booking</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Buku & Siswa</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Tgl Pinjam</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Deadline</th>
                        <th class="text-center px-5 py-3 font-semibold text-slate-500">Status & Denda</th>
                        <th class="text-center px-5 py-3 font-semibold text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($peminjaman as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-5 py-3.5 align-top">
                            <span class="font-mono font-semibold text-sky-600 bg-sky-50 rounded-md px-2 py-0.5 text-[0.78rem]">
                                {{ $p->booking_code ?? '—' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 align-top">
                            <p class="font-semibold text-slate-700 leading-tight mb-1">{{ Str::limit($p->book->title, 40) }}</p>
                            <p class="text-slate-500 text-[0.75rem] flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                {{ $p->user->name }}
                            </p>
                        </td>
                        <td class="px-5 py-3.5 text-slate-500 align-top">
                            {{ $p->borrow_date ? $p->borrow_date->format('d M Y') : '—' }}
                        </td>
                        <td class="px-5 py-3.5 align-top">
                            @if($p->deadline)
                                <span class="{{ $p->hari_terlambat > 0 ? 'text-red-600 font-semibold' : 'text-slate-500' }}">
                                    {{ \Carbon\Carbon::parse($p->deadline)->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-center align-top">
                            @if($p->hari_terlambat > 0)
                                <div class="inline-flex flex-col items-center">
                                    <span class="bg-red-50 text-red-600 border border-red-100 rounded-full px-2.5 py-0.5 text-[0.7rem] font-bold mb-1">
                                        Terlambat {{ $p->hari_terlambat }} Hari
                                    </span>
                                    <span class="text-red-500 font-bold text-[0.75rem]">Rp {{ number_format($p->denda_estimasi, 0, ',', '.') }}</span>
                                </div>
                            @else
                                <span class="bg-green-50 text-green-600 border border-green-100 rounded-full px-2.5 py-0.5 text-[0.72rem] font-semibold">Tepat Waktu</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-center align-top">
                            <form method="POST" action="{{ route('penjaga.pengembalian.kembalikan', $p->id) }}" onsubmit="return confirm('Konfirmasi pengembalian buku ini?{{ $p->hari_terlambat > 0 ? '\n\nPERHATIAN: Buku ini terlambat dan akan dikenakan denda Rp ' . number_format($p->denda_estimasi, 0, ',', '.') : '' }}')">
                                @csrf
                                <button type="submit"
                                    class="bg-indigo-500 hover:bg-indigo-600 text-white text-[0.8rem] font-semibold rounded-lg px-4 py-2 transition-colors inline-flex items-center gap-1.5 w-full justify-center"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    Terima Buku
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-slate-400 text-[0.85rem]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mx-auto mb-2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                            Tidak ada buku yang sedang dipinjam saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($peminjaman->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $peminjaman->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
