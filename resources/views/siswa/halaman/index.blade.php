@extends('layouts.siswa')

@section('title', 'Halaman')

@push('styles')
<style>
    /* ── Hero Profile Card ── */
    .hero-card {
        background: linear-gradient(to right, #89f7fe, #a8edea, #fed6e3);
        border-radius: 20px;
        padding: 32px 36px;
        display: flex;
        align-items: center;
        gap: 28px;
        margin-bottom: 28px;
        position: relative;
        /* Removed overflow:hidden so the dropdown can escape the card */
        box-shadow: 0 10px 40px rgba(37,99,235,0.3);
        min-width: 0;
    }
    .hero-decorators {
        position: absolute; inset: 0; border-radius: 20px;
        overflow: hidden; pointer-events: none; z-index: 0;
    }
    .hero-decorators::before {
        content: ''; position: absolute; top: -60px; right: -60px;
        width: 240px; height: 240px; border-radius: 50%;
        background: rgba(255,255,255,0.06);
    }
    .hero-decorators::after {
        content: ''; position: absolute; bottom: -80px; left: 40px;
        width: 200px; height: 200px; border-radius: 50%;
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
    .hero-info { flex: 1; position: relative; z-index: 1; min-width: 0; }
    .hero-greeting { font-size: 0.8rem; font-weight: 600; color: rgba(255,255,255,0.7); margin-bottom: 4px; letter-spacing: 0.3px; }
    .hero-name { font-size: 1.5rem; font-weight: 800; color: #2c3e50; margin-bottom: 6px; line-height: 1.2; word-break: break-word; }
    .hero-sub { font-size: 0.82rem; color: #5f6f73; word-break: break-word; overflow-wrap: break-word; }
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
    .hero-points-val { font-size: 1.4rem; font-weight: 900; color: #f39c12; line-height: 1; }
    .hero-points-label { font-size: 0.72rem; color: #5f6f73; font-weight: 800; margin-top: 2px; }
    @media (max-width: 600px) {
        .hero-card { flex-direction: column; align-items: flex-start; padding: 20px; gap: 16px; }
        .hero-avatar { width: 60px; height: 60px; font-size: 1.5rem; }
        .hero-name { font-size: 1.25rem; }
        .hero-points-badge { width: 100%; justify-content: center; }
    }

    /* ── Hall of Fame Podium ── */
    .hof-card {
        background: linear-gradient(to bottom right, #a8edea, #fed6e3);
        border-radius: 20px;
        padding: 28px 32px 20px;
        border: 1px solid rgba(255,255,255,0.6);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        position: relative; overflow: hidden;
    }
    .hof-card::before {
        content: '';
        position: absolute; top: -60px; right: -60px;
        width: 200px; height: 200px; border-radius: 50%;
        background: radial-gradient(circle, rgba(255,255,255,0.4) 0%, transparent 70%);
    }
    .hof-title {
        font-size: 1.25rem; font-weight: 800; color: #2c3e50;
        display: flex; align-items: center; justify-content: flex-start; gap: 10px;
        margin-bottom: 4px;
        letter-spacing: -0.3px;
    }
    .hof-subtitle { 
        font-size: 0.8rem; color: #5f6f73; 
        text-align: left; margin-bottom: 40px; 
    }

    .hof-podium {
        display: grid;
        grid-template-columns: 1fr 1.2fr 1fr;
        align-items: flex-end;
        gap: 16px;
    }
    .hof-player { 
        display: flex; flex-direction: column; align-items: center; justify-content: flex-end; 
    }
    .hof-player-info {
        display: flex; flex-direction: column; align-items: center;
        margin-bottom: 16px;
    }
    .hof-player-center .hof-player-info {
        margin-bottom: 24px;
    }

    .crown {
        font-size: 1.8rem; margin-bottom: -12px; z-index: 10;
        filter: drop-shadow(0 0 10px rgba(255,183,0,0.8));
        animation: float 2s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .avatar-wrapper {
        position: relative;
        display: flex; flex-direction: column; align-items: center;
    }

    .hof-avatar {
        width: 72px; height: 72px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; font-weight: 900; letter-spacing: -1px;
        color: #fff; position: relative; overflow: hidden;
    }
    .hof-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
    
    .hof-avatar-sm { width: 60px; height: 60px; font-size: 1.2rem; }
    
    .hof-avatar-1 {
        background: linear-gradient(135deg, #fceabb, #f8b500);
        border: 3px solid #fff;
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }
    .hof-avatar-2 {
        background: linear-gradient(135deg, #e0e0e0, #cfcfcf);
        border: 3px solid #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .hof-avatar-3 {
        background: linear-gradient(135deg, #f6d365, #fda085);
        border: 3px solid #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .hof-rank-badge {
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        padding: 3px 12px; border-radius: 20px;
        font-size: 0.7rem; font-weight: 900; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 10;
        letter-spacing: 0.5px;
    }
    .hof-rank-1 { background: #fbbf24; color: #78350f; border: none; }
    .hof-rank-2 { background: #e2e8f0; color: #334155; border: none; }
    .hof-rank-3 { background: #ea580c; color: #fff; border: none; }

    .hof-name {
        font-size: 0.85rem; font-weight: 800; color: #2c3e50;
        text-align: center; white-space: nowrap; overflow: hidden;
        text-overflow: ellipsis; max-width: 110px;
        margin-top: 20px; text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .hof-name-1 { font-size: 1rem; color: #f39c12; }
    
    .hof-xp {
        font-size: 0.75rem; font-weight: 800; color: #f39c12; margin-top: 4px;
        letter-spacing: 0.5px;
    }

    .hof-role-pill {
        display: inline-block; padding: 2px 10px; border-radius: 12px;
        font-size: 0.6rem; font-weight: 800; margin-top: 6px;
        letter-spacing: 0.5px; text-transform: uppercase;
    }
    .hof-role-1 { border: 1px solid rgba(243,156,18,0.4); color: #f39c12; background: rgba(255,255,255,0.7); }
    .hof-role-2 { border: 1px solid rgba(95,111,115,0.3); color: #5f6f73; background: rgba(255,255,255,0.7); }
    .hof-role-3 { border: 1px solid rgba(211,84,0,0.3); color: #e67e22; background: rgba(255,255,255,0.7); }

    .hof-podium-base {
        width: 100%; border-radius: 16px; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.08); 
    }
    /* Mimic the dark UI bases in the image */
    .hof-base-1 { background: linear-gradient(to right, #fceabb, #f8b500); opacity: 0.9; height: 85px; border: 2px solid rgba(255,255,255,0.5); border-bottom: none; }
    .hof-base-2 { background: linear-gradient(to right, #e8e8e8, #d6d6d6); height: 60px; border: 2px solid rgba(255,255,255,0.5); border-bottom: none; }
    .hof-base-3 { background: linear-gradient(to right, #f6d365, #fda085); opacity: 0.95; height: 45px; border: 2px solid rgba(255,255,255,0.5); border-bottom: none; }

    .hof-empty { text-align: center; padding: 30px 0; color: #2c3e50; font-size: 0.95rem; font-weight: 600; }

    /* ── Hall of Fame List (Ranks 4-10) ── */
    .hof-list-container {
        margin-top: 36px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .hof-list-item {
        display: flex; align-items: center;
        background: rgba(255, 255, 255, 0.6); 
        backdrop-filter: blur(12px);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 0.75rem; padding: 16px 20px;
        transition: transform 0.2s, background 0.2s;
    }
    .hof-list-item:hover {
        background: rgba(255, 255, 255, 0.9); transform: translateX(4px); 
    }
    .hof-list-rank { font-size: 1.1rem; font-weight: 800; color: #f39c12; width: 32px; flex-shrink: 0; }
    .hof-list-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        margin-right: 16px; object-fit: cover; flex-shrink: 0;
        background: linear-gradient(to bottom right, #a8edea, #fed6e3); border: 2px solid #fff;
        display: flex; align-items: center; justify-content: center;
        color: #2c3e50; font-weight: 800; font-size: 0.9rem; letter-spacing: -0.5px;
    }
    .hof-list-info { flex: 1; display: flex; flex-direction: column; gap: 4px; min-width: 0; }
    .hof-list-name {
        font-size: 0.85rem; font-weight: 800; color: #2c3e50;
        text-transform: uppercase; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        letter-spacing: 0.5px;
    }
    .hof-list-role { display: flex; align-items: center; gap: 8px; }
    .hof-list-role-pill {
        background: rgba(255,255,255,0.7); border: 1px solid rgba(95,111,115,0.3);
        color: #5f6f73; padding: 2px 8px; border-radius: 6px; font-size: 0.6rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.5px;
    }
    .hof-list-role-text { font-size: 0.65rem; color: #5f6f73; font-weight: 600; }
    .hof-list-points { text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 2px; flex-shrink: 0; margin-left: 12px; }
    .hof-list-xp { font-size: 0.85rem; font-weight: 800; color: #f39c12; letter-spacing: 0.5px; }
    .hof-list-lvl { font-size: 0.65rem; font-weight: 600; color: #5f6f73; }

    /* ── Book Grid & Cards ── */
    .book-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    @media (max-width: 1300px) { .book-grid { gap: 16px; } }
    @media (max-width: 1024px) { .book-grid { grid-template-columns: repeat(4, 1fr); gap: 12px; } }
    @media (max-width: 768px) { .book-grid { grid-template-columns: repeat(3, 1fr); gap: 10px; } }
    @media (max-width: 500px) { 
        .book-grid { grid-template-columns: repeat(2, 1fr); gap: 8px; margin-bottom: 16px; }
        .book-info { padding: 8px; }
        .book-title { font-size: 0.6rem; margin-bottom: 2px; }
        .book-author { font-size: 0.5rem; }
        .book-category { font-size: 0.4rem; margin-bottom: 2px; }
        .badge-tersedia, .badge-habis { padding: 2px 4px; font-size: 0.4rem; top: 4px; right: 4px; }
        .badge-tersedia .dot, .badge-habis .dot { width: 3px; height: 3px; }
        .btn-lihat-detail { padding: 4px 6px; font-size: 0.45rem; }
    }

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



    /* ── Section title for Buku Terfavorit ── */
    .hof-title-light {
        font-size: 1.25rem; font-weight: 800; color: #1e293b;
        display: flex; align-items: center; gap: 8px; margin-bottom: 4px;
    }
    .hof-title-light svg { transition: all 0.2s; }
    .hof-subtitle-light { font-size: 0.78rem; color: #94a3b8; margin-top: -4px; margin-bottom: 24px; }
    .peringkat-container { background: #fff; border-radius: 16px; padding: 28px 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
    
    @media (max-width: 500px) {
        .peringkat-container { padding: 16px; }
        .hof-title-light { font-size: 0.95rem; }
        .hof-title-light svg { width: 16px; height: 16px; }
        .hof-subtitle-light { font-size: 0.65rem; margin-bottom: 16px; }
    }

    /* ─── MODAL NOTIFIKASI ─────────────────────────────── */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.4); z-index: 1000;
        align-items: center; justify-content: center;
        padding: 20px;
    }
    .modal-overlay.show { display: flex; }

    .modal-box {
        background: #fff; border-radius: 16px;
        width: 100%; max-width: 500px;
        max-height: 90vh; overflow-y: auto;
        padding: 28px 32px; box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        animation: modalPop 0.2s ease;
    }
    @keyframes modalPop {
        from { transform: scale(0.95); opacity: 0; }
        to   { transform: scale(1);    opacity: 1; }
    }
    .modal-box h2 {
        font-size: 1.05rem; font-weight: 700;
        color: #222; margin: 0 0 24px; padding-bottom: 14px;
        border-bottom: 1px solid #f0f0f0;
        display: flex; justify-content: space-between; align-items: center;
    }

    .btn-cancel-modal {
        padding: 9px 22px; border-radius: 8px; border: 1px solid #ddd;
        background: #fff; color: #555; font-size: 0.85rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all 0.15s;
    }
    .btn-cancel-modal:hover { background: #f5f5f5; }

    .modal-footer {
        display: flex; justify-content: flex-end; gap: 10px;
        margin-top: 22px; padding-top: 18px; border-top: 1px solid #f0f0f0;
    }
    @media (max-width: 640px) {
        .modal-box { padding: 20px 18px; }
    }
</style>
@endpush

@section('content')

@php
    $user = auth()->user();
    $initials = collect(explode(' ', strtoupper($user->username)))->map(fn($w) => $w[0] ?? '')->take(2)->join('');
@endphp

{{-- ── HERO PROFILE CARD ── --}}
<div class="hero-card">
    <div class="hero-decorators"></div>
    <div class="hero-avatar relative z-10">
        @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->username }}">
        @else
            {{ $initials }}
        @endif
    </div>
    <div class="hero-info relative z-10">
        <h1 class="hero-name">Selamat datang, {{ $user->username }} ✨</h1>
        <p class="hero-sub">Temukan cerita baru dan lanjutkan petualangan membacamu!</p>
    </div>
    
    <!-- Bagian Kanan Kumpulan Info & Notifikasi -->
    <div class="flex flex-col items-end gap-3 z-10 relative">
        @php
            $notifCount = ($hasUnpaidFine ? 1 : 0) + (isset($deadlineLoans) ? $deadlineLoans->count() : 0);
        @endphp
        
        <!-- Bell Icon / Notifikasi (DI ATAS POIN) -->
        <div>
            <button id="notifBtn" onclick="document.getElementById('modalNotif').classList.add('show')" class="relative flex items-center justify-center p-1.5 outline-none transition-transform hover:scale-105" title="Notifikasi">
                <!-- Ikon Lonceng Solid Putih + Bayangan Lembut -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 24 24" style="filter: drop-shadow(0 4px 6px rgba(0,0,0,0.15));">
                    <path d="M12 22a2 2 0 002-2H10a2 2 0 002 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4a1.5 1.5 0 00-3 0v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z" />
                </svg>
                
                @if($notifCount > 0)
                    <!-- Tanda titik merah solid dengan koordinat inline absolut untuk memastikan tidak ke tengah -->
                    <span class="absolute rounded-full" style="top: 10px; right: 10px; width: 12px; height: 12px; background-color: #ef4444; border: 2px solid transparent;"></span>
                @endif
            </button>
        </div>

        <!-- Poin Badge (Di bawah lonceng notif) -->
        <div class="hero-points-badge shadow-sm border-white/20 relative z-10 w-full justify-center sm:w-auto">
            <div class="hero-points-icon">⭐</div>
            <div>
                <div class="hero-points-val text-[#f39c12]">{{ number_format($userPoints) }}</div>
                <div class="hero-points-label text-[#5f6f73]">POIN</div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalNotif = document.getElementById('modalNotif');
        const btnCloseNotif = document.getElementById('btnCloseNotif');

        if (btnCloseNotif && modalNotif) {
            btnCloseNotif.addEventListener('click', function() {
                modalNotif.classList.remove('show');
            });
            // Click outside the modal box to close
            modalNotif.addEventListener('click', function(e) {
                if (e.target === modalNotif) {
                    modalNotif.classList.remove('show');
                }
            });
        }
    });
</script>


{{-- ── Top 10 Peminjam ── --}}
<div style="margin-bottom: 24px;">
    <div class="hof-card">
        <div class="hof-title">🏆 Top 10 Peminjam</div>
        <div class="hof-subtitle">Papan klasemen poin sementara siswa</div>

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
                <div class="hof-player-info">
                    @if($second)
                        <div class="avatar-wrapper">
                            <div class="hof-avatar hof-avatar-sm hof-avatar-2">
                                @if($second->avatar)
                                    <img src="{{ asset('storage/' . $second->avatar) }}" alt="{{ $second->name }}">
                                @else
                                    {{ hofInitials($second->name) }}
                                @endif
                            </div>
                            <div class="hof-rank-badge hof-rank-2">#2</div>
                        </div>
                        <div class="hof-name">{{ strtoupper(explode(' ', $second->name)[0]) }}</div>
                        <div class="hof-xp">{{ number_format($second->points) }} POIN</div>
                        <div class="hof-role-pill hof-role-2">SISWA</div>
                    @endif
                </div>
                <div class="hof-podium-base hof-base-2"></div>
            </div>

            {{-- #1 Tengah --}}
            <div class="hof-player hof-player-center">
                <div class="hof-player-info">
                    @if($first)
                        <div class="crown">👑</div>
                        <div class="avatar-wrapper">
                            <div class="hof-avatar hof-avatar-1">
                                @if($first->avatar)
                                    <img src="{{ asset('storage/' . $first->avatar) }}" alt="{{ $first->name }}">
                                @else
                                    {{ hofInitials($first->name) }}
                                @endif
                            </div>
                            <div class="hof-rank-badge hof-rank-1">#1</div>
                        </div>
                        <div class="hof-name hof-name-1">{{ strtoupper(explode(' ', $first->name)[0]) }}</div>
                        <div class="hof-xp">{{ number_format($first->points) }} POIN</div>
                        <div class="hof-role-pill hof-role-1">SISWA</div>
                    @endif
                </div>
                <div class="hof-podium-base hof-base-1"></div>
            </div>

            {{-- #3 Kanan --}}
            <div class="hof-player">
                <div class="hof-player-info">
                    @if($third)
                        <div class="avatar-wrapper">
                            <div class="hof-avatar hof-avatar-sm hof-avatar-3">
                                @if($third->avatar)
                                    <img src="{{ asset('storage/' . $third->avatar) }}" alt="{{ $third->name }}">
                                @else
                                    {{ hofInitials($third->name) }}
                                @endif
                            </div>
                            <div class="hof-rank-badge hof-rank-3">#3</div>
                        </div>
                        <div class="hof-name">{{ strtoupper(explode(' ', $third->name)[0]) }}</div>
                        <div class="hof-xp">{{ number_format($third->points) }} POIN</div>
                        <div class="hof-role-pill hof-role-3">SISWA</div>
                    @endif
                </div>
                <div class="hof-podium-base hof-base-3"></div>
            </div>
        </div>
        
        {{-- List Ranks 4-10 --}}
        @if($topStudents->count() > 3)
            <div class="hof-list-container">
                @foreach($topStudents->slice(3) as $index => $student)
                    @php $rank = $index + 1; @endphp
                    <div class="hof-list-item">
                        <div class="hof-list-rank">{{ $rank }}</div>
                        <div class="hof-list-avatar">
                            @if($student->avatar)
                                <img src="{{ asset('storage/' . $student->avatar) }}" alt="{{ $student->name }}">
                            @else
                                {{ hofInitials($student->name) }}
                            @endif
                        </div>
                        <div class="hof-list-info">
                            <div class="hof-list-name">{{ strtoupper($student->name) }}</div>
                            <div class="hof-list-role">
                                <span class="hof-list-role-pill">SISWA</span>
                                <span class="hof-list-role-text">• ANGGOTA AKTIF</span>
                            </div>
                        </div>
                        <div class="hof-list-points" style="justify-content: center;">
                            <div class="hof-list-xp">{{ number_format($student->points) }} POIN</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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

{{-- ═══ MODAL NOTIFIKASI ═══ --}}
<div class="modal-overlay" id="modalNotif">
    <div class="modal-box">
        <h2 id="modalTitle">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:inline; margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                Notifikasi
            </div>
            @if(isset($notifCount) && $notifCount > 0)
                <span style="background:#fee2e2; color:#dc2626; padding:3px 10px; border-radius:999px; font-size:0.75rem; font-weight:700;">{{ $notifCount }} Baru</span>
            @endif
        </h2>
        
        <div style="max-height: 400px; overflow-y: auto; display: flex; flex-direction: column; gap: 12px;">
            @if(isset($notifCount) && $notifCount == 0)
                <div style="text-align: center; padding: 40px 0; color: #94a3b8;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#e2e8f0" stroke-width="1.5" viewBox="0 0 24 24" style="margin: 0 auto 12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <p style="font-size:0.9rem;">Tidak ada notifikasi saat ini.</p>
                </div>
            @else
                @if(isset($hasUnpaidFine) && $hasUnpaidFine)
                <div style="background:#fff1f2; border:1px solid #fecdd3; border-left:4px solid #dc2626; border-radius:8px; padding:16px; display:flex; gap:12px;">
                    <div style="flex-shrink:0; margin-top:2px; color:#dc2626;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:0.95rem; font-weight:700; color:#991b1b; margin-bottom:4px;">Akun Dibatasi — Ada Denda</div>
                        <div style="font-size:0.85rem; color:#b91c1c; line-height:1.5;">Harap lunasi denda untuk meminjam buku. <br><a href="{{ route('siswa.riwayat') }}" style="font-weight:700; text-decoration:underline; display:inline-block; margin-top:4px;">Lihat Detail &rarr;</a></div>
                    </div>
                </div>
                @endif

                @if(isset($deadlineLoans) && $deadlineLoans->count() > 0)
                    @foreach($deadlineLoans as $loan)
                        @php
                            $deadlineDate = \Carbon\Carbon::parse($loan->deadline)->startOfDay();
                            $diff = now()->startOfDay()->diffInDays($deadlineDate, false);
                            $isLate = $diff < 0;
                        @endphp
                        @php
                            $bgStyle = $isLate 
                                ? 'background: #fef2f2; border: 1px solid #fecaca; border-left: 4px solid #dc2626; padding: 16px; border-radius: 8px; display: flex; gap: 12px; min-width: 0;' 
                                : 'background: #fff7ed; border: 1px solid #fed7aa; border-left: 4px solid #ea580c; padding: 16px; border-radius: 8px; display: flex; gap: 12px; min-width: 0;';
                            $iconColor = $isLate ? '#dc2626' : '#ea580c';
                            $titleColor = $isLate ? '#991b1b' : '#9a3412';
                            $textColor = $isLate ? '#b91c1c' : '#c2410c';
                        @endphp
                        <div <?php echo 'style="' . $bgStyle . '"'; ?>>
                            <div <?php echo 'style="color: ' . $iconColor . '; flex-shrink: 0; margin-top: 2px;"'; ?>>
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div>
                                <h3 <?php echo 'style="margin: 0 0 4px; font-size: 0.95rem; font-weight: 800; color: ' . $titleColor . '"'; ?>>
                                    {{ $isLate ? 'Buku Terlambat!' : 'Peringatan Deadline' }}
                                </h3>
                                <p <?php echo 'style="margin: 0; font-size: 0.85rem; color: ' . $textColor . '; line-height: 1.5;"'; ?>>
                                    Buku "<strong>{{ Str::limit($loan->book->title ?? '', 40) }}</strong>" 
                                    @if($isLate)
                                        sudah terlewat batas.
                                    @elseif($diff == 0)
                                        berakhir <strong>hari ini</strong>.
                                    @else
                                        tinggal <strong>{{ $diff }} hari</strong>.
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
        
        <div class="modal-footer">
            <button type="button" class="btn-cancel-modal" id="btnCloseNotif">Tutup Peringatan</button>
        </div>
    </div>
</div>

@endsection
