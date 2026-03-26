@extends('layouts.siswa')

@section('title', 'Halaman')

@push('styles')
<style>
    /* ── Hero Profile Card ── */
    .hero-card {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #4361ee 100%);
        border-radius: 20px;
        padding: 32px 36px;
        display: flex;
        align-items: center;
        gap: 28px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(37,99,235,0.3);
    }
    .hero-card::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 240px; height: 240px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
    }
    .hero-card::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 40px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .hero-avatar {
        width: 80px; height: 80px;
        border-radius: 50%;
        border: 3px solid rgba(255,255,255,0.5);
        background: rgba(255,255,255,0.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem; font-weight: 900; color: #fff;
        flex-shrink: 0; overflow: hidden;
        position: relative; z-index: 1;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }
    .hero-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .hero-info { flex: 1; position: relative; z-index: 1; }
    .hero-greeting { font-size: 0.8rem; font-weight: 600; color: rgba(255,255,255,0.7); margin-bottom: 4px; letter-spacing: 0.3px; }
    .hero-name { font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 6px; line-height: 1.2; }
    .hero-sub { font-size: 0.82rem; color: rgba(255,255,255,0.65); }
    .hero-points-badge {
        display: flex; align-items: center; gap: 8px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 50px;
        padding: 10px 20px;
        position: relative; z-index: 1;
        flex-shrink: 0;
    }
    .hero-points-icon { font-size: 1.5rem; }
    .hero-points-val { font-size: 1.4rem; font-weight: 900; color: #fbbf24; line-height: 1; }
    .hero-points-label { font-size: 0.72rem; color: rgba(255,255,255,0.7); font-weight: 600; margin-top: 2px; }
    @media (max-width: 600px) { .hero-card { flex-wrap: wrap; padding: 24px; } .hero-points-badge { width: 100%; justify-content: center; } }

    /* ── Hall of Fame Podium ── */
    .hof-card {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #4361ee 100%);
        border-radius: 20px;
        padding: 28px 32px 20px;
        border: 1px solid rgba(99,130,255,0.2);
        box-shadow: 0 12px 40px rgba(0,0,0,0.25);
        position: relative; overflow: hidden;
    }
    .hof-card::before {
        content: '';
        position: absolute; top: -60px; right: -60px;
        width: 200px; height: 200px; border-radius: 50%;
        background: radial-gradient(circle, rgba(67,97,238,0.12) 0%, transparent 70%);
    }
    .hof-title {
        font-size: 1.2rem; font-weight: 800; color: #fff;
        display: flex; align-items: center; justify-content: center; gap: 10px;
        margin-bottom: 4px;
        letter-spacing: -0.3px;
    }
    .hof-subtitle { font-size: 0.78rem; color: rgba(255,255,255,0.45); text-align: center; margin-bottom: 28px; }

    .hof-podium {
        display: grid;
        grid-template-columns: 1fr 1.15fr 1fr;
        align-items: flex-end;
        gap: 12px;
    }
    .hof-player { display: flex; flex-direction: column; align-items: center; gap: 6px; }
    .hof-player-center { position: relative; top: -20px; }

    .crown {
        font-size: 1.6rem; margin-bottom: -4px;
        filter: drop-shadow(0 0 10px rgba(255,183,0,0.8));
        animation: float 2s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .hof-avatar {
        width: 64px; height: 64px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; font-weight: 900; letter-spacing: -1px;
        color: #fff; position: relative;
    }
    .hof-avatar-sm { width: 54px; height: 54px; font-size: 1.1rem; }
    .hof-avatar-1 {
        background: linear-gradient(135deg, #4361ee, #6366f1);
        border: 3px solid #fbbf24;
        box-shadow: 0 0 0 4px rgba(251,191,36,0.25), 0 6px 20px rgba(67,97,238,0.5);
    }
    .hof-avatar-2 {
        background: linear-gradient(135deg, #475569, #64748b);
        border: 2px solid rgba(148,163,184,0.6);
        box-shadow: 0 4px 16px rgba(0,0,0,0.3);
    }
    .hof-avatar-3 {
        background: linear-gradient(135deg, #92400e, #b45309);
        border: 2px solid rgba(251,191,36,0.4);
        box-shadow: 0 4px 16px rgba(0,0,0,0.3);
    }

    .hof-rank-badge {
        display: inline-block; padding: 4px 16px; border-radius: 20px;
        font-size: 0.75rem; font-weight: 900; margin-top: 6px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .hof-rank-1 { background: linear-gradient(90deg, #d97706, #fbbf24); color: #fff; border: none; box-shadow: 0 4px 16px rgba(251,191,36,0.4); }
    .hof-rank-2 { background: rgba(255,255,255,0.2); color: #f8fafc; border: 1px solid rgba(255,255,255,0.4); backdrop-filter: blur(4px); }
    .hof-rank-3 { background: rgba(251,146,60,0.2); color: #fffedd; border: 1px solid rgba(251,146,60,0.4); backdrop-filter: blur(4px); }

    .hof-name {
        font-size: 0.85rem; font-weight: 800; color: #fff;
        text-align: center; white-space: nowrap; overflow: hidden;
        text-overflow: ellipsis; max-width: 90px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.15);
    }
    .hof-name-1 { font-size: 0.95rem; }
    
    .hof-points-pill {
        display: flex; align-items: center; gap: 4px;
        padding: 4px 12px; border-radius: 20px;
        font-size: 0.72rem; font-weight: 800; margin-top: 2px;
        background: rgba(251,191,36,0.25); color: #fef08a; border: 1px solid rgba(251,191,36,0.5);
    }
    .hof-points-pill-2 { background: rgba(255,255,255,0.15); color: #f1f5f9; border: 1px solid rgba(255,255,255,0.35); }
    .hof-points-pill-3 { background: rgba(251,146,60,0.2); color: #fed7aa; border: 1px solid rgba(251,146,60,0.4); }

    .hof-podium-base {
        width: 100%; border-radius: 12px 12px 4px 4px; margin-top: 14px;
        backdrop-filter: blur(8px);
    }
    .hof-base-1 { background: linear-gradient(180deg, rgba(226,232,240,0.35), rgba(226,232,240,0.05)); height: 75px; border: 1px solid rgba(226,232,240,0.5); border-bottom: none; box-shadow: inset 0 2px 10px rgba(226,232,240,0.2); }
    .hof-base-2 { background: linear-gradient(180deg, rgba(203,213,225,0.25), rgba(203,213,225,0.05)); height: 55px; border: 1px solid rgba(203,213,225,0.4); border-bottom: none; box-shadow: inset 0 2px 10px rgba(203,213,225,0.15); }
    .hof-base-3 { background: linear-gradient(180deg, rgba(148,163,184,0.2), rgba(148,163,184,0.05)); height: 45px; border: 1px solid rgba(148,163,184,0.35); border-bottom: none; box-shadow: inset 0 2px 10px rgba(148,163,184,0.1); }

    .hof-empty { text-align: center; padding: 30px 0; color: rgba(255,255,255,0.6); font-size: 0.9rem; font-weight: 500; }

    /* ── Book Grid & Cards ── */
    .book-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    @media (max-width: 1300px) { .book-grid { grid-template-columns: repeat(4, 1fr); } }
    @media (max-width: 1024px) { .book-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px) { .book-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; } }
    @media (max-width: 500px) { .book-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; } }

    .book-card {
        background: #fff; border: 1px solid #f1f5f9; border-radius: 12px; overflow: hidden;
        display: flex; flex-direction: column; transition: box-shadow 0.25s, transform 0.25s;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03); text-decoration: none; color: inherit; cursor: pointer;
    }
    .book-card:hover { transform: translateY(-4px); box-shadow: 0 16px 32px rgba(0,0,0,0.08); }
    .book-cover-area {
        background: #cfe5d5; width: 100%; aspect-ratio: 3/4; position: relative;
        display: flex; align-items: center; justify-content: center; overflow: hidden;
    }
    .book-cover-img { width: 100%; height: 100%; object-fit: cover; }
    .book-info { padding: 16px; text-align: left; background: #fff; border-top: 1px solid #f1f5f9; }
    .book-title { font-size: 1.05rem; font-weight: 800; color: #1e293b; line-height: 1.3; margin-bottom: 4px; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .book-author { font-size: 0.8rem; color: #94a3b8; font-weight: 500; }
    .book-category { font-size: 0.68rem; font-weight: 800; color: #64748b; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }

    .badge-tersedia {
        position: absolute; top: 12px; right: 12px; z-index: 10;
        background: #22c55e; color: #fff; border-radius: 9999px;
        padding: 4px 10px; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.5px;
        display: flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(34,197,94,0.3);
    }
    .badge-tersedia .dot { width: 5px; height: 5px; background: #fff; border-radius: 50%; opacity: 0.9; }

    .badge-habis {
        position: absolute; top: 12px; right: 12px; z-index: 10;
        background: #ef4444; color: #fff; border-radius: 9999px;
        padding: 4px 10px; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.5px;
        display: flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(239,68,68,0.3);
    }
    .badge-habis .dot { width: 5px; height: 5px; background: #fff; border-radius: 50%; opacity: 0.9; }

    .hover-overlay {
        position: absolute; inset: 0; background: rgba(0,0,0,0.15);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.25s ease; z-index: 15;
    }
    .book-card:hover .hover-overlay { opacity: 1; }

    .btn-lihat-detail {
        background: #fff; color: #1e293b; padding: 10px 18px; border-radius: 9999px; font-size: 0.8rem; font-weight: 700;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15); transform: translateY(15px); transition: transform 0.25s ease;
    }
    .book-card:hover .btn-lihat-detail { transform: translateY(0); }

    /* ── Aksi Cepat ── */
    .quick-actions-section {
        background: #f8f9fb; border-radius: 14px;
        padding: 24px; border: 1px solid #eee; margin-bottom: 28px;
    }
    .quick-actions-section h3 { font-size: 1rem; font-weight: 800; color: #1e293b; margin: 0 0 16px; }
    .quick-actions-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
    @media (max-width: 900px) { .quick-actions-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 500px) { .quick-actions-grid { grid-template-columns: 1fr; } }
    .quick-action-card {
        background: #fff; border-radius: 12px; padding: 20px;
        border: 1px solid #e5e7eb; display: flex; flex-direction: column;
        align-items: center; justify-content: center; gap: 12px;
        text-decoration: none; color: #444; transition: all 0.2s;
    }
    .quick-action-card:hover {
        border-color: #4361ee; box-shadow: 0 4px 12px rgba(67,97,238,0.1);
        transform: translateY(-2px); color: #4361ee;
    }
    .quick-action-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; transition: all 0.2s;
    }
    .quick-action-card:hover .quick-action-icon { background: #4361ee; color: #fff; }
    .quick-action-title { font-size: 0.9rem; font-weight: 600; text-align: center; margin: 0; }
    .icon-katalog { background: #eef0ff; color: #4361ee; }
    .icon-peminjaman { background: #ede9fe; color: #8b5cf6; }
    .icon-riwayat { background: #fef3c7; color: #f59e0b; }
    .icon-pengajuan { background: #dcfce7; color: #22c55e; }

    /* ── Section title for Buku Terfavorit ── */
    .hof-title-light {
        font-size: 1.25rem; font-weight: 800; color: #1e293b;
        display: flex; align-items: center; gap: 8px; margin-bottom: 4px;
    }
    .hof-subtitle-light { font-size: 0.78rem; color: #94a3b8; margin-top: -4px; margin-bottom: 24px; }
    .peringkat-container { background: #fff; border-radius: 16px; padding: 28px 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
</style>
@endpush

@section('content')

@php
    $user = auth()->user();
    $initials = collect(explode(' ', strtoupper($user->username)))->map(fn($w) => $w[0] ?? '')->take(2)->join('');
@endphp

{{-- ── HERO PROFILE CARD ── --}}
<div class="hero-card">
    <div class="hero-avatar">
        @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->username }}">
        @else
            {{ $initials }}
        @endif
    </div>
    <div class="hero-info">
        <p class="hero-greeting">Selamat Datang 👋</p>
        <h1 class="hero-name">{{ $user->username }}</h1>
        <p class="hero-sub">Jelajahi buku dan pantau aktivitas perpustakaan Anda di bulan {{ $now->translatedFormat('F Y') }}.</p>
    </div>
    <div class="hero-points-badge">
        <div class="hero-points-icon">⭐</div>
        <div>
            <div class="hero-points-val">{{ number_format($userPoints) }}</div>
            <div class="hero-points-label">POIN</div>
        </div>
    </div>
</div>

@if($hasUnpaidFine)
<div style="background:#fff1f2; border:1.5px solid #fecdd3; border-left:4px solid #dc2626; border-radius:10px; padding:14px 18px; margin-bottom:20px; display:flex; align-items:flex-start; gap:12px;">
    <div style="flex-shrink:0; margin-top:2px; color:#dc2626;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    </div>
    <div style="flex:1;">
        <div style="font-size:0.88rem; font-weight:700; color:#991b1b; margin-bottom:2px;">⚠️ Akun Anda Dibatasi — Ada Tagihan Denda</div>
        <div style="font-size:0.8rem; color:#b91c1c; line-height:1.55;">Anda tidak dapat meminjam buku baru sampai semua denda dilunasi. <a href="{{ route('siswa.riwayat') }}" style="font-weight:700; color:#991b1b; text-decoration:underline;">Klik di sini untuk melunasi denda →</a></div>
    </div>
</div>
@endif

@if(isset($deadlineLoans) && $deadlineLoans->count() > 0)
    <div style="margin-bottom: 28px; display: flex; flex-direction: column; gap: 12px;">
        @foreach($deadlineLoans as $loan)
            @php
                $deadlineDate = \Carbon\Carbon::parse($loan->deadline)->startOfDay();
                $diff = now()->startOfDay()->diffInDays($deadlineDate, false);
                $isLate = $diff < 0;
            @endphp
            @php
                $bgStyle = $isLate 
                    ? 'background: #fef2f2; border: 1px solid #fecaca; border-left: 4px solid #dc2626; padding: 16px 20px; border-radius: 8px; display: flex; align-items: flex-start; gap: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);' 
                    : 'background: #fff7ed; border: 1px solid #fed7aa; border-left: 4px solid #ea580c; padding: 16px 20px; border-radius: 8px; display: flex; align-items: flex-start; gap: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);';
                $iconColor = $isLate ? '#dc2626' : '#ea580c';
                $titleColor = $isLate ? '#991b1b' : '#9a3412';
                $textColor = $isLate ? '#b91c1c' : '#c2410c';
            @endphp
            <div {!! 'style="' . $bgStyle . '"' !!}>
                <div {!! 'style="color: ' . $iconColor . '; gap: 10px; flex-shrink: 0; margin-top: 2px;"' !!}>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 {!! 'style="margin: 0 0 4px; font-size: 0.95rem; font-weight: 800; color: ' . $titleColor . ';"' !!}>
                        {{ $isLate ? 'Buku Terlambat!' : 'Peringatan Deadline!' }}
                    </h3>
                    <p {!! 'style="margin: 0; font-size: 0.85rem; color: ' . $textColor . ';"' !!}>
                        Masa pinjam buku <strong>{{ $loan->book->title ?? 'Tidak diketahui' }}</strong> 
                        @if($isLate)
                            sudah terlewat. Segera kembalikan ke perpustakaan untuk menghindari penumpukan denda.
                        @elseif($diff == 0)
                            berakhir <strong>hari ini</strong>. Jangan lupa untuk segera mengembalikannya.
                        @else
                            tinggal <strong>{{ $diff }} hari lagi</strong>. Jangan lupa kembalikan tepat waktu.
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Aksi Cepat --}}
<div class="quick-actions-section">
    <h3>Aksi Cepat</h3>
    <div class="quick-actions-grid">
        <a href="{{ route('siswa.katalog') }}" class="quick-action-card">
            <div class="quick-action-icon icon-katalog">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <p class="quick-action-title">Katalog Buku</p>
        </a>
        <a href="{{ route('siswa.transaksi') }}" class="quick-action-card">
            <div class="quick-action-icon icon-peminjaman">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <p class="quick-action-title">Peminjaman</p>
        </a>
        <a href="{{ route('siswa.riwayat') }}" class="quick-action-card">
            <div class="quick-action-icon icon-riwayat">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="quick-action-title">Riwayat & Denda</p>
        </a>
        <a href="{{ route('siswa.pengajuan') }}" class="quick-action-card">
            <div class="quick-action-icon icon-pengajuan">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            </div>
            <p class="quick-action-title">Pengajuan Buku</p>
        </a>
    </div>
</div>

{{-- ── Top 3 Peminjam ── --}}
<div style="margin-bottom: 24px;">
    <div class="hof-card">
        <div class="hof-title">🏆 Top 3 Peminjam</div>
        <div class="hof-subtitle">Papan klasemen berdasarkan total poin siswa</div>

        @php
            $first  = $topStudents->get(0);
            $second = $topStudents->get(1);
            $third  = $topStudents->get(2);
            function hofInitials($name) {
                $words = explode(' ', strtoupper(trim($name)));
                if (count($words) >= 2) return $words[0][0] . $words[1][0];
                return substr($words[0], 0, 2);
            }
        @endphp

        @if($topStudents->isEmpty())
            <div class="hof-empty">Belum ada data poin siswa.</div>
        @else
        <div class="hof-podium">
            {{-- #2 Kiri --}}
            <div class="hof-player">
                @if($second)
                    <div class="hof-avatar hof-avatar-sm hof-avatar-2" style="overflow:hidden;">
                        @if($second->avatar)
                            <img src="{{ asset('storage/' . $second->avatar) }}" alt="{{ $second->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                        @else
                            {{ hofInitials($second->name) }}
                        @endif
                    </div>
                    <div class="hof-rank-badge hof-rank-2">#2</div>
                    <div class="hof-name">{{ strtoupper(explode(' ', $second->name)[0]) }}</div>
                    <div class="hof-points-pill hof-points-pill-2">⭐ {{ number_format($second->points) }} poin</div>
                @endif
                <div class="hof-podium-base hof-base-2"></div>
            </div>

            {{-- #1 Tengah --}}
            <div class="hof-player hof-player-center">
                @if($first)
                    <div class="crown">👑</div>
                    <div class="hof-avatar hof-avatar-1" style="overflow:hidden;">
                        @if($first->avatar)
                            <img src="{{ asset('storage/' . $first->avatar) }}" alt="{{ $first->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                        @else
                            {{ hofInitials($first->name) }}
                        @endif
                    </div>
                    <div class="hof-rank-badge hof-rank-1">#1</div>
                    <div class="hof-name hof-name-1">{{ strtoupper(explode(' ', $first->name)[0]) }}</div>
                    <div class="hof-points-pill">⭐ {{ number_format($first->points) }} poin</div>
                @endif
                <div class="hof-podium-base hof-base-1"></div>
            </div>

            {{-- #3 Kanan --}}
            <div class="hof-player">
                @if($third)
                    <div class="hof-avatar hof-avatar-sm hof-avatar-3" style="overflow:hidden;">
                        @if($third->avatar)
                            <img src="{{ asset('storage/' . $third->avatar) }}" alt="{{ $third->name }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                        @else
                            {{ hofInitials($third->name) }}
                        @endif
                    </div>
                    <div class="hof-rank-badge hof-rank-3">#3</div>
                    <div class="hof-name">{{ strtoupper(explode(' ', $third->name)[0]) }}</div>
                    <div class="hof-points-pill hof-points-pill-3">⭐ {{ number_format($third->points) }} poin</div>
                @endif
                <div class="hof-podium-base hof-base-3"></div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="peringkat-container" style="margin-top: 24px;">
    {{-- Buku Terfavorit (Grid of 5 Books) --}}
    <div class="hof-title-light" style="margin-bottom: 12px; font-size: 1.25rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#4361ee" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        Buku Terfavorit Bulan Ini
    </div>
    <div class="hof-subtitle-light" style="margin-top:-6px; margin-bottom: 24px;">5 Buku paling sering dipinjam bulan {{ $now->translatedFormat('F Y') }}</div>

    @if($topBooks->isEmpty())
        <div class="hof-empty" style="padding: 40px; background: #f8fafc; border-radius: 12px;">Belum ada peminjaman buku bulan ini.</div>
    @else
        <div class="book-grid">
            @foreach($topBooks as $book)
            <div class="book-card" data-url="{{ route('siswa.katalog.show', $book->id) }}" onclick="window.location.href=this.dataset.url;">
                {{-- Cover Area --}}
                <div class="book-cover-area">
                    @if($book->stock > 0)
                        <div class="badge-tersedia"><div class="dot"></div> TERSEDIA</div>
                    @else
                        <div class="badge-habis"><div class="dot"></div> HABIS</div>
                    @endif

                    @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" class="book-cover-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="book-icon-wrapper" style="display:none; color:#84a98c; padding:20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>
                            </svg>
                        </div>
                    @else
                        <div class="book-icon-wrapper" style="color:#84a98c; padding:20px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                            </svg>
                        </div>
                    @endif

                    <div class="hover-overlay">
                        <span class="btn-lihat-detail">Lihat detail: {{ \Illuminate\Support\Str::limit($book->title, 20) }}</span>
                    </div>
                </div>

                {{-- Info Area --}}
                <div class="book-info">
                    <p class="book-category">{{ $book->categories->isNotEmpty() ? $book->categories->pluck('name')->join(', ') : ($book->category->name ?? 'UMUM') }}</p>
                    <p class="book-title" title="{{ $book->title }}">{{ $book->title }}</p>
                    <p class="book-author">{{ $book->author ?? 'Tidak diketahui' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
