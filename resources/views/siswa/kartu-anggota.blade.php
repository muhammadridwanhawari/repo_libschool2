@extends('layouts.siswa')

@section('title', 'Kartu Anggota')

@push('styles')
<style>
    .page-header { margin-bottom: 28px; }
    .page-header h1 { font-size: 1.4rem; font-weight: 700; color: #1a1a2e; margin: 0 0 4px; }
    .page-header p  { font-size: 0.85rem; color: #888; margin: 0; }

    /* ── Layout 2 kartu ─────────────────────── */
    .kartu-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        align-items: start;
    }

    /* ══════════════════════════════════════════
       CARD 1 – IDENTITAS
    ══════════════════════════════════════════ */
    .member-card {
        border-radius: 20px;
        padding: 28px 26px 22px;
        position: relative;
        overflow: hidden;
        min-height: 280px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        transition: transform 0.2s;
    }
    .member-card:hover { transform: translateY(-2px); }

    /* Verified → biru */
    .member-card.verified {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 60%, #1d4ed8 100%);
        color: #fff;
    }
    /* Unverified state */
    .unverified-state {
        display: flex; justify-content: center; align-items: center;
        min-height: 50vh; padding: 20px;
    }
    .warning-box {
        background: #fff; border-radius: 20px; border: 1px solid #fde68a;
        padding: 40px; text-align: center; max-width: 440px; width: 100%;
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.12); display: flex; flex-direction: column; align-items: center;
    }
    .warning-icon {
        width: 80px; height: 80px; border-radius: 50%; background: #fffbeb;
        color: #f59e0b; display: flex; align-items: center; justify-content: center;
        margin-bottom: 20px;
    }
    .warning-icon svg { width: 44px; height: 44px; }
    .warning-box h2 {
        font-size: 1.25rem; font-weight: 700; color: #1a1a2e; margin: 0 0 10px;
    }
    .warning-box p {
        font-size: 0.9rem; color: #666; line-height: 1.6; margin: 0;
    }

    /* Dekorasi lingkaran latar */
    .member-card::before {
        content: '';
        position: absolute;
        top: -40px; right: -40px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
        pointer-events: none;
    }
    .member-card::after {
        content: '';
        position: absolute;
        bottom: -60px; left: -30px;
        width: 220px; height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,0.06);
        pointer-events: none;
    }

    /* Logo area */
    .card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        position: relative; z-index: 1;
    }
    .card-logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .logo-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        background: rgba(255,255,255,0.25);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; font-weight: 900;
        backdrop-filter: blur(6px);
    }
    .logo-text { line-height: 1.2; }
    .logo-text .name { font-size: 0.85rem; font-weight: 700; }
    .logo-text .sub  { font-size: 0.7rem; opacity: 0.8; }

    /* Badge status */
    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 20px;
        font-size: 0.72rem; font-weight: 700;
        backdrop-filter: blur(8px);
    }
    .status-badge.verified-badge {
        background: rgba(255,255,255,0.25);
        border: 1px solid rgba(255,255,255,0.4);
    }
    .status-badge.warning-badge {
        background: rgba(0,0,0,0.12);
        border: 1px solid rgba(255,255,255,0.3);
    }
    .status-badge svg { flex-shrink: 0; }

    /* Body */
    .card-body {
        position: relative; z-index: 1;
        padding: 14px 0;
    }
    .member-id-label { font-size: 0.68rem; opacity: 0.75; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px; }
    .member-id       { font-size: 1.35rem; font-weight: 800; letter-spacing: 0.02em; margin-bottom: 16px; }

    .card-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .card-info-item .label { font-size: 0.68rem; opacity: 0.75; margin-bottom: 2px; }
    .card-info-item .value { font-size: 0.88rem; font-weight: 700; }

    /* Status pill kecil */
    .card-status-pill {
        display: inline-block;
        padding: 3px 12px; border-radius: 20px;
        font-size: 0.72rem; font-weight: 700;
        background: rgba(255,255,255,0.25);
        border: 1px solid rgba(255,255,255,0.4);
    }

    /* Footer */
    .card-footer {
        position: relative; z-index: 1;
        border-top: 1px solid rgba(255,255,255,0.25);
        padding-top: 14px;
    }
    .card-footer .footer-text { font-size: 0.7rem; opacity: 0.75; margin-bottom: 2px; }
    .card-footer .footer-copy { font-size: 0.7rem; opacity: 0.65; }



    /* ══════════════════════════════════════════
       CARD 2 – INFO TAMBAHAN
    ══════════════════════════════════════════ */
    .info-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #e8e8e8;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }
    .info-card-header {
        padding: 20px 24px 14px;
        border-bottom: 1px solid #f0f0f0;
    }
    .info-card-header h2 {
        font-size: 1rem; font-weight: 700; color: #1a1a2e; margin: 0;
    }
    .info-rows { padding: 6px 0; }
    .info-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 13px 24px;
        border-bottom: 1px solid #f7f7f7;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row .ir-label { font-size: 0.82rem; color: #888; }
    .info-row .ir-value { font-size: 0.85rem; font-weight: 600; color: #1a1a2e; text-align: right; }
    .ir-aktif  { color: #16a34a !important; }
    .ir-pending { color: #d97706 !important; }

    .info-note {
        display: flex; align-items: center; gap: 8px;
        padding: 16px 24px;
        border-top: 1px solid #f0f0f0;
        font-size: 0.78rem; color: #888;
    }
    .info-note svg { flex-shrink: 0; color: #4361ee; }

    /* Nomor anggota di card 2 */
    .member-id-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f0f3ff; color: #4361ee;
        border-radius: 8px; padding: 4px 12px;
        font-size: 0.8rem; font-weight: 700;
    }

    /* Responsive (tablet) */
    @media (max-width: 900px) {
        .kartu-wrapper { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1>Kartu Anggota</h1>
    <p>Identitas resmi Anda sebagai anggota perpustakaan</p>
</div>

@php
    $user = Auth::user();
    $memberId = 'ID-' . $user->id . '-PX-' . $user->created_at->format('Y');
    $isVerified = (bool) $user->is_verified;
    $tahunDaftar = $user->created_at->format('Y');
    $tanggalBergabung = $user->created_at->translatedFormat('d F Y');
@endphp

@if(!$isVerified)
<div class="unverified-state">
    <div class="warning-box">
        <div class="warning-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h2>Menunggu Verifikasi</h2>
        <p>Akun Anda sedang menunggu proses verifikasi oleh Admin. Kartu anggota akan aktif dan dapat digunakan setelah diverifikasi.</p>
    </div>
</div>
@else
<div class="kartu-wrapper">

    {{-- ══ CARD 1: IDENTITAS ══ --}}
    <div class="member-card verified">

        {{-- Header --}}
        <div class="card-header">
            <div class="card-logo">
                <div class="logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
                <div class="logo-text">
                    <div class="name">Perpustakaan</div>
                    <div class="sub">Digital Library</div>
                </div>
            </div>

            <div class="status-badge verified-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-.723 3.065 3.745 3.745 0 01-3.065.723A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.065-.723 3.745 3.745 0 01-.723-3.065A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 01.723-3.065 3.746 3.746 0 013.065-.723A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.065.723 3.746 3.746 0 01.723 3.065A3.745 3.745 0 0121 12z"/>
                </svg>
                Terverifikasi
            </div>
        </div>

        {{-- Body --}}
        <div class="card-body">
            <div class="member-id-label">ID Anggota</div>
            <div class="member-id">{{ $memberId }}</div>

            <div class="card-info-grid">
                <div class="card-info-item">
                    <div class="label">Nama Lengkap</div>
                    <div class="value">{{ $user->name }}</div>
                </div>
                <div class="card-info-item">
                    <div class="label">Username</div>
                    <div class="value">{{ $user->username }}</div>
                </div>
                <div class="card-info-item">
                    <div class="label">Terdaftar</div>
                    <div class="value">{{ $tahunDaftar }}</div>
                </div>
                <div class="card-info-item">
                    <div class="label">Status</div>
                    <div class="value">
                        <span class="card-status-pill">{{ $isVerified ? 'Aktif' : 'Pending' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="card-footer">
            <div class="footer-text">Berlaku selama menjadi anggota aktif</div>
            <div class="footer-copy">© {{ $tahunDaftar }} Perpustakaan Digital</div>
        </div>
    </div>

    {{-- ══ CARD 2: INFORMASI TAMBAHAN ══ --}}
    <div class="info-card">
        <div class="info-card-header">
            <h2>Informasi Tambahan</h2>
        </div>
        <div class="info-rows">
            <div class="info-row">
                <span class="ir-label">Nomor Anggota</span>
                <span class="ir-value">
                    <span class="member-id-badge">{{ $memberId }}</span>
                </span>
            </div>
            <div class="info-row">
                <span class="ir-label">Status Keanggotaan</span>
                <span class="ir-value {{ $isVerified ? 'ir-aktif' : 'ir-pending' }}">
                    {{ $isVerified ? 'Aktif' : 'Menunggu Verifikasi' }}
                </span>
            </div>
            <div class="info-row">
                <span class="ir-label">Tanggal Bergabung</span>
                <span class="ir-value">{{ $tanggalBergabung }}</span>
            </div>
            <div class="info-row">
                <span class="ir-label">Email</span>
                <span class="ir-value">{{ $user->email }}</span>
            </div>
            <div class="info-row">
                <span class="ir-label">Telepon</span>
                <span class="ir-value">{{ $user->telepon ?: '-' }}</span>
            </div>
        </div>
        <div class="info-note">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
            </svg>
            Kartu ini berlaku selama Anda menjadi anggota aktif perpustakaan
        </div>
    </div>
</div>

{{-- Footer bawah --}}
<p style="text-align:center;font-size:0.75rem;color:#bbb;margin-top:28px;">
    Kartu Anggota Berlaku Selama Menjadi Anggota Aktif | Nomor {{ $memberId }}
</p>
@endif
@endsection
