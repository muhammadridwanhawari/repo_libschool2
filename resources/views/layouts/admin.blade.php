<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - LibSchool Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; }

        /* ── Sidebar ── */
        .admin-sidebar {
            width: 220px;
            min-height: 100vh;
            background: #f6f6f6;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            z-index: 300;
            border-right: 1px solid #e8e8e8;
            transition: transform 0.28s cubic-bezier(.4,0,.2,1);
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px 16px;
        }
        .sidebar-logo img { width: 80px; height: auto; }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            border-bottom: 1px solid #e0e0e0;
        }
        .sidebar-user-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: #e0e0e0;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sidebar-user-avatar svg { color: #888; }
        .sidebar-user-info p { margin: 0; }
        .sidebar-user-name { font-size: 0.82rem; font-weight: 600; color: #222; }
        .sidebar-user-role { font-size: 0.7rem; color: #888; }

        /* Nav */
        .sidebar-nav { flex: 1; padding: 12px 0; overflow-y: auto; }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 20px;
            font-size: 0.84rem; font-weight: 500;
            color: #444; text-decoration: none;
            transition: all 0.15s;
            cursor: pointer;
            border: none; background: none; width: 100%; text-align: left;
        }
        .nav-item:hover { background: #eaeaea; color: #222; }
        .nav-item.active { color: #4361ee; font-weight: 600; }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* Dropdown */
        .nav-group-header {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 20px;
            font-size: 0.84rem; font-weight: 500;
            color: #444; cursor: pointer;
            border: none; background: none; width: 100%; text-align: left;
            transition: all 0.15s;
        }
        .nav-group-header:hover { background: #eaeaea; color: #222; }
        .nav-group-header.active { color: #4361ee; font-weight: 600; }
        .nav-group-header svg { width: 18px; height: 18px; flex-shrink: 0; }
        .nav-group-header .chevron {
            margin-left: auto; width: 14px; height: 14px;
            transition: transform 0.2s;
        }
        .nav-group.open .chevron { transform: rotate(180deg); }

        .nav-sub { display: none; padding-left: 48px; }
        .nav-group.open .nav-sub { display: block; }
        .nav-sub a {
            display: block; padding: 7px 12px;
            font-size: 0.8rem; color: #666;
            text-decoration: none; transition: all 0.15s;
        }
        .nav-sub a:hover { color: #4361ee; }
        .nav-sub a.active { color: #4361ee; font-weight: 600; }

        /* Logout */
        .sidebar-logout { padding: 16px 20px; }
        .logout-btn {
            display: block; width: 100%;
            background: linear-gradient(135deg, #4361ee, #3a56d4);
            color: #fff; border: none;
            border-radius: 10px; padding: 11px 0;
            font-size: 0.84rem; font-weight: 600;
            cursor: pointer; text-align: center;
            transition: all 0.2s;
        }
        .logout-btn:hover {
            background: linear-gradient(135deg, #3a56d4, #2f49c0);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(67,97,238,0.3);
        }

        /* ── Mobile Topbar ── */
        .admin-topbar {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 56px;
            background: #fff;
            border-bottom: 1px solid #e8e8e8;
            align-items: center;
            padding: 0 16px;
            z-index: 200;
            gap: 12px;
        }
        .topbar-logo img { width: 30px; height: auto; }
        .topbar-title { font-size: 0.9rem; font-weight: 700; color: #222; flex: 1; }
        .hamburger-btn {
            background: none; border: none;
            padding: 6px; cursor: pointer;
            border-radius: 8px; color: #444;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s;
        }
        .hamburger-btn:hover { background: #f0f0f0; }

        /* ── Sidebar Overlay ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 250;
        }
        .sidebar-overlay.active { display: block; }

        .admin-main {
            margin-left: 220px;
            flex: 1;
            padding: 24px 32px;
            min-height: 100vh;
            background: #fff;
            min-width: 0;
        }

        /* Alert styles */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 0.85rem;
        }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* Status Badges */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            min-width: 100px;
            text-align: center;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border: none;
        }
        .badge-warning { background-color: #F0EEB6 !important; color: #A69B00 !important; }
        .badge-danger  { background-color: #F8B2B4 !important; color: #CC0D0C !important; }
        .badge-success { background-color: #C6F7B9 !important; color: #2EA800 !important; }
        .badge-primary { background-color: #86A2FE !important; color: #2F11D3 !important; }

        /* ── Responsive: Tablet ── */
        @media (max-width: 1024px) {
            .admin-main { padding: 24px 20px; }
        }

        /* ── Responsive: Mobile ── */
        @media (max-width: 768px) {
            .admin-topbar { display: flex; }
            .admin-sidebar {
                transform: translateX(-100%);
                box-shadow: 4px 0 20px rgba(0,0,0,0.12);
            }
            .admin-sidebar.open { transform: translateX(0); }
            .admin-main {
                margin-left: 0;
                padding: 72px 16px 24px;
            }
        }
    </style>
    @stack('styles')
<body style="display:flex; min-height:100vh; background:#fff;">

    {{-- [MEDIUM-A04] Fix: Skip to main content link --}}

    {{-- Mobile Topbar --}}
    <header class="admin-topbar">
        <button class="hamburger-btn" id="sidebarToggle" aria-label="Buka menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="3" y1="6"  x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>
        <div class="topbar-logo">
            <img src="{{ asset('images/logo/LOGO.png') }}" alt="LibSchool">
        </div>
        <span class="topbar-title">@yield('title', 'Dashboard')</span>
    </header>

    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="adminSidebar">

        {{-- Logo --}}
        <div class="sidebar-logo">
            <img src="{{ asset('images/logo/LOGO.png') }}" alt="LibSchool">
        </div>

        {{-- User Info --}}
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div class="sidebar-user-info">
                <p class="sidebar-user-name">{{ Auth::user()->name }}</p>
                <p class="sidebar-user-role">Admin</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            {{-- Kelola Data --}}
            <div class="nav-group {{ request()->routeIs('admin.kategori.*') || request()->routeIs('admin.series.*') || request()->routeIs('admin.buku.*') || request()->routeIs('admin.peminjaman.*') || request()->routeIs('admin.denda.*') ? 'open' : '' }}">
                <button class="nav-group-header {{ request()->routeIs('admin.kategori.*') || request()->routeIs('admin.series.*') || request()->routeIs('admin.buku.*') || request()->routeIs('admin.peminjaman.*') || request()->routeIs('admin.denda.*') ? 'active' : '' }}" onclick="this.parentElement.classList.toggle('open')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>Kelola Data</span>
                    <svg class="chevron" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="nav-sub">
                    <a href="{{ route('admin.kategori.index') }}" class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">Kategori</a>
                    <a href="{{ route('admin.series.index') }}" class="{{ request()->routeIs('admin.series.*') ? 'active' : '' }}">Series Buku</a>
                    <a href="{{ route('admin.buku.index') }}" class="{{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">Data Buku</a>
                    <a href="{{ route('admin.peminjaman.index') }}" class="{{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">Peminjaman</a>
                    <a href="{{ route('admin.denda.index') }}" class="{{ request()->routeIs('admin.denda.*') ? 'active' : '' }}">Denda</a>
                </div>
            </div>

            {{-- Kelola Pengguna --}}
            <div class="nav-group {{ request()->routeIs('admin.pengguna.*') || request()->routeIs('admin.hakakses*') || request()->routeIs('admin.verifikasi*') ? 'open' : '' }}">
                <button class="nav-group-header {{ request()->routeIs('admin.pengguna.*') || request()->routeIs('admin.hakakses*') || request()->routeIs('admin.verifikasi*') ? 'active' : '' }}" onclick="this.parentElement.classList.toggle('open')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Kelola Pengguna</span>
                    <svg class="chevron" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="nav-sub">
                    <a href="{{ route('admin.pengguna.index') }}" class="{{ request()->routeIs('admin.pengguna.*') ? 'active' : '' }}">Data Pengguna</a>
                    <a href="{{ route('admin.hakakses') }}" class="{{ request()->routeIs('admin.hakakses*') ? 'active' : '' }}">Hak Akses</a>
                    <a href="{{ route('admin.verifikasi') }}" class="{{ request()->routeIs('admin.verifikasi*') ? 'active' : '' }}">Verifikasi Anggota</a>
                </div>
            </div>

            {{-- Laporan --}}
            <a href="{{ route('admin.laporan.index') }}" class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Laporan</span>
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
    <div class="admin-main" id="main-content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>

    @include('components.confirm-modal')
    @stack('scripts')

    <script>
        const sidebarToggle  = document.getElementById('sidebarToggle');
        const adminSidebar   = document.getElementById('adminSidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            adminSidebar.classList.add('open');
            sidebarOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            adminSidebar.classList.remove('open');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        sidebarToggle.addEventListener('click', openSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);
    </script>
</body>
</html>
