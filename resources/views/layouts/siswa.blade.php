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
        body { font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; background: #f1f3f6; min-height: 100vh; display: flex; overflow-x: hidden; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            z-index: 300;
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
            flex-shrink: 0; overflow: hidden;
        }
        .user-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
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
            white-space: nowrap;
        }
        .nav-link:hover { background: #f0f3ff; color: #4361ee; }
        .nav-link.active { color: #4361ee; font-weight: 600; }
        .nav-link svg { width: 16px; height: 16px; flex-shrink: 0; }

        /* Nav group (collapsible) */
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
            margin-left: 260px;
            flex: 1;
            padding: 20px 24px;
            min-height: 100vh;
            min-width: 0;
            overflow-x: hidden;
        }

        /* ===== MOBILE HEADER & OVERLAY ===== */
        .mobile-header {
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
        .mobile-header-logo { width: 30px; height: auto; object-fit: contain; display: block; }
        .topbar-title { font-size: 0.9rem; font-weight: 700; color: #222; flex: 1; margin: 0; }
        .mobile-toggle {
            background: none; border: none;
            padding: 6px; cursor: pointer;
            border-radius: 8px; color: #444;
            display: flex; align-items: center; justify-content: center;
            transition: background 0.15s;
        }
        .mobile-toggle:hover { background: #f0f0f0; }

        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.45); z-index: 250;
            opacity: 0; transition: opacity 0.3s;
        }
        .sidebar-overlay.active { opacity: 1; }

        @media (max-width: 900px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.open { transform: translateX(0); }
            .main-content {
                margin-left: 0;
                padding: 72px 16px 24px;
            }
            .mobile-header { display: flex; }
            .sidebar-overlay { display: block; pointer-events: none; }
            .sidebar-overlay.active { pointer-events: auto; }
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- Mobile Header --}}
    <header class="mobile-header">
        <button class="mobile-toggle" id="mobileToggle" aria-label="Buka menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="3" y1="6"  x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>
        <img src="{{ asset('images/logo/LOGO.png') }}" alt="LibSchool" class="mobile-header-logo">
        <span class="topbar-title">@yield('title', 'Dashboard')</span>
    </header>

    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Sidebar --}}
    <aside class="sidebar">

        {{-- Logo --}}
        <div class="sidebar-logo">
            <img src="{{ asset('images/logo/LOGO.png') }}" alt="LibSchool" style="width:80px; height:auto;">
        </div>

        {{-- User Info --}}
        <div class="sidebar-user">
            <div class="user-avatar">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="#4361ee" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                @endif
            </div>
            <div>
                <p class="user-name">{{ Auth::user()->username }}</p>
                <p class="user-role">Siswa</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">

            {{-- Halaman --}}
            <a href="{{ route('siswa.halaman') }}" class="nav-link {{ request()->routeIs('siswa.halaman') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-1.81.588l1.234 5.395c.148.647-.53 1.15-1.071.802L12 17.584a.563.563 0 00-.56 0l-4.725 2.81c-.541.348-1.219-.155-1.071-.802l1.234-5.395a.563.563 0 00-1.81-.588L.863 10.386c-.38-.325-.178-.948.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                </svg>
                <span>Halaman</span>
            </a>

            {{-- Katalog Buku (semua bisa akses) --}}
            <a href="{{ route('siswa.katalog') }}" class="nav-link {{ request()->routeIs('siswa.katalog*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.315 48.315 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                </svg>
                <span>Katalog Buku</span>
            </a>

            {{-- Pinjaman Saya (semua bisa akses) --}}
            <a href="{{ route('siswa.transaksi') }}" class="nav-link {{ request()->routeIs('siswa.transaksi') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.122A60.07 60.07 0 0012 7.5a60.07 60.07 0 00-8.25.622m16.5 0v10.5a2.25 2.25 0 01-2.25 2.25h-12a2.25 2.25 0 01-2.25-2.25V8.122m16.5 0a2.25 2.25 0 00-2.25-2.25h-12a2.25 2.25 0 00-2.25 2.25m16.5 0h-16.5m11.25 4.5L12 17.25l-3.75-3.75m7.5 0h-7.5m3.75-4.5v8.25" />
                </svg>
                <span>Pinjaman Saya</span>
            </a>

            {{-- Riwayat & Denda (semua bisa akses) --}}
            <a href="{{ route('siswa.riwayat') }}" class="nav-link {{ request()->routeIs('siswa.riwayat') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                </svg>
                <span>Riwayat & Denda</span>
            </a>

            {{-- Koleksi Saya (semua bisa akses) --}}
            <a href="{{ route('siswa.favorite') }}" class="nav-link {{ request()->routeIs('siswa.favorite') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.5 3a2.5 2.5 0 0 1 2.5 2.5v14.536a.75.75 0 0 1-1.22.58l-5.918-4.733a1.5 1.5 0 0 0-1.724 0L5.22 20.616A.75.75 0 0 1 4 20.036V5.5A2.5 2.5 0 0 1 6.5 3h11Z" />
                </svg>
                <span>Koleksi Saya</span>
            </a>

            {{-- Menu berikut hanya untuk siswa terverifikasi --}}
            @if(Auth::user()->is_verified)



            {{-- Pengajuan Saya --}}
            <a href="{{ route('siswa.pengajuan') }}" class="nav-link {{ request()->routeIs('siswa.pengajuan') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                <span>Pengajuan Saya</span>
            </a>



            @endif

            {{-- Pengaturan (semua bisa akses) --}}
            <a href="{{ route('siswa.profil') }}" class="nav-link {{ request()->routeIs('siswa.profil*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Pengaturan</span>
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

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.getElementById('mobileToggle');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
            }

            if (mobileToggle) mobileToggle.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);
            
            // Close sidebar when clicking a nav link on mobile
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 900) {
                        toggleSidebar();
                    }
                });
            });
        });
    </script>
    @include('components.confirm-modal')
    @stack('scripts')
</body>
</html>
