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
            <tbody>
                <tr>
                    <td colspan="5" class="px-4 py-12 text-center text-slate-400 text-[0.875rem]">
                        Belum ada transaksi peminjaman.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>
@endsection
