@extends('layouts.siswa')

@section('title', 'Katalog Buku')

@section('content')
<div>

    {{-- Header --}}
    <div class="mb-5">
        <h1 class="text-[1.25rem] font-bold text-indigo-950">Katalog Buku</h1>
        <p class="text-slate-500 text-[0.875rem] mt-0.5">Temukan buku yang ingin Anda pinjam</p>
    </div>

    {{-- Pencarian & Filter --}}
    <form method="GET" action="{{ route('siswa.katalog') }}"
          class="bg-white rounded-2xl px-5 py-4 shadow-[0_1px_6px_rgba(0,0,0,0.06)] mb-5 flex gap-3 flex-wrap items-center">

        <div class="relative flex-1 min-w-[180px]">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"
                 xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari judul atau pengarang..."
                   class="w-full border-[1.5px] border-gray-200 rounded-[0.6rem] py-2.5 pl-9 pr-4 text-[0.85rem] outline-none focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15 transition-all duration-200">
        </div>

        <select name="category"
                class="border-[1.5px] border-gray-200 rounded-[0.6rem] py-2.5 px-3 text-[0.85rem] text-gray-700 outline-none bg-white focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15 transition-all duration-200">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>

        <select name="sort"
                class="border-[1.5px] border-gray-200 rounded-[0.6rem] py-2.5 px-3 text-[0.85rem] text-gray-700 outline-none bg-white focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15 transition-all duration-200">
            <option value="title" {{ request('sort','title')=='title' ? 'selected' : '' }}>Judul A-Z</option>
            <option value="author" {{ request('sort')=='author' ? 'selected' : '' }}>Pengarang</option>
        </select>

        <button type="submit"
                class="bg-indigo-500 text-white border-0 rounded-[0.6rem] py-2.5 px-[1.1rem] text-[0.85rem] font-semibold cursor-pointer hover:bg-indigo-600 transition-colors duration-200">
            Cari
        </button>
    </form>

    {{-- Grid Buku --}}
    <div class="grid gap-4" style="grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));">
        @forelse($books as $book)
        <div class="bg-white rounded-xl border-[1.5px] border-gray-200 overflow-hidden transition-all duration-200 hover:border-indigo-300 hover:-translate-y-0.5 hover:shadow-[0_4px_12px_rgba(99,102,241,0.12)]">

            {{-- Sampul Buku --}}
            <div class="w-full bg-slate-50 flex items-center justify-center" style="aspect-ratio:2/3;">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="#c7d2fe" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>

            {{-- Info Buku --}}
            <div class="p-2.5">
                <p class="text-[0.75rem] font-semibold text-slate-800 leading-tight mb-0.5">{{ Str::limit($book->title, 30) }}</p>
                <p class="text-[0.68rem] text-slate-400">{{ $book->author }}</p>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-[0.65rem] px-1.5 py-0.5 rounded font-semibold
                        {{ $book->stock > 0 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                        {{ $book->stock > 0 ? 'Tersedia' : 'Habis' }}
                    </span>
                    @if($book->stock > 0)
                    <form method="POST" action="{{ route('siswa.pinjam', $book->id) }}">
                        @csrf
                        <button type="submit"
                                class="bg-indigo-500 text-white border-0 rounded px-2 py-1 text-[0.68rem] font-semibold cursor-pointer hover:bg-indigo-600 transition-colors duration-200">
                            Pinjam
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-slate-400">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" class="mx-auto mb-3 opacity-40">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
            </svg>
            <p class="text-[0.875rem]">Tidak ada buku yang ditemukan.</p>
        </div>
        @endforelse
    </div>

    {{-- Paginasi --}}
    <div class="mt-5">
        {{ $books->withQueryString()->links() }}
    </div>
</div>
@endsection
