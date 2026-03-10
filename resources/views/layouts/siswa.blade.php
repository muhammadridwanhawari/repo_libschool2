<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - LibSchool</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; background: #f1f3f6; min-height: 100vh; display: flex; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 160px;
            min-height: 100vh;
            background: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            z-index: 100;
            border-right: 1px solid #e8e8e8;
        }

        /* Logo */
        .sidebar-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 16px 16px;
        }
        .logo-circle {
            width: 56px; height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4361ee 0%, #6366f1 100%);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px rgba(67,97,238,0.35);
        }

        /* User info */
        .sidebar-user {
            display: flex; align-items: center; gap: 8px;
            padding: 10px 14px 14px;
            border-bottom: 1px solid #f0f0f0;
        }
        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: #eef0ff;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .user-name { font-size: 0.78rem; font-weight: 700; color: #1a1a2e; line-height: 1.1; }
        .user-role { font-size: 0.68rem; color: #aaa; }

        /* Nav */
        .sidebar-nav { flex: 1; padding: 10px 0; overflow-y: auto; }

        /* Nav item direct link */
        .nav-link {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 18px;
            font-size: 0.8rem; font-weight: 500;
            color: #555; text-decoration: none;
            transition: all 0.15s;
        }
        .nav-link:hover { background: #f0f3ff; color: #4361ee; }
        .nav-link.active { color: #4361ee; font-weight: 600; }
        .nav-link svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* Nav group (collapsible) */
        .nav-group {}
        .nav-group-header {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 18px;
            font-size: 0.8rem; font-weight: 500;
            color: #555; cursor: pointer;
            background: none; border: none; width: 100%;
            text-align: left; transition: all 0.15s;
        }
        .nav-group-header:hover { background: #f0f3ff; color: #4361ee; }
        .nav-group-header.active { color: #4361ee; font-weight: 600; }
        .nav-group-header svg { width: 16px; height: 16px; flex-shrink: 0; }
        .chevron { margin-left: auto; width: 12px !important; height: 12px !important; transition: transform 0.2s; }
        .nav-group.open .chevron { transform: rotate(180deg); }

        .nav-sub { display: none; padding-left: 42px; }
        .nav-group.open .nav-sub { display: block; }
        .nav-sub a {
            display: block; padding: 5px 10px;
            font-size: 0.77rem; color: #666; text-decoration: none;
            transition: color 0.15s; border-radius: 4px;
        }
        .nav-sub a:hover { color: #4361ee; }
        .nav-sub a.active { color: #4361ee; font-weight: 600; }

        /* Logout */
        .sidebar-logout { padding: 14px; }
        .logout-btn {
            display: block; width: 100%;
            background: linear-gradient(135deg, #4361ee, #3a56d4);
            color: #fff; border: none; border-radius: 8px;
            padding: 10px 0; font-size: 0.8rem; font-weight: 600;
            cursor: pointer; text-align: center; font-family: inherit;
            transition: all 0.2s;
        }
        .logout-btn:hover { background: linear-gradient(135deg, #3a56d4, #2f49c0); }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 160px;
            flex: 1;
            padding: 20px 24px;
            min-height: 100vh;
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- Sidebar --}}
    <aside class="sidebar">

        {{-- Logo --}}
        <div class="sidebar-logo">
            <img src="{{ asset('images/logo/LOGO.png') }}" alt="LibSchool" style="width:80px; height:auto;">
        </div>

        {{-- User Info --}}
        <div class="sidebar-user">
            <div class="user-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="#4361ee" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="user-name">{{ Auth::user()->name }}</p>
                <p class="user-role">Siswa</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">

            {{-- Beranda (dropdown: Katalog, Favorit, Saran) --}}
            <div class="nav-group {{ request()->routeIs('siswa.dashboard') || request()->routeIs('siswa.katalog*') || request()->routeIs('siswa.favorite') ? 'open' : '' }}">
                <button class="nav-group-header {{ request()->routeIs('siswa.dashboard') || request()->routeIs('siswa.katalog*') || request()->routeIs('siswa.favorite') ? 'active' : '' }}"
                    onclick="this.parentElement.classList.toggle('open')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                    <svg class="chevron" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="nav-sub">
                    <a href="{{ route('siswa.katalog') }}" class="{{ request()->routeIs('siswa.katalog*') ? 'active' : '' }}">Katalog</a>
                    <a href="{{ route('siswa.favorite') }}" class="{{ request()->routeIs('siswa.favorite') ? 'active' : '' }}">Favorit</a>
                    <a href="{{ route('siswa.dashboard') }}" class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">Saran</a>
                </div>
            </div>

            {{-- Transaksi --}}
            <a href="{{ route('siswa.transaksi') }}"
               class="nav-link {{ request()->routeIs('siswa.transaksi') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Transaksi</span>
            </a>

            {{-- Riwayat --}}
            <a href="{{ route('siswa.transaksi') }}"
               class="nav-link">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Riwayat</span>
            </a>

        </nav>

        {{-- Logout --}}
        <div class="sidebar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout →</button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="main-content">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
