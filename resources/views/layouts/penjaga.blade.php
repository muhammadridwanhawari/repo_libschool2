<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - LibSchool Penjaga</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; }

        /* Sidebar */
        .admin-sidebar {
            width: 220px;
            min-height: 100vh;
            background: #f6f6f6;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            z-index: 100;
            border-right: 1px solid #e8e8e8;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px 16px;
        }
        .sidebar-logo img {
            width: 80px;
            height: auto;
        }

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
        .sidebar-logout {
            padding: 16px 20px;
        }
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

        /* Main content */
        .admin-main {
            margin-left: 220px;
            flex: 1;
            padding: 24px 32px;
            min-height: 100vh;
            background: #fff;
        }

        /* Alert styles */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 0.85rem;
        }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-danger  { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    </style>
    @stack('styles')
</head>
<body style="display:flex; min-height:100vh; background:#fff;">

    {{-- Sidebar --}}
    <aside class="admin-sidebar">

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
                <p class="sidebar-user-role">Penjaga</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">

            {{-- Dashboard --}}
            <a href="{{ route('penjaga.dashboard') }}" class="nav-item {{ request()->routeIs('penjaga.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                <span>Dashboard</span>
            </a>

            @php
                $perms = json_decode(Auth::user()->permissions ?? '[]', true) ?? [];
                $showKelolaData = count(array_intersect(['kategori', 'buku', 'peminjaman', 'denda', 'laporan', 'series', 'pengajuan'], $perms)) > 0;
            @endphp

            @if($showKelolaData)
            {{-- Kelola Data --}}
            <div class="nav-group {{ request()->routeIs('admin.kategori.*') || request()->routeIs('admin.buku.*') || request()->routeIs('admin.peminjaman.*') || request()->routeIs('admin.denda.*') || request()->routeIs('admin.laporan.*') || request()->routeIs('admin.series.*') || request()->routeIs('admin.pengajuan.*') ? 'open' : '' }}">
                <button class="nav-group-header {{ request()->routeIs('admin.kategori.*') || request()->routeIs('admin.buku.*') || request()->routeIs('admin.peminjaman.*') || request()->routeIs('admin.denda.*') || request()->routeIs('admin.laporan.*') || request()->routeIs('admin.series.*') || request()->routeIs('admin.pengajuan.*') ? 'active' : '' }}" onclick="this.parentElement.classList.toggle('open')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>Kelola Data</span>
                    <svg class="chevron" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="nav-sub">
                    @if(in_array('kategori', $perms))
                    <a href="{{ route('admin.kategori.index') }}" class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">Kategori</a>
                    @endif
                    @if(in_array('buku', $perms))
                    <a href="{{ route('admin.buku.index') }}" class="{{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">Data Buku</a>
                    @endif
                    @if(in_array('series', $perms))
                    <a href="{{ route('admin.series.index') }}" class="{{ request()->routeIs('admin.series.*') ? 'active' : '' }}">Series Buku</a>
                    @endif
                    @if(in_array('peminjaman', $perms))
                    <a href="{{ route('admin.peminjaman.index') }}" class="{{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">Peminjaman (Admin)</a>
                    @endif
                    @if(in_array('denda', $perms))
                    <a href="{{ route('admin.denda.index') }}" class="{{ request()->routeIs('admin.denda.*') ? 'active' : '' }}">Denda</a>
                    @endif
                    @if(in_array('pengajuan', $perms))
                    <a href="{{ route('admin.pengajuan.index') }}" class="{{ request()->routeIs('admin.pengajuan.*') ? 'active' : '' }}">Pengajuan Buku</a>
                    @endif
                    @if(in_array('laporan', $perms))
                    <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">Laporan</a>
                    @endif
                </div>
            </div>
            @endif

            {{-- Peminjaman --}}
            <a href="{{ route('penjaga.peminjaman') }}" class="nav-item {{ request()->routeIs('penjaga.peminjaman*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                <span>Peminjaman</span>
            </a>

            {{-- Pengembalian --}}
            <a href="{{ route('penjaga.pengembalian') }}" class="nav-item {{ request()->routeIs('penjaga.pengembalian*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                </svg>
                <span>Pengembalian</span>
            </a>

            {{-- Inbox --}}
            @php $inboxUnread = \App\Models\Message::where('is_read', false)->count(); @endphp
            <a href="{{ route('penjaga.inbox') }}" class="nav-item {{ request()->routeIs('penjaga.inbox*') ? 'active' : '' }}" style="position:relative;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0l-8 4-8-4"/>
                </svg>
                <span>Inbox</span>
                @if($inboxUnread > 0)
                <span style="margin-left:auto; background:#ef4444; color:#fff; border-radius:9999px; font-size:0.65rem; font-weight:700; padding:1px 6px; min-width:18px; text-align:center;">{{ $inboxUnread }}</span>
                @endif
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
    <div class="admin-main">
        @yield('content')
    </div>

    @include('components.confirm-modal')
    @stack('scripts')
</body>
</html>
