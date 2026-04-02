@extends('layouts.siswa')

@section('title', 'Pengaturan')

@push('styles')
<style>
    .page-header { margin-bottom: 28px; }
    .page-header h1 { font-size: 1.4rem; font-weight: 700; color: #1a1a2e; margin: 0 0 4px; }
    .page-header p  { font-size: 0.85rem; color: #888; margin: 0; }

    /* ── Alert Sukses ── */
    .alert-success {
        display: flex; align-items: center; gap: 10px;
        background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px;
        padding: 12px 16px; margin-bottom: 20px;
        font-size: 0.85rem; color: #16a34a; font-weight: 500;
    }

    /* ═══ PROFIL FORM CARD ═══ */
    .profil-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 28px;
    }

    .form-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e8e8e8;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }
    .form-card-header {
        padding: 18px 22px 14px;
        border-bottom: 1px solid #f0f0f0;
        display: flex; align-items: center; gap: 10px;
    }
    .form-card-header .hdr-icon {
        width: 36px; height: 36px; border-radius: 10px;
        background: #f0f3ff; color: #4361ee;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .form-card-header h2 { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; margin: 0; }
    .form-card-header p  { font-size: 0.78rem; color: #888; margin: 2px 0 0; }
    .form-card-body { padding: 20px 22px; }

    .form-group { margin-bottom: 16px; }
    .form-group label {
        display: block; font-size: 0.78rem; font-weight: 600;
        color: #555; margin-bottom: 6px;
    }
    .form-control {
        width: 100%; padding: 10px 12px;
        border: 1.5px solid #e0e0e0; border-radius: 8px;
        font-size: 0.85rem; font-family: inherit; color: #1a1a2e;
        transition: border-color 0.15s;
        background: #fff;
        box-sizing: border-box;
    }
    .form-control:focus { outline: none; border-color: #4361ee; box-shadow: 0 0 0 3px rgba(67,97,238,0.1); }
    .form-control.is-invalid { border-color: #ef4444; }
    .invalid-feedback { font-size: 0.75rem; color: #ef4444; margin-top: 4px; }

    .btn-primary {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        color: #fff; border: none; border-radius: 8px;
        padding: 10px 20px; font-size: 0.82rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all 0.2s;
    }
    .btn-primary:hover { background: linear-gradient(135deg, #3a56d4, #2f49c0); }

    /* ═══ KARTU ANGGOTA ═══ */
    .section-title {
        font-size: 1.1rem; font-weight: 700; color: #1a1a2e;
        margin: 0 0 20px; display: flex; align-items: center; gap: 8px;
    }
    .section-title::after {
        content: ''; flex: 1; height: 1px; background: #e8e8e8;
    }

    .kartu-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        align-items: start;
    }

    /* CARD IDENTITAS */
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
    .member-card.verified {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 60%, #1d4ed8 100%);
        color: #fff;
    }
    .unverified-state {
        background: #fff; border-radius: 20px; border: 1px solid #fde68a;
        padding: 36px; text-align: center;
        box-shadow: 0 10px 30px rgba(245, 158, 11, 0.12);
        display: flex; flex-direction: column; align-items: center;
        grid-column: 1 / -1;
    }
    .warning-icon {
        width: 70px; height: 70px; border-radius: 50%; background: #fffbeb;
        color: #f59e0b; display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px;
    }
    .warning-icon svg { width: 38px; height: 38px; }
    .unverified-state h2 { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; margin: 0 0 8px; }
    .unverified-state p { font-size: 0.85rem; color: #666; line-height: 1.5; margin: 0; max-width: 400px; }

    .member-card::before {
        content: ''; position: absolute;
        top: -40px; right: -40px;
        width: 180px; height: 180px; border-radius: 50%;
        background: rgba(255,255,255,0.08); pointer-events: none;
    }
    .member-card::after {
        content: ''; position: absolute;
        bottom: -60px; left: -30px;
        width: 220px; height: 220px; border-radius: 50%;
        background: rgba(255,255,255,0.06); pointer-events: none;
    }
    .card-header-mc { display: flex; align-items: flex-start; justify-content: space-between; position: relative; z-index: 1; }
    .card-logo { display: flex; align-items: center; gap: 10px; }
    .logo-icon {
        width: 40px; height: 40px; border-radius: 10px;
        background: rgba(255,255,255,0.25);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; font-weight: 900; backdrop-filter: blur(6px);
    }
    .logo-text .name { font-size: 0.85rem; font-weight: 700; }
    .logo-text .sub  { font-size: 0.7rem; opacity: 0.8; }
    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 20px;
        font-size: 0.72rem; font-weight: 700; backdrop-filter: blur(8px);
        background: rgba(255,255,255,0.25); border: 1px solid rgba(255,255,255,0.4);
    }
    .status-badge svg { flex-shrink: 0; }
    .card-body-mc { position: relative; z-index: 1; padding: 14px 0; }
    .member-id-label { font-size: 0.68rem; opacity: 0.75; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px; }
    .member-id       { font-size: 1.35rem; font-weight: 800; letter-spacing: 0.02em; margin-bottom: 16px; }
    .card-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .card-info-item .label { font-size: 0.68rem; opacity: 0.75; margin-bottom: 2px; }
    .card-info-item .value { font-size: 0.88rem; font-weight: 700; }
    .card-status-pill {
        display: inline-block; padding: 3px 12px; border-radius: 20px;
        font-size: 0.72rem; font-weight: 700;
        background: rgba(255,255,255,0.25); border: 1px solid rgba(255,255,255,0.4);
    }
    .card-footer-mc {
        position: relative; z-index: 1;
        border-top: 1px solid rgba(255,255,255,0.25); padding-top: 14px;
    }
    .card-footer-mc .footer-text { font-size: 0.7rem; opacity: 0.75; margin-bottom: 2px; }
    .card-footer-mc .footer-copy { font-size: 0.7rem; opacity: 0.65; }

    /* INFO CARD */
    .info-card {
        background: #fff; border-radius: 20px;
        border: 1px solid #e8e8e8; overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    }
    .info-card-header { padding: 20px 24px 14px; border-bottom: 1px solid #f0f0f0; }
    .info-card-header h2 { font-size: 1rem; font-weight: 700; color: #1a1a2e; margin: 0; }
    .info-rows { padding: 6px 0; }
    .info-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 13px 24px; border-bottom: 1px solid #f7f7f7;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row .ir-label { font-size: 0.82rem; color: #888; }
    .info-row .ir-value { font-size: 0.85rem; font-weight: 600; color: #1a1a2e; text-align: right; }
    .ir-aktif   { color: #16a34a !important; }
    .ir-pending { color: #d97706 !important; }
    .info-note {
        display: flex; align-items: center; gap: 8px;
        padding: 16px 24px; border-top: 1px solid #f0f0f0;
        font-size: 0.78rem; color: #888;
    }
    .info-note svg { flex-shrink: 0; color: #4361ee; }
    .member-id-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f0f3ff; color: #4361ee;
        border-radius: 8px; padding: 4px 12px;
        font-size: 0.8rem; font-weight: 700;
    }

    /* ═══ AVATAR UPLOAD CARD ═══ */
    .avatar-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e8e8e8;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        padding: 24px 22px;
        margin-bottom: 24px;
        display: flex; align-items: center; gap: 28px;
    }
    .avatar-preview-wrap {
        position: relative; flex-shrink: 0;
    }
    .avatar-circle {
        width: 90px; height: 90px; border-radius: 50%;
        background: linear-gradient(135deg, #4361ee, #6366f1);
        color: #fff; font-size: 2rem; font-weight: 800;
        display: flex; align-items: center; justify-content: center;
        object-fit: cover; border: 3px solid #e0e4ff;
        overflow: hidden;
    }
    .avatar-edit-btn {
        position: absolute; bottom: 0; right: 0;
        width: 28px; height: 28px; border-radius: 50%;
        background: #4361ee; color: #fff; border: 2px solid #fff;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; box-shadow: 0 2px 8px rgba(67,97,238,0.4);
        transition: background 0.2s;
    }
    .avatar-edit-btn:hover { background: #3a56d4; }
    .avatar-info h3 { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; margin: 0 0 4px; }
    .avatar-info p { font-size: 0.78rem; color: #888; margin: 0 0 12px; }
    .avatar-actions { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }
    .btn-choose-photo {
        background: #f0f3ff; color: #4361ee; border: 1.5px solid #c7d2fe;
        border-radius: 8px; padding: 8px 16px; font-size: 0.82rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all 0.2s;
    }
    .btn-choose-photo:hover { background: #e0e7ff; }
    .avatar-filename { font-size: 0.78rem; color: #888; }

    @media (max-width: 600px) { .avatar-card { flex-direction: column; text-align: center; } .avatar-actions { justify-content: center; } }

    @media (max-width: 900px) {
        .profil-grid { grid-template-columns: 1fr; }
        .kartu-wrapper { grid-template-columns: 1fr; }
    }
    
    @media (max-width: 400px) {
        .info-row { flex-direction: column; align-items: flex-start; gap: 4px; }
        .info-row .ir-value { text-align: left; }
        .member-card { padding: 24px 20px 20px; }
    }
</style>
@endpush

@section('content')
<div class="mb-6">
    <h1 class="text-[1.35rem] font-bold text-indigo-950">Identitas Sang Penjelajah</h1>
    <p class="text-slate-500 text-[0.875rem] mt-1">Jangan lupakan namamu. Atur profil dan pastikan kartu anggotamu siap untuk petualangan berikutnya</p>
</div>

@php
    $user = Auth::user();
    $memberId = $memberId ?? ('ID-' . $user->id . '-PX-' . $user->created_at->format('Y'));
    $isVerified = $isVerified ?? (bool) $user->is_verified;
    $tahunDaftar = $tahunDaftar ?? $user->created_at->format('Y');
    $tanggalBergabung = $tanggalBergabung ?? $user->created_at->translatedFormat('d F Y');
@endphp

{{-- Alert sukses --}}
@if(session('success'))
<div class="alert-success">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif
@if(session('success_password'))
<div class="alert-success">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success_password') }}
</div>
@endif

{{-- ═══ FOTO PROFIL ═══ --}}
<div class="avatar-card">
    @php
        $initials = collect(explode(' ', Auth::user()->username))
            ->map(fn($w) => strtoupper($w[0] ?? ''))
            ->take(2)->join('');
    @endphp
    <div class="avatar-preview-wrap">
        @if(Auth::user()->avatar)
            <img id="avatarPreview" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Foto Profil" class="avatar-circle">
        @else
            <div id="avatarPreview" class="avatar-circle" style="font-size:1.8rem;">{{ $initials }}</div>
        @endif
        <label for="avatarInput" class="avatar-edit-btn" title="Ganti Foto">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg>
        </label>
    </div>
    <div class="avatar-info">
        <h3>Foto Profil</h3>
        <p>JPG, PNG, atau WEBP. Maks 2MB.</p>
        <form id="avatarForm" method="POST" action="{{ route('siswa.profil.avatar') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" id="avatarInput" name="avatar" accept="image/jpeg,image/png,image/webp" style="display:none;" onchange="previewAvatar(this)">
            <div class="avatar-actions">
                <label for="avatarInput" class="btn-choose-photo">📷 Pilih Foto</label>
                <button type="submit" class="btn-primary" id="avatarSubmitBtn" style="display:none;">Simpan Foto</button>
                <span class="avatar-filename" id="avatarFilename"></span>
            </div>
        </form>
        @error('avatar') <div class="invalid-feedback" style="display:block;margin-top:6px;">{{ $message }}</div> @enderror
    </div>
</div>

{{-- ═══ FORM PROFIL ═══ --}}
<div class="profil-grid">

    {{-- Edit Info --}}
    <div class="form-card">
        <div class="form-card-header">
            <div class="hdr-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <h2>Informasi Akun</h2>
                <p>Perbarui nama, email, dan nomor telepon Anda</p>
            </div>
        </div>
        <div class="form-card-body">
            <form method="POST" action="{{ route('siswa.profil.update') }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="username">Nama Pengguna</label>
                    <input type="text" id="username" name="username" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" value="{{ old('username', $user->username) }}" required>
                    @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="telepon">Nomor Telepon</label>
                    <input type="text" id="telepon" name="telepon" class="form-control {{ $errors->has('telepon') ? 'is-invalid' : '' }}" value="{{ old('telepon', $user->telepon) }}" placeholder="Opsional">
                    @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    {{-- Ganti Password --}}
    <div class="form-card">
        <div class="form-card-header">
            <div class="hdr-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                </svg>
            </div>
            <div>
                <h2>Ganti Password</h2>
                <p>Pastikan menggunakan password yang kuat</p>
            </div>
        </div>
        <div class="form-card-body">
            <form method="POST" action="{{ route('siswa.profil.password') }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="current_password">Password Lama</label>
                    <input type="password" id="current_password" name="current_password" class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}">
                    @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}">
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>
                <button type="submit" class="btn-primary">Perbarui Password</button>
            </form>
        </div>
    </div>
</div>

{{-- ═══ KARTU ANGGOTA ═══ --}}
<div class="section-title">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
    </svg>
    Kartu Anggota
</div>

<div class="kartu-wrapper">

@if(!$isVerified)
    <div class="unverified-state">
        <div class="warning-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <h2>Menunggu Verifikasi</h2>
        <p>Akun Anda sedang menunggu proses verifikasi oleh Admin. Kartu anggota akan aktif dan dapat digunakan setelah diverifikasi.</p>
    </div>
@else
    {{-- CARD 1: IDENTITAS --}}
    <div class="member-card verified">
        <div class="card-header-mc">
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
            <div class="status-badge">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-.723 3.065 3.745 3.745 0 01-3.065.723A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.065-.723 3.745 3.745 0 01-.723-3.065A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 01.723-3.065 3.746 3.746 0 013.065-.723A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.065.723 3.746 3.746 0 01.723 3.065A3.745 3.745 0 0121 12z"/>
                </svg>
                Terverifikasi
            </div>
        </div>

        <div class="card-body-mc">
            <div class="member-id-label">ID Anggota</div>
            <div class="member-id">{{ $memberId }}</div>
            <div class="card-info-grid">
                <div class="card-info-item">
                    {{-- [HIGH-F03] Fix: baris pertama tampilkan nama lengkap, bukan username --}}
                    <div class="label">Nama Lengkap</div>
                    <div class="value">{{ $user->name ?? $user->username }}</div>
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
                        <span class="card-status-pill">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer-mc">
            <div class="footer-text">Berlaku selama menjadi anggota aktif</div>
            <div class="footer-copy">© {{ $tahunDaftar }} Perpustakaan Digital</div>
        </div>
    </div>

    {{-- CARD 2: INFO TAMBAHAN --}}
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
                <span class="ir-value ir-aktif">Aktif</span>
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
@endif
</div>

<p style="text-align:center;font-size:0.75rem;color:#bbb;margin-top:28px;">
    Kartu Anggota Berlaku Selama Menjadi Anggota Aktif | Nomor {{ $memberId }}
</p>

@endsection

@push('scripts')
<script>
function previewAvatar(input) {
    if (!input.files || !input.files[0]) return;

    const file  = input.files[0];
    const wrap  = document.getElementById('avatarPreview');
    const btn   = document.getElementById('avatarSubmitBtn');
    const label = document.getElementById('avatarFilename');

    // Show filename
    if (label) label.textContent = file.name;

    // Show submit button
    if (btn) btn.style.display = '';

    // Build preview
    const reader = new FileReader();
    reader.onload = function (e) {
        if (wrap.tagName === 'IMG') {
            wrap.src = e.target.result;
        } else {
            // Replace the initials div with an img tag
            const img = document.createElement('img');
            img.id        = 'avatarPreview';
            img.src       = e.target.result;
            img.alt       = 'Preview';
            img.className = 'avatar-circle';
            wrap.parentNode.replaceChild(img, wrap);
        }
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
