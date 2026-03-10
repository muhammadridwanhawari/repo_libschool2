@extends('layouts.siswa')

@section('title', 'Transaksi')

@section('content')
<div>

    {{-- Header --}}
    <div class="mb-5">
        <h1 class="text-[1.25rem] font-bold text-indigo-950">Riwayat Transaksi</h1>
        <p class="text-slate-500 text-[0.875rem] mt-0.5">Rekap peminjaman dan pengembalian buku Anda</p>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] overflow-hidden">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-4 py-3.5 text-left text-[0.78rem] font-bold text-slate-500 border-b border-slate-100">#</th>
                    <th class="px-4 py-3.5 text-left text-[0.78rem] font-bold text-slate-500 border-b border-slate-100">Judul Buku</th>
                    <th class="px-4 py-3.5 text-left text-[0.78rem] font-bold text-slate-500 border-b border-slate-100">Tanggal Pinjam</th>
                    <th class="px-4 py-3.5 text-left text-[0.78rem] font-bold text-slate-500 border-b border-slate-100">Tanggal Kembali</th>
                    <th class="px-4 py-3.5 text-left text-[0.78rem] font-bold text-slate-500 border-b border-slate-100">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($transactions as $index => $t)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-3.5 text-slate-500 text-[0.82rem] w-12">{{ $transactions->firstItem() + $index }}</td>
                    <td class="px-4 py-3.5 align-top">
                        <p class="font-semibold text-slate-700 leading-tight mb-1">{{ Str::limit($t->book->title, 45) }}</p>
                        @if($t->booking_code)
                        <p class="font-mono text-[0.7rem] text-sky-600 bg-sky-50 px-1.5 py-0.5 rounded inline-block">
                            Booking: {{ $t->booking_code }}
                        </p>
                        @endif
                    </td>
                    <td class="px-4 py-3.5 text-slate-500 text-[0.82rem] align-top">
                        {{ $t->borrow_date ? $t->borrow_date->format('d M Y') : '—' }}
                    </td>
                    <td class="px-4 py-3.5 text-slate-500 text-[0.82rem] align-top">
                        {{ $t->return_date ? $t->return_date->format('d M Y') : '—' }}
                    </td>
                    <td class="px-4 py-3.5 align-top">
                        @if($t->status === 'booking')
                            <span class="inline-flex items-center gap-1 bg-violet-50 text-violet-600 border border-violet-100 rounded-md px-2 py-0.5 text-[0.7rem] font-semibold">
                                <span class="w-1.5 h-1.5 bg-violet-400 rounded-full"></span> Menunggu Konfirmasi
                            </span>
                        @elseif($t->status === 'dipinjam')
                            <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-600 border border-yellow-100 rounded-md px-2 py-0.5 text-[0.7rem] font-semibold">
                                <span class="w-1.5 h-1.5 bg-yellow-400 rounded-full"></span> Sedang Dipinjam
                            </span>
                        @elseif($t->status === 'dikembalikan')
                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-600 border border-green-100 rounded-md px-2 py-0.5 text-[0.7rem] font-semibold">
                                <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span> Selesai
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-12 text-center text-slate-400 text-[0.875rem]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mx-auto mb-2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        Belum ada transaksi peminjaman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
