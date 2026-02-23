@extends('layouts.siswa')

@section('title', 'Favorit')

@section('content')
<div>

    {{-- Header --}}
    <div class="mb-5">
        <h1 class="text-[1.25rem] font-bold text-indigo-950">Buku Favorit</h1>
        <p class="text-slate-500 text-[0.875rem] mt-0.5">Daftar buku yang Anda simpan sebagai favorit</p>
    </div>

    {{-- Status Kosong --}}
    <div class="bg-white rounded-2xl p-12 shadow-[0_1px_6px_rgba(0,0,0,0.06)] text-center text-slate-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" class="mx-auto mb-3 opacity-40">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
        </svg>
        <p class="text-[0.95rem] font-semibold text-slate-500 mb-1.5">Belum ada buku favorit</p>
        <p class="text-[0.82rem]">Fitur ini akan segera tersedia.</p>
        <a href="{{ route('siswa.katalog') }}"
           class="inline-block mt-4 bg-indigo-500 text-white rounded-[0.6rem] px-5 py-2.5 text-[0.82rem] font-semibold no-underline hover:bg-indigo-600 transition-colors duration-200">
            Jelajahi Katalog
        </a>
    </div>

</div>
@endsection
