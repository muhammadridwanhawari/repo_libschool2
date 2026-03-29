@extends('layouts.penjaga')

@section('title', 'Riwayat Transaksi - Penjaga')

@section('content')
<div>

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-[1.35rem] font-bold text-sky-950">Riwayat Transaksi</h1>
        <p class="text-slate-500 text-[0.875rem] mt-1">Laporan keseluruhan peminjaman dan denda siswa.</p>
    </div>

    {{-- Pencarian --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] p-6 mb-6">
        <form method="GET" action="{{ route('penjaga.riwayat') }}" class="flex gap-3 flex-wrap">
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
                style="background:#4737FF;"
                onmouseover="this.style.background='#3a2ee0'" onmouseout="this.style.background='#4737FF'"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                Cari
            </button>
            @if($search)
            <a href="{{ route('penjaga.riwayat') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-xl px-4 py-3 text-[0.88rem] transition-colors flex items-center justify-center w-full sm:w-auto">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-[0.82rem] min-w-[700px]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Kode Booking</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Buku & Siswa</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Tgl Pinjam & Kembali</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Deadline</th>
                        <th class="text-center px-5 py-3 font-semibold text-slate-500">Status Transaksi</th>
                        <th class="text-right px-5 py-3 font-semibold text-slate-500">Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($riwayat as $p)
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
                            <div><span class="font-semibold w-12 inline-block">Pinjam:</span> {{ $p->borrow_date ? $p->borrow_date->format('d M Y') : '—' }}</div>
                            <div class="mt-1"><span class="font-semibold w-12 inline-block">Kembali:</span> {{ $p->return_date ? $p->return_date->format('d M Y') : '—' }}</div>
                        </td>
                        <td class="px-5 py-3.5 align-top">
                            <span class="text-slate-500">
                                {{ $p->deadline ? \Carbon\Carbon::parse($p->deadline)->format('d M Y') : '—' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-center align-top">
                            @if($p->status === 'booking')
                                <span class="inline-block px-3 py-1.5 min-w-[90px] text-center rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#86A2FE] text-[#2F11D3]">BOOKING</span>
                            @elseif($p->status === 'dipinjam')
                                <span class="inline-block px-3 py-1.5 min-w-[90px] text-center rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#F0EEB6] text-[#A69B00]">AKTIF</span>
                            @elseif($p->status === 'dikembalikan')
                                @if($p->fine)
                                    <span class="inline-block px-3 py-1.5 min-w-[90px] text-center rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#F8B2B4] text-[#CC0D0C]">TERLAMBAT</span>
                                @else
                                    <span class="inline-block px-3 py-1.5 min-w-[90px] text-center rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#C6F7B9] text-[#2EA800]">DIKEMBALIKAN</span>
                                @endif
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-right align-top">
                            @if($p->fine)
                                <span class="text-red-500 font-bold block text-[0.8rem]">Rp {{ number_format($p->fine->amount, 0, ',', '.') }}</span>
                                @if($p->fine->paid)
                                    <span class="text-[0.65rem] text-white bg-green-500 px-1.5 py-0.5 rounded uppercase font-bold tracking-wider">Lunas</span>
                                @else
                                    <span class="text-[0.65rem] text-white bg-red-500 px-1.5 py-0.5 rounded uppercase font-bold tracking-wider">Belum Lunas</span>
                                @endif
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-slate-400 text-[0.85rem]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mx-auto mb-2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                            Belum ada riwayat transaksi peminjaman.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($riwayat->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $riwayat->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
