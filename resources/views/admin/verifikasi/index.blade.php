@extends('layouts.admin')

@section('title', 'Verifikasi Anggota')

@push('styles')
<style>
    /* ─── Page Header ─────────────────────────────────── */
    .page-topbar {
        display: flex; align-items: center;
        justify-content: space-between; margin-bottom: 24px;
    }
    .page-topbar-left h1 { font-size: 1.3rem; font-weight: 700; color: #1a1a2e; margin: 0 0 3px; }
    .page-topbar-left p  { font-size: 0.83rem; color: #888; margin: 0; }
    .btn-all {
        display: inline-flex; align-items: center; gap: 7px;
        background: linear-gradient(135deg, #4361ee, #3a56d4); color: #fff;
        border: none; border-radius: 10px;
        padding: 10px 20px; font-size: 0.83rem; font-weight: 600;
        cursor: pointer; text-decoration: none; transition: all 0.2s;
        font-family: inherit;
    }
    .btn-all:hover {
        background: linear-gradient(135deg, #3a56d4, #2f49c0);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(67,97,238,0.3);
    }

    /* ─── Stat Cards ─────────────────────────────────── */
    .stat-grid {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 16px; margin-bottom: 24px;
    }
    .stat-card {
        background: #fff; border-radius: 14px;
        border: 1px solid #e8e8e8; padding: 20px 22px;
        display: flex; align-items: center; gap: 16px;
    }
    .stat-icon {
        width: 44px; height: 44px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon.yellow { background: #fef9c3; }
    .stat-icon.green  { background: #dcfce7; }
    .stat-icon.red    { background: #fee2e2; }
    .stat-label { font-size: 0.78rem; color: #888; margin-bottom: 2px; }
    .stat-value { font-size: 1.7rem; font-weight: 800; color: #1a1a2e; line-height: 1; }

    /* ─── Filter bar ─────────────────────────────────── */
    .filter-bar {
        display: flex; gap: 12px; align-items: center;
        background: #fff; border-radius: 12px;
        border: 1px solid #e5e7eb; padding: 10px 16px;
        margin-bottom: 22px;
    }
    .filter-bar-search {
        display: flex; align-items: center; gap: 8px; flex: 1;
    }
    .filter-bar-search svg { color: #bbb; flex-shrink: 0; }
    .filter-bar-search input {
        flex: 1; border: none; outline: none;
        font-size: 0.85rem; color: #555;
        background: transparent; font-family: inherit;
    }
    .divider-v { width: 1px; height: 24px; background: #e5e7eb; flex-shrink: 0; }
    .filter-bar select {
        border: none; outline: none; font-size: 0.83rem; color: #555;
        background: transparent; font-family: inherit; cursor: pointer;
        padding: 2px 6px;
    }

    /* ─── Table ──────────────────────────────────────── */
    .table-card {
        background: #fff; border-radius: 14px;
        border: 1px solid #e8e8e8; overflow: hidden;
    }
    .table-card-header {
        padding: 18px 22px 14px;
        border-bottom: 1px solid #f0f0f0;
    }
    .table-card-header h2 { font-size: 0.95rem; font-weight: 700; color: #1a1a2e; margin: 0; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th {
        text-align: left; font-size: 0.7rem;
        font-weight: 700; color: #aaa;
        text-transform: uppercase; letter-spacing: 0.04em;
        padding: 12px 20px;
        border-bottom: 1px solid #f0f0f0; background: #fafafa;
    }
    .data-table td {
        padding: 14px 20px; font-size: 0.83rem;
        color: #444; border-bottom: 1px solid #f7f7f7;
        vertical-align: middle;
    }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tr:hover td { background: #f9faff; }

    /* Avatar inisial */
    .user-cell { display: flex; align-items: center; gap: 12px; }
    .avatar-initials {
        width: 40px; height: 40px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; font-weight: 800; flex-shrink: 0;
        color: #fff;
    }
    .user-cell-info .username { font-weight: 700; color: #1a1a2e; font-size: 0.85rem; }
    .user-cell-info .fullname { font-size: 0.75rem; color: #888; margin-top: 1px; }

    /* Kontak */
    .contact-cell .email  { font-size: 0.82rem; color: #444; }
    .contact-cell .telepon{ font-size: 0.76rem; color: #888; margin-top: 2px; }

    /* Badge status */
    .badge-pending {
        display: inline-flex; align-items: center; gap: 5px;
        background: #fef3c7; color: #b45309;
        border-radius: 20px; padding: 3px 12px;
        font-size: 0.72rem; font-weight: 700;
    }
    .badge-dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: #f59e0b; flex-shrink: 0;
    }

    /* Action buttons */
    .action-btns { display: flex; gap: 8px; align-items: center; }
    .btn-detail {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 14px; border-radius: 8px;
        border: 1px solid #e5e7eb; background: #fff;
        font-size: 0.78rem; font-weight: 600; color: #555;
        cursor: pointer; transition: all 0.15s; font-family: inherit;
        text-decoration: none;
    }
    .btn-detail:hover { background: #f5f5f5; }
    .btn-verify {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 14px; border-radius: 8px;
        border: 1px solid #bbf7d0; background: #f0fdf4;
        font-size: 0.78rem; font-weight: 600; color: #16a34a;
        cursor: pointer; transition: all 0.15s; font-family: inherit;
    }
    .btn-verify:hover { background: #dcfce7; border-color: #86efac; }

    /* Empty state */
    .empty-state {
        text-align: center; padding: 50px 20px; color: #bbb;
    }
    .empty-state svg { margin-bottom: 10px; color: #ddd; }
    .empty-state p { font-size: 0.85rem; margin: 0; }

    /* Pagination */
    .pagination-wrap {
        display: flex; align-items: center; gap: 4px;
        padding: 14px 20px;
    }
    .pagination-wrap a, .pagination-wrap span {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: 6px;
        font-size: 0.8rem; text-decoration: none; color: #666;
        border: 1px solid #e5e7eb;
    }
    .pagination-wrap .active { background: #4361ee; color: #fff; border-color: #4361ee; }
    .pagination-wrap nav p.text-sm.text-gray-700 { display: none !important; }

    /* ─── MODAL DETAIL ───────────────────────────────── */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.45); z-index: 1000;
        align-items: center; justify-content: center; padding: 20px;
    }
    .modal-overlay.show { display: flex; }
    .modal-box {
        background: #fff; border-radius: 18px;
        width: 100%; max-width: 460px;
        padding: 30px 32px; box-shadow: 0 24px 60px rgba(0,0,0,0.2);
        animation: modalPop 0.2s ease;
    }
    @keyframes modalPop {
        from { transform: scale(0.95); opacity: 0; }
        to   { transform: scale(1);    opacity: 1; }
    }
    .modal-box h2 {
        font-size: 1rem; font-weight: 700; color: #1a1a2e;
        margin: 0 0 20px; padding-bottom: 14px; border-bottom: 1px solid #f0f0f0;
    }
    .modal-user-header {
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 20px;
    }
    .modal-avatar {
        width: 52px; height: 52px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem; font-weight: 800; color: #fff; flex-shrink: 0;
    }
    .modal-user-name { font-weight: 700; font-size: 1rem; color: #1a1a2e; }
    .modal-user-sub  { font-size: 0.8rem; color: #888; margin-top: 2px; }
    .modal-details { display: flex; flex-direction: column; gap: 0; }
    .modal-row {
        display: flex; justify-content: space-between;
        padding: 10px 0; border-bottom: 1px solid #f5f5f5;
        font-size: 0.83rem;
    }
    .modal-row:last-child { border-bottom: none; }
    .modal-row .ml { color: #888; }
    .modal-row .mv { font-weight: 600; color: #1a1a2e; text-align: right; }
    .modal-footer {
        display: flex; justify-content: flex-end; gap: 10px;
        margin-top: 22px; padding-top: 18px; border-top: 1px solid #f0f0f0;
    }
    .btn-close-modal {
        padding: 9px 20px; border-radius: 8px; border: 1px solid #e5e7eb;
        background: #fff; color: #555; font-size: 0.83rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
    }
    .btn-close-modal:hover { background: #f5f5f5; }
    .btn-verify-modal {
        padding: 9px 20px; border-radius: 8px; border: none;
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: #fff; font-size: 0.83rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all 0.2s;
    }
    .btn-verify-modal:hover { opacity: 0.9; }
</style>
@endpush

@section('content')

{{-- Top Bar --}}
<div class="page-topbar">
    <div class="page-topbar-left">
        <h1>Verifikasi Anggota</h1>
        <p>Kelola pendaftaran anggota baru yang menunggu verifikasi</p>
    </div>
    <a href="{{ route('admin.pengguna.index') }}" class="btn-all">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
        Data Pengguna
    </a>
</div>

{{-- Stat Cards --}}
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon yellow">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="stat-label">Menunggu Verifikasi</div>
            <div class="stat-value">{{ $totalPending }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="stat-label">Aktif</div>
            <div class="stat-value">{{ $totalAktif }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <div class="stat-label">Ditolak</div>
            <div class="stat-value">{{ $totalDitolak }}</div>
        </div>
    </div>
</div>

{{-- Filter Bar --}}
<form action="{{ route('admin.verifikasi') }}" method="GET">
    <div class="filter-bar">
        <div class="filter-bar-search">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" name="search" value="{{ $search ?? '' }}"
                   placeholder="Cari Nama, Email, atau Telepon...">
        </div>
        <div class="divider-v"></div>
        <select name="tanggal" onchange="this.form.submit()" style="min-width:130px;">
            <option value="">Semua Tanggal</option>
            @foreach($pending->pluck('created_at')->map(fn($d) => $d->format('Y-m-d'))->unique()->sort()->reverse() as $tgl)
                <option value="{{ $tgl }}" {{ ($tanggal ?? '') === $tgl ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::parse($tgl)->format('d M Y') }}
                </option>
            @endforeach
        </select>
        <div class="divider-v"></div>
        <select name="urutan" onchange="this.form.submit()">
            <option value="terbaru" {{ ($urutan ?? 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
            <option value="terlama" {{ ($urutan ?? '') === 'terlama' ? 'selected' : '' }}>Terlama</option>
        </select>
        <button type="submit" style="display:none;"></button>
    </div>
</form>

{{-- Table --}}
<div class="table-card">
    <div class="table-card-header">
        <h2>Daftar Menunggu Verifikasi</h2>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Anggota</th>
                <th>Kontak</th>
                <th>Tanggal Daftar</th>
                <th>Status</th>
                <th style="text-align:right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pending as $siswa)
            @php
                $initials = collect(explode(' ', $siswa->name))->take(2)->map(fn($w) => strtoupper($w[0]))->implode('');
                $colors = ['6366f1','22c55e','f59e0b','ec4899','14b8a6','8b5cf6','f97316','06b6d4'];
                $color  = '#' . $colors[$siswa->id % count($colors)];
            @endphp
            <tr>
                {{-- Avatar + Info --}}
                <td>
                    <div class="user-cell">
                        <div class="avatar-initials" style="background:<?php echo $color; ?>;">{{ $initials }}</div>
                        <div class="user-cell-info">
                            <div class="username">{{ $siswa->username }}</div>
                            <div class="fullname">{{ $siswa->name }}</div>
                        </div>
                    </div>
                </td>

                {{-- Kontak --}}
                <td>
                    <div class="contact-cell">
                        <div class="email">{{ $siswa->email }}</div>
                        <div class="telepon">{{ $siswa->telepon ?: '-' }}</div>
                    </div>
                </td>

                {{-- Tanggal Daftar --}}
                <td>{{ $siswa->created_at->format('d M Y') }}</td>

                {{-- Status --}}
                <td>
                    <span class="badge-pending">
                        <span class="badge-dot"></span> Pending
                    </span>
                </td>

                {{-- Aksi --}}
                <td style="text-align:right;">
                    <div class="action-btns" style="justify-content:flex-end;">
                        {{-- Tombol Detail --}}
                        <button type="button" class="btn-detail btn-show-detail"
                            data-id="{{ $siswa->id }}"
                            data-username="{{ $siswa->username }}"
                            data-name="{{ $siswa->name }}"
                            data-email="{{ $siswa->email }}"
                            data-telepon="{{ $siswa->telepon }}"
                            data-gender="{{ $siswa->gender }}"
                            data-daftar="{{ $siswa->created_at->format('d M Y') }}"
                            data-color="{{ $color }}"
                            data-initials="{{ $initials }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Detail
                        </button>

                        {{-- Tombol Verifikasi --}}
                        <form action="{{ route('admin.verifikasi.update', $siswa->id) }}" method="POST"
                              onsubmit="confirmAction(event, 'Verifikasi akun @{{ $siswa->username }}?', 'Ya, Verifikasi', 'Konfirmasi Verifikasi', false); return false;">
                            @csrf
                            <button type="submit" class="btn-verify">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                                Verifikasi
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>Tidak ada anggota yang menunggu verifikasi.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($pending->hasPages())
    <div class="pagination-wrap">
        {{ $pending->links() }}
    </div>
    @endif
</div>

{{-- Modal Detail --}}
<div class="modal-overlay" id="modalDetail">
    <div class="modal-box">
        <h2>Detail Anggota</h2>
        <div class="modal-user-header">
            <div class="modal-avatar" id="modalAvatar"></div>
            <div>
                <div class="modal-user-name" id="modalName">&nbsp;</div>
                <div class="modal-user-sub"  id="modalUsername">&nbsp;</div>
            </div>
        </div>
        <div class="modal-details">
            <div class="modal-row"><span class="ml">Email</span>    <span class="mv" id="mEmail">-</span></div>
            <div class="modal-row"><span class="ml">Telepon</span>  <span class="mv" id="mTelepon">-</span></div>
            <div class="modal-row"><span class="ml">Jenis Kelamin</span><span class="mv" id="mGender">-</span></div>
            <div class="modal-row"><span class="ml">Tanggal Daftar</span><span class="mv" id="mDaftar">-</span></div>
            <div class="modal-row"><span class="ml">Status</span>   <span class="mv" style="color:#d97706;">Menunggu Verifikasi</span></div>
        </div>
        <div class="modal-footer">
            <button class="btn-close-modal" id="btnCloseModal">Tutup</button>
            <form id="modalVerifyForm" method="POST">
                @csrf
                <button type="submit" class="btn-verify-modal"
                        onclick="confirmAction(event, 'Verifikasi anggota ini?', 'Ya, Verifikasi', 'Konfirmasi Verifikasi', false); return false;">
                    ✓ Verifikasi Sekarang
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const modal     = document.getElementById('modalDetail');
const closeBtn  = document.getElementById('btnCloseModal');
const verifyUrl = (id) => `/admin/verifikasi/${id}`;

document.querySelectorAll('.btn-show-detail').forEach(btn => {
    btn.addEventListener('click', function () {
        const d = this.dataset;

        document.getElementById('modalAvatar').textContent        = d.initials;
        document.getElementById('modalAvatar').style.background   = d.color;
        document.getElementById('modalName').textContent          = d.name;
        document.getElementById('modalUsername').textContent      = '@' + d.username;
        document.getElementById('mEmail').textContent             = d.email;
        document.getElementById('mTelepon').textContent           = d.telepon || '-';
        document.getElementById('mGender').textContent            = d.gender;
        document.getElementById('mDaftar').textContent            = d.daftar;
        document.getElementById('modalVerifyForm').action         = verifyUrl(d.id);

        modal.classList.add('show');
    });
});

closeBtn.addEventListener('click', () => modal.classList.remove('show'));
modal.addEventListener('click', e => { if (e.target === modal) modal.classList.remove('show'); });
</script>
@endpush
