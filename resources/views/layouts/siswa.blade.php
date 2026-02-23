<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - LibSchool</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#f1f3f6] min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-[170px] min-h-screen bg-white flex flex-col py-5 fixed left-0 top-0 bottom-0 z-[100] shadow-[2px_0_8px_rgba(0,0,0,0.06)]">

        {{-- Logo --}}
        <div class="flex justify-center px-4 pb-5 border-b border-slate-100">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-400 flex items-center justify-center shadow-[0_4px_12px_rgba(99,102,241,0.35)]">
                <svg width="36" height="36" viewBox="0 0 64 64" fill="white" xmlns="http://www.w3.org/2000/svg">
                    <rect x="18" y="26" width="6" height="20" rx="1.5"/>
                    <rect x="26" y="20" width="6" height="26" rx="1.5"/>
                    <rect x="34" y="24" width="6" height="22" rx="1.5"/>
                    <rect x="42" y="28" width="4" height="18" rx="1.5"/>
                    <rect x="15" y="46" width="34" height="3.5" rx="1.5"/>
                    <path d="M32 8 C24 12 16 18 16 24" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                    <path d="M32 8 C40 12 48 18 48 24" stroke="white" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                    <circle cx="32" cy="8" r="2.5"/>
                </svg>
            </div>
        </div>

        {{-- Info Pengguna --}}
        <div class="flex items-center gap-2.5 px-4 py-4 border-b border-slate-100">
            <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-[0.8rem] font-semibold text-indigo-950 leading-tight">{{ Auth::user()->name }}</p>
                <p class="text-[0.7rem] text-slate-400">Siswa</p>
            </div>
        </div>

        {{-- Menu Navigasi --}}
        <nav class="py-4 flex-1">
            <p class="text-[0.7rem] font-bold text-slate-400 px-4 mb-2 uppercase tracking-[0.05em]">Menu Utama</p>

            <a href="{{ route('siswa.dashboard') }}"
               class="flex items-center gap-2.5 px-4 py-2.5 text-[0.82rem] font-medium no-underline transition-all duration-150
                      {{ request()->routeIs('siswa.dashboard') ? 'bg-violet-50 text-indigo-500 font-semibold' : 'text-slate-500 hover:bg-violet-50 hover:text-indigo-500' }}">
                <svg class="w-4 h-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>

            <a href="{{ route('siswa.katalog') }}"
               class="flex items-center gap-2.5 px-4 py-2.5 text-[0.82rem] font-medium no-underline transition-all duration-150
                      {{ request()->routeIs('siswa.katalog*') ? 'bg-violet-50 text-indigo-500 font-semibold' : 'text-slate-500 hover:bg-violet-50 hover:text-indigo-500' }}">
                <svg class="w-4 h-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
                <span>Katalog</span>
            </a>

            <a href="{{ route('siswa.favorite') }}"
               class="flex items-center gap-2.5 px-4 py-2.5 text-[0.82rem] font-medium no-underline transition-all duration-150
                      {{ request()->routeIs('siswa.favorite') ? 'bg-violet-50 text-indigo-500 font-semibold' : 'text-slate-500 hover:bg-violet-50 hover:text-indigo-500' }}">
                <svg class="w-4 h-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
                <span>Favorit</span>
            </a>

            <a href="{{ route('siswa.transaksi') }}"
               class="flex items-center gap-2.5 px-4 py-2.5 text-[0.82rem] font-medium no-underline transition-all duration-150
                      {{ request()->routeIs('siswa.transaksi') ? 'bg-violet-50 text-indigo-500 font-semibold' : 'text-slate-500 hover:bg-violet-50 hover:text-indigo-500' }}">
                <svg class="w-4 h-4 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Transaksi</span>
            </a>
        </nav>

        {{-- Tombol Logout --}}
        <div class="p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="block w-full bg-indigo-500 text-white border-0 rounded-[0.6rem] py-2.5 text-[0.82rem] font-semibold cursor-pointer text-center transition-colors duration-200 hover:bg-indigo-600">
                    Logout →
                </button>
            </form>
        </div>
    </aside>

    {{-- Konten Utama --}}
    <div class="ml-[170px] flex-1 p-6 min-h-screen">
        @yield('content')
    </div>

</body>
</html>
