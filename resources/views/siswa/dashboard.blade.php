@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="px-2">

    {{-- Sambutan --}}
    <div class="mb-6">
        <h1 class="text-[1.35rem] font-bold text-indigo-950">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-slate-500 text-[0.875rem] mt-1">Berikut ringkasan aktivitas perpustakaan Anda.</p>
    </div>

    {{-- Kartu Statistik --}}
    <div class="grid grid-cols-3 gap-4 mb-6">

        {{-- Buku Dipinjam --}}
        <div class="bg-white rounded-2xl p-5 shadow-[0_1px_6px_rgba(0,0,0,0.06)]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#6366f1" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[0.75rem] text-slate-400 font-medium">Buku Dipinjam</p>
                    <p class="text-2xl font-bold text-indigo-950">0</p>
                </div>
            </div>
        </div>

        {{-- Belum Dikembalikan --}}
        <div class="bg-white rounded-2xl p-5 shadow-[0_1px_6px_rgba(0,0,0,0.06)]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#ca8a04" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[0.75rem] text-slate-400 font-medium">Belum Dikembalikan</p>
                    <p class="text-2xl font-bold text-indigo-950">0</p>
                </div>
            </div>
        </div>

        {{-- Denda Aktif --}}
        <div class="bg-white rounded-2xl p-5 shadow-[0_1px_6px_rgba(0,0,0,0.06)]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[0.75rem] text-slate-400 font-medium">Denda Aktif</p>
                    <p class="text-2xl font-bold text-indigo-950">Rp 0</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Akses Cepat --}}
    <div class="bg-white rounded-2xl px-6 py-5 shadow-[0_1px_6px_rgba(0,0,0,0.06)]">
        <h2 class="text-[0.95rem] font-bold text-indigo-950 mb-4">Akses Cepat</h2>
        <div class="flex gap-3 flex-wrap">
            <a href="{{ route('siswa.katalog') }}"
               class="inline-flex items-center gap-2 bg-indigo-500 text-white rounded-[0.6rem] px-[1.1rem] py-2.5 text-[0.82rem] font-semibold no-underline transition-colors duration-200 hover:bg-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
                Katalog Buku
            </a>
            <a href="{{ route('siswa.transaksi') }}"
               class="inline-flex items-center gap-2 bg-indigo-100 text-indigo-500 rounded-[0.6rem] px-[1.1rem] py-2.5 text-[0.82rem] font-semibold no-underline transition-colors duration-200 hover:bg-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Riwayat Transaksi
            </a>
        </div>
    </div>

</div>
@endsection
