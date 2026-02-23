<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - LibSchool</title>
    @vite('resources/css/app.css')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }

        body { background: #f1f3f6; min-height: 100vh; display: flex; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 170px;
            min-height: 100vh;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            padding: 1.25rem 0;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            box-shadow: 2px 0 8px rgba(0,0,0,0.06);
            z-index: 100;
        }

        .sidebar-logo {
            display: flex;
            justify-content: center;
            padding: 0 1rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .logo-circle {
            width: 3.5rem; height: 3.5rem; border-radius: 9999px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(99,102,241,0.35);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 1rem 1rem 1.25rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .user-avatar {
            width: 2.2rem; height: 2.2rem; border-radius: 9999px;
            background: #e0e7ff; display: flex; align-items: center; justify-content: center;
            color: #6366f1; flex-shrink: 0;
        }

        .user-name { font-size: 0.8rem; font-weight: 600; color: #1e1b4b; line-height: 1.2; }
        .user-role { font-size: 0.7rem; color: #94a3b8; }

        .sidebar-menu { padding: 1rem 0; flex: 1; }

        .menu-label {
            font-size: 0.7rem; font-weight: 700; color: #94a3b8;
            padding: 0 1rem; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;
        }

        .menu-item {
            display: flex; align-items: center; gap: 0.6rem;
            padding: 0.6rem 1rem; font-size: 0.82rem; font-weight: 500;
            color: #64748b; text-decoration: none; border-radius: 0;
            transition: background 0.15s, color 0.15s;
            position: relative;
        }

        .menu-item:hover { background: #f5f3ff; color: #6366f1; }

        .menu-item.active {
            background: #ede9fe; color: #6366f1; font-weight: 600;
        }

        .menu-item.active::left {
            content: '';
            position: absolute; left: 0; top: 0; bottom: 0;
            width: 3px; background: #6366f1; border-radius: 0 2px 2px 0;
        }

        .menu-item svg { width: 1rem; height: 1rem; flex-shrink: 0; }

        .sidebar-footer { padding: 1rem; }

        .btn-logout {
            display: block; width: 100%;
            background: #6366f1; color: #fff;
            border: none; border-radius: 0.6rem;
            padding: 0.65rem; font-size: 0.82rem; font-weight: 600;
            cursor: pointer; text-align: center; text-decoration: none;
            transition: background 0.2s;
        }
        .btn-logout:hover { background: #4f46e5; }

        /* ===== MAIN ===== */
        .main-wrapper {
            margin-left: 170px;
            flex: 1;
            padding: 1.5rem;
            min-height: 100vh;
        }

        /* ===== KATALOG LAYOUT ===== */
        .katalog-wrapper {
            display: flex;
            gap: 1.25rem;
            align-items: flex-start;
        }

        /* Tengah */
        .main-content { flex: 1; min-width: 0; }

        /* Search Card */
        .search-card {
            background: #fff;
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
            margin-bottom: 1.25rem;
        }

        .search-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 1rem;
        }

        .search-title { font-size: 1.1rem; font-weight: 700; color: #1e1b4b; }

        .pagination-info { display: flex; align-items: center; gap: 0.5rem; }

        .page-badge {
            background: #f1f5f9; color: #64748b;
            font-size: 0.75rem; font-weight: 600;
            padding: 0.2rem 0.55rem; border-radius: 0.4rem;
        }

        .page-arrow {
            color: #94a3b8; font-size: 1.2rem; text-decoration: none;
            padding: 0 0.2rem;
        }
        .page-arrow:hover { color: #6366f1; }

        .search-input-wrap { position: relative; }

        .search-icon {
            position: absolute; left: 0.9rem; top: 50%; transform: translateY(-50%);
            color: #94a3b8;
        }

        .search-input {
            width: 100%; border: 1.5px solid #e5e7eb; border-radius: 0.6rem;
            padding: 0.65rem 1rem 0.65rem 2.5rem;
            font-size: 0.875rem; color: #1e293b; outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .search-input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.12); }
        .search-input::placeholder { color: #c4c9d4; }

        /* Books Grid */
        .books-grid {
            background: #fff;
            border-radius: 1rem;
            padding: 1.25rem;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 0.85rem;
        }

        .book-card {
            border-radius: 0.6rem;
            border: 1.5px solid #e5e7eb;
            overflow: hidden;
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s, transform 0.15s;
        }

        .book-card:hover {
            border-color: #a5b4fc;
            box-shadow: 0 4px 12px rgba(99,102,241,0.12);
            transform: translateY(-2px);
        }

        .book-card.active {
            border-color: #6366f1;
            box-shadow: 0 4px 12px rgba(99,102,241,0.2);
        }

        .book-cover {
            width: 100%; aspect-ratio: 2/3;
            background: #f8fafc;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }

        .book-cover img { width: 100%; height: 100%; object-fit: cover; }

        .book-cover-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
            background: #f8fafc;
        }

        .book-info { padding: 0.4rem 0.5rem; }
        .book-title-small { font-size: 0.7rem; font-weight: 600; color: #1e293b; line-height: 1.2; }
        .book-author-small { font-size: 0.65rem; color: #94a3b8; margin-top: 0.1rem; }

        .empty-state {
            grid-column: 1/-1; text-align: center;
            padding: 3rem; color: #94a3b8; font-size: 0.875rem;
        }

        /* ===== DETAIL PANEL ===== */
        .detail-panel {
            width: 220px;
            flex-shrink: 0;
        }

        /* Filter Bar */
        .filter-bar {
            background: #fff;
            border-radius: 0.75rem;
            padding: 0.75rem;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
            margin-bottom: 1rem;
        }

        .filter-form { display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; }

        .filter-select {
            flex: 1; min-width: 0;
            border: 1.5px solid #e5e7eb; border-radius: 0.5rem;
            padding: 0.4rem 0.5rem; font-size: 0.75rem; color: #374151;
            outline: none; background: #fff;
        }
        .filter-select:focus { border-color: #6366f1; }

        .filter-btn {
            background: #6366f1; color: #fff;
            border: none; border-radius: 0.5rem;
            padding: 0.4rem 0.75rem; font-size: 0.75rem; font-weight: 600;
            cursor: pointer; display: flex; align-items: center;
            white-space: nowrap;
            transition: background 0.2s;
        }
        .filter-btn:hover { background: #4f46e5; }

        /* Detail Card */
        .detail-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
            overflow: hidden;
        }

        .detail-cover {
            width: 100%; aspect-ratio: 3/4;
            background: #f8fafc;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
        }
        .detail-cover img { width: 100%; height: 100%; object-fit: cover; }

        .detail-cover-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center;
        }

        .detail-info { padding: 0.85rem 0.85rem 0.5rem; }

        .detail-book-title { font-size: 0.875rem; font-weight: 700; color: #1e1b4b; line-height: 1.3; }
        .detail-book-author { font-size: 0.78rem; color: #64748b; margin-top: 0.2rem; }

        .detail-stars {
            display: flex; align-items: center; gap: 0.4rem;
            margin-top: 0.5rem;
        }
        .detail-stars span:first-child { color: #f59e0b; font-size: 0.9rem; }
        .detail-rating { font-size: 0.8rem; font-weight: 700; color: #1e293b; }

        .detail-meta { display: flex; flex-wrap: wrap; gap: 0.35rem; margin-top: 0.6rem; }

        .meta-badge {
            font-size: 0.68rem; font-weight: 500;
            background: #f1f5f9; color: #64748b;
            padding: 0.2rem 0.5rem; border-radius: 0.3rem;
        }
        .meta-badge.stock.available { background: #dcfce7; color: #16a34a; }
        .meta-badge.stock.empty { background: #fee2e2; color: #dc2626; }

        .detail-actions {
            display: flex; gap: 0.5rem;
            padding: 0.85rem;
            border-top: 1px solid #f1f5f9;
        }

        .btn-detail {
            flex: 1; text-align: center;
            background: #e0e7ff; color: #6366f1;
            border: none; border-radius: 0.5rem;
            padding: 0.5rem 0.25rem; font-size: 0.72rem; font-weight: 600;
            cursor: pointer; text-decoration: none;
            transition: background 0.2s;
        }
        .btn-detail:hover { background: #c7d2fe; }

        .btn-pinjam {
            flex: 1;
            background: #6366f1; color: #fff;
            border: none; border-radius: 0.5rem;
            padding: 0.5rem 0.25rem; font-size: 0.72rem; font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-pinjam:hover { background: #4f46e5; }
        .btn-pinjam.disabled { background: #e5e7eb; color: #94a3b8; cursor: not-allowed; }

        .detail-empty {
            background: #fff;
            border-radius: 1rem;
            padding: 2rem 1rem;
            text-align: center;
            color: #94a3b8;
            font-size: 0.8rem;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        }
        .detail-empty svg { margin-bottom: 0.75rem; opacity: 0.4; }

        /* Responsive */
        @media (max-width: 1024px) {
            .books-grid { grid-template-columns: repeat(4, 1fr); }
            .detail-panel { width: 190px; }
        }

        @media (max-width: 768px) {
            .sidebar { width: 60px; }
            .sidebar-user, .menu-label, .user-name, .user-role, .menu-item span { display: none; }
            .main-wrapper { margin-left: 60px; }
            .katalog-wrapper { flex-direction: column; }
            .detail-panel { width: 100%; }
            .books-grid { grid-template-columns: repeat(3, 1fr); }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-circle">
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

        <div class="sidebar-user">
            <div class="user-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="user-name">{{ Auth::user()->name }}</p>
                <p class="user-role">{{ ucfirst(Auth::user()->role) }}</p>
            </div>
        </div>

        <nav class="sidebar-menu">
            <p class="menu-label">Menu Utama</p>

            <a href="{{ route('siswa.dashboard') }}" class="menu-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>

            <a href="{{ route('siswa.katalog') }}" class="menu-item {{ request()->routeIs('siswa.katalog*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
                <span>Katalog</span>
            </a>

            <a href="{{ route('siswa.favorite') }}" class="menu-item {{ request()->routeIs('siswa.favorite') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
                <span>Favorite</span>
            </a>

            <a href="{{ route('siswa.transaksi') }}" class="menu-item {{ request()->routeIs('siswa.transaksi') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Transaksi</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout →</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-wrapper">
        @yield('content')
    </div>

</body>
</html>