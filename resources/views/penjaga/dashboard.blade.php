@extends('layouts.penjaga')

@section('title', 'Dashboard Penjaga')

@section('content')
<div>

    {{-- Sambutan --}}
    <div class="mb-6">
        <h1 class="text-[1.35rem] font-bold text-sky-950">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-slate-500 text-[0.875rem] mt-1">Panel penjaga perpustakaan LibSchool.</p>
    </div>

    {{-- Kartu Statistik --}}
    @php
        use App\Models\Book;
        use App\Models\Borrowing;
        $totalBuku      = Book::sum('stock');
        $sedangDipinjam = Borrowing::where('status', 'dipinjam')->count();
        $belumKembali   = Borrowing::where('status', 'dipinjam')
                            ->whereNotNull('deadline')
                            ->whereDate('deadline', '<', now())
                            ->count();
        $menungguBooking = Borrowing::where('status', 'booking')->count();
    @endphp
    <div class="grid grid-cols-4 gap-4 mb-6">

        {{-- Total Buku --}}
        <div class="bg-white rounded-2xl p-5 shadow-[0_1px_6px_rgba(0,0,0,0.06)]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#0ea5e9" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[0.72rem] text-slate-400 font-medium">Total Stok Buku</p>
                    <p class="text-2xl font-bold text-sky-950">{{ $totalBuku }}</p>
                </div>
            </div>
        </div>

        {{-- Sedang Dipinjam --}}
        <div class="bg-white rounded-2xl p-5 shadow-[0_1px_6px_rgba(0,0,0,0.06)]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#ca8a04" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[0.72rem] text-slate-400 font-medium">Sedang Dipinjam</p>
                    <p class="text-2xl font-bold text-sky-950">{{ $sedangDipinjam }}</p>
                </div>
            </div>
        </div>

        {{-- Menunggu Konfirmasi --}}
        <div class="bg-white rounded-2xl p-5 shadow-[0_1px_6px_rgba(0,0,0,0.06)]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[0.72rem] text-slate-400 font-medium">Menunggu Konfirmasi</p>
                    <p class="text-2xl font-bold text-sky-950">{{ $menungguBooking }}</p>
                </div>
            </div>
        </div>

        {{-- Terlambat --}}
        <div class="bg-white rounded-2xl p-5 shadow-[0_1px_6px_rgba(0,0,0,0.06)]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[0.72rem] text-slate-400 font-medium">Terlambat</p>
                    <p class="text-2xl font-bold text-sky-950">{{ $belumKembali }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Panel Shortcut --}}
    <div class="bg-white rounded-2xl p-6 shadow-[0_1px_6px_rgba(0,0,0,0.06)]">
        <p class="text-[0.95rem] font-bold text-sky-950 mb-2">Aksi Cepat</p>
        <p class="text-[0.82rem] text-slate-500 mb-4">Proses peminjaman dan pengembalian buku siswa.</p>
        <div class="flex gap-3">
            <a href="{{ route('penjaga.peminjaman') }}"
               class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-600 text-white font-semibold rounded-xl px-5 py-2.5 text-[0.85rem] transition-colors no-underline">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                Halaman Peminjaman
            </a>
            <a href="{{ route('penjaga.pengembalian') }}"
               class="inline-flex items-center gap-2 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-xl px-5 py-2.5 text-[0.85rem] transition-colors no-underline">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                </svg>
                Halaman Pengembalian
            </a>
        </div>
    </div>

</div>
@endsection
