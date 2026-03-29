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

    /* Responsive */
    @media (max-width: 1024px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .stat-grid { grid-template-columns: 1fr; }
        .page-topbar { flex-direction: column; align-items: flex-start; gap: 12px; }
        .filter-bar { flex-wrap: wrap; gap: 8px; }
        .divider-v { display: none; }
        .filter-bar select { width: 100%; }
        .page-topbar-left h1 { font-size: 1.15rem; }
    }
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

<div class="bg-white border border-slate-200 rounded-2xl overflow-hidden mt-4">
    <div class="px-6 pt-5 pb-4 border-b border-slate-100 mb-2 mt-2">
        <h2 class="font-bold text-slate-800 text-[1rem]">Daftar Menunggu Verifikasi</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">ANGGOTA</th>
                    <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">KONTAK</th>
                    <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">TANGGAL DAFTAR</th>
                    <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">STATUS</th>
                    <th class="px-5 py-3 text-center text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($pending as $siswa)
                @php
                    $initials = collect(explode(' ', $siswa->name))->take(2)->map(fn($w) => strtoupper($w[0]))->implode('');
                    $colors = ['6366f1','22c55e','f59e0b','ec4899','14b8a6','8b5cf6','f97316','06b6d4'];
                    $color  = '#' . $colors[$siswa->id % count($colors)];
                @endphp
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-3.5 align-middle">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-[0.8rem] font-extrabold text-white flex-shrink-0" style="background:<?php echo $color; ?>;">
                                {{ $initials }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-slate-800 text-[0.85rem] leading-tight truncate">{{ $siswa->username }}</p>
                                <p class="text-[0.75rem] text-slate-400 truncate mt-0.5">{{ $siswa->name }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="px-5 py-3.5 align-middle">
                        <div class="text-[0.82rem] text-slate-600 mb-0.5">{{ $siswa->email }}</div>
                        <div class="text-[0.76rem] text-slate-400">{{ $siswa->telepon ?: '-' }}</div>
                    </td>

                    <td class="px-5 py-3.5 align-middle text-slate-600 text-[0.82rem]">
                        {{ $siswa->created_at->format('d M Y') }}
                    </td>

                    <td class="px-5 py-3.5 align-middle">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[0.7rem] font-bold tracking-wide">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 flex-shrink-0"></span> Pending
                        </span>
                    </td>

                    <td class="px-5 py-3.5 text-center align-middle">
                        <div class="inline-flex items-center gap-2 justify-center">
                            <button type="button" class="btn-show-detail inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 text-[0.75rem] font-semibold transition-colors m-0"
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

                            <form action="{{ route('admin.verifikasi.update', $siswa->id) }}" method="POST" class="m-0"
                                  onsubmit="confirmAction(event, 'Verifikasi akun @{{ $siswa->username }}?', 'Ya, Verifikasi', 'Konfirmasi Verifikasi', false); return false;">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-green-200 bg-green-50 hover:bg-green-100 text-green-600 text-[0.75rem] font-semibold transition-colors m-0">
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
                    <td colspan="5" class="px-5 py-14 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                            </svg>
                            <p class="text-slate-400 text-[0.85rem]">Tidak ada anggota yang menunggu verifikasi.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

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
