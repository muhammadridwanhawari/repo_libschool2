@extends('layouts.siswa')

@section('title', 'Pengajuan Saya')

@push('styles')
<style>
    /* ── Page Header ── */
    .pj-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 24px;
    }
    .pj-header-left { display: flex; align-items: center; gap: 14px; }
    .pj-icon {
        width: 46px; height: 46px; border-radius: 12px;
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; box-shadow: 0 4px 12px rgba(67,97,238,0.25);
    }
    .pj-header-left h1 { font-size: 1.3rem; font-weight: 800; color: #1a1a2e; margin: 0 0 2px; }
    .pj-header-left p  { font-size: 0.8rem; color: #94a3b8; margin: 0; }

    .btn-usulkan {
        display: inline-flex; align-items: center; gap: 7px;
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        color: #fff; border: none; border-radius: 10px;
        padding: 10px 20px; font-size: 0.82rem; font-weight: 700;
        cursor: pointer; text-decoration: none; font-family: inherit;
        transition: all 0.2s; box-shadow: 0 4px 12px rgba(67,97,238,0.3);
    }
    .btn-usulkan:hover { background: linear-gradient(135deg, #3a56d4, #2f49c0); box-shadow: 0 6px 18px rgba(67,97,238,0.4); }

    /* ── Stat Cards ── */
    .pj-stats {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 16px; margin-bottom: 24px;
    }
    @media (max-width: 900px) { .pj-stats { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 500px) { .pj-stats { grid-template-columns: 1fr; } }

    .pj-stat {
        background: #fff; border-radius: 14px;
        border: 1.5px solid #e5e7eb;
        padding: 18px 20px;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .pj-stat-label { font-size: 0.68rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 4px; }
    .pj-stat-value { font-size: 1.9rem; font-weight: 800; margin: 0; line-height: 1; }
    .pj-stat-icon  { width: 44px; height: 44px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

    /* Total */
    .pj-stat-total .pj-stat-label { color: #64748b; }
    .pj-stat-total .pj-stat-value { color: #1a1a2e; }
    .pj-stat-total .pj-stat-icon  { background: #f1f5f9; }

    /* Menunggu */
    .pj-stat-wait { background: #fefce8; border-color: #fef08a; }
    .pj-stat-wait .pj-stat-label  { color: #ca8a04; }
    .pj-stat-wait .pj-stat-value  { color: #ca8a04; }
    .pj-stat-wait .pj-stat-icon   { background: #fef08a; }

    /* Disetujui */
    .pj-stat-ok { background: #f0fdf4; border-color: #bbf7d0; }
    .pj-stat-ok .pj-stat-label { color: #16a34a; }
    .pj-stat-ok .pj-stat-value { color: #16a34a; }
    .pj-stat-ok .pj-stat-icon  { background: #bbf7d0; }

    /* Ditolak */
    .pj-stat-no { background: #fff1f2; border-color: #fecdd3; }
    .pj-stat-no .pj-stat-label { color: #dc2626; }
    .pj-stat-no .pj-stat-value { color: #dc2626; }
    .pj-stat-no .pj-stat-icon  { background: #fecdd3; }

    /* ── Table Card ── */
    .pj-card {
        background: #fff; border-radius: 16px;
        border: 1px solid #e8e8e8;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .pj-card-head {
        padding: 18px 22px;
        border-bottom: 1px solid #f0f0f0;
        display: flex; align-items: center; justify-content: space-between;
    }
    .pj-card-head h2 { font-size: 0.95rem; font-weight: 800; color: #1a1a2e; margin: 0; }

    .pj-filter {
        appearance: none;
        background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 10px center;
        border: 1.5px solid #e0e0e0; border-radius: 8px;
        padding: 7px 32px 7px 12px;
        font-size: 0.82rem; color: #555; font-family: inherit;
        cursor: pointer; transition: border-color 0.15s;
    }
    .pj-filter:focus { outline: none; border-color: #4361ee; }

    /* Table */
    .pj-table { width: 100%; border-collapse: collapse; }
    .pj-table thead tr { background: #f8fafc; border-bottom: 1px solid #f0f0f0; }
    .pj-table th {
        padding: 12px 20px; text-align: left;
        font-size: 0.68rem; font-weight: 800;
        color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .pj-table th.center { text-align: center; }
    .pj-table tbody tr { border-bottom: 1px solid #f7f7f7; transition: background 0.15s; }
    .pj-table tbody tr:last-child { border-bottom: none; }
    .pj-table tbody tr:hover { background: #f8fafc; }
    .pj-table td { padding: 14px 20px; font-size: 0.85rem; color: #334155; }
    .pj-table td.center { text-align: center; }
    .pj-judul  { font-weight: 700; color: #1a1a2e; }
    .pj-sub    { font-size: 0.75rem; color: #94a3b8; margin-top: 2px; }
    .pj-kategori { color: #64748b; }

    /* Status badges */
    .badge {
        display: inline-block; padding: 4px 12px; border-radius: 20px;
        font-size: 0.7rem; font-weight: 800;
    }
    .badge-wait { background: #fef9c3; color: #ca8a04; }
    .badge-ok   { background: #dcfce7; color: #16a34a; }
    .badge-no   { background: #fee2e2; color: #dc2626; }

    /* Empty state */
    .pj-empty {
        padding: 60px 20px;
        display: flex; flex-direction: column; align-items: center; text-align: center;
    }
    .pj-empty-icon {
        width: 72px; height: 72px; border-radius: 50%;
        background: #f1f5f9; border: 1px solid #e2e8f0;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px;
    }
    .pj-empty h3 { font-size: 1rem; font-weight: 700; color: #334155; margin: 0 0 6px; }
    .pj-empty p  { font-size: 0.82rem; color: #94a3b8; margin: 0 0 20px; }

    .alert-success {
        display: flex; align-items: center; gap: 10px;
        background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px;
        padding: 12px 16px; margin-bottom: 20px;
        font-size: 0.85rem; color: #16a34a; font-weight: 500;
    }

    /* Responsive queries */
    @media (max-width: 600px) {
        .pj-header { flex-direction: column; align-items: flex-start; gap: 16px; }
        .btn-usulkan { width: 100%; justify-content: center; }
        .pj-card-head { flex-direction: column; align-items: flex-start; gap: 12px; }
        .pj-filter { width: 100%; }
        form { width: 100%; }
    }

    /* ── Form Styles ── */
    .usul-grid {
        display: grid; grid-template-columns: 1fr 380px; gap: 22px; align-items: start;
    }
    @media (max-width: 900px) { .usul-grid { grid-template-columns: 1fr; } }
    .usul-banner {
        background: linear-gradient(135deg, #4361ee, #3a56d4); border-radius: 16px;
        padding: 22px 24px; display: flex; align-items: center; gap: 18px; color: #fff;
        box-shadow: 0 6px 20px rgba(67,97,238,0.25); margin-bottom: 22px;
    }
    .usul-banner-icon {
        width: 52px; height: 52px; border-radius: 14px; background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25); display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; backdrop-filter: blur(4px);
    }
    .usul-banner h1 { font-size: 1.2rem; font-weight: 800; margin: 0 0 3px; }
    .usul-banner p  { font-size: 0.82rem; opacity: 0.85; margin: 0; }
    .usul-card {
        background: #fff; border-radius: 16px; border: 1px solid #e8e8e8;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04); overflow: hidden;
    }
    .usul-card-body { padding: 22px; }
    .usul-card-hdr { padding: 18px 22px 14px; border-bottom: 1px solid #f0f0f0; }
    .usul-card-hdr h2 { font-size: 0.95rem; font-weight: 800; color: #1a1a2e; margin: 0 0 3px; }
    .usul-card-hdr p  { font-size: 0.78rem; color: #94a3b8; margin: 0; }
    .form-group { margin-bottom: 18px; }
    .form-group:last-child { margin-bottom: 0; }
    .form-group label {
        display: block; font-size: 0.8rem; font-weight: 700; color: #334155; margin-bottom: 7px;
    }
    .form-group label .opt { font-weight: 400; color: #94a3b8; font-size: 0.75rem; }
    .form-group label .req { color: #ef4444; }
    .form-control {
        width: 100%; padding: 10px 13px; border: 1.5px solid #e0e0e0; border-radius: 9px;
        font-size: 0.86rem; color: #1a1a2e; font-family: inherit; background: #fff; transition: border-color 0.15s;
        box-sizing: border-box;
    }
    .form-control::placeholder { color: #c0c8d8; }
    .form-control:focus { outline: none; border-color: #4361ee; box-shadow: 0 0 0 3px rgba(67,97,238,0.1); }
    .form-control.is-invalid { border-color: #ef4444; }
    .form-control[readonly] { background: #f8fafc; color: #64748b; cursor: default; }
    .invalid-feedback { font-size: 0.75rem; color: #ef4444; margin-top: 4px; }
    textarea.form-control { resize: vertical; min-height: 130px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }
    .usul-right { display: flex; flex-direction: column; gap: 16px; }
    .usul-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding-top: 18px; margin-top: 4px; border-top: 1px solid #f0f0f0;
    }
    .usul-footer .note { font-size: 0.75rem; color: #94a3b8; }
    .usul-footer .note span { color: #ef4444; }
    .btn-submit {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #4361ee, #3a56d4); color: #fff; border: none; border-radius: 10px;
        padding: 11px 22px; font-size: 0.85rem; font-weight: 700; cursor: pointer; font-family: inherit; transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(67,97,238,0.3);
    }
    .btn-submit:hover { background: linear-gradient(135deg, #3a56d4, #2f49c0); box-shadow: 0 6px 18px rgba(67,97,238,0.4); }
    .btn-submit:active { transform: scale(0.97); }
    @media (max-width: 500px) {
        .usul-banner { flex-direction: column; text-align: center; gap: 12px; }
        .usul-footer { flex-direction: column; gap: 12px; align-items: flex-start; }
        .btn-submit { width: 100%; justify-content: center; }
    }
    .usul-info {
        background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 16px 18px;
        display: flex; align-items: flex-start; gap: 12px; font-size: 0.8rem; color: #1d4ed8; line-height: 1.5;
    }
    .usul-info svg { flex-shrink: 0; color: #3b82f6; margin-top: 1px; }

    .btn-secondary {
        display: inline-flex; align-items: center; gap: 8px;
        background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;
        border-radius: 10px; padding: 11px 22px; font-size: 0.85rem; font-weight: 700;
        cursor: pointer; font-family: inherit; transition: all 0.2s; text-decoration: none;
    }
    .btn-secondary:hover { background: #e2e8f0; color: #1e293b; }
</style>
@endpush

@section('content')

{{-- Alert --}}
@if(session('success'))
<div class="alert-success">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif

{{-- Wrapper for List View --}}
<div id="view-list" @if($errors->any()) style="display:none;" @endif>
    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-[1.35rem] font-bold text-indigo-950">Pengajuan Saya</h1>
            <p class="text-slate-500 text-[0.875rem] mt-1">Daftar buku yang pernah kamu usulkan ke perpustakaan</p>
        </div>
        <button type="button" class="btn-usulkan" onclick="toggleView('form')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Usulkan Buku Baru
        </button>
    </div>

    {{-- Stat Cards --}}
    <div class="pj-stats">
        {{-- Total --}}
        <div class="pj-stat pj-stat-total">
            <div>
                <p class="pj-stat-label">Total</p>
                <p class="pj-stat-value">{{ $total }}</p>
            </div>
            <div class="pj-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                    <polyline stroke-linecap="round" stroke-linejoin="round" points="14 2 14 8 20 8"/>
                    <line stroke-linecap="round" x1="16" y1="13" x2="8" y2="13"/>
                    <line stroke-linecap="round" x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
        </div>

        {{-- Menunggu --}}
        <div class="pj-stat pj-stat-wait">
            <div>
                <p class="pj-stat-label">Menunggu</p>
                <p class="pj-stat-value">{{ $menunggu }}</p>
            </div>
            <div class="pj-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#ca8a04" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline stroke-linecap="round" stroke-linejoin="round" points="12 6 12 12 16 14"/>
                </svg>
            </div>
        </div>

        {{-- Disetujui --}}
        <div class="pj-stat pj-stat-ok">
            <div>
                <p class="pj-stat-label">Disetujui</p>
                <p class="pj-stat-value">{{ $disetujui }}</p>
            </div>
            <div class="pj-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                    <polyline stroke-linecap="round" stroke-linejoin="round" points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
        </div>

        {{-- Ditolak --}}
        <div class="pj-stat pj-stat-no">
            <div>
                <p class="pj-stat-label">Ditolak</p>
                <p class="pj-stat-value">{{ $ditolak }}</p>
            </div>
            <div class="pj-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <line stroke-linecap="round" x1="15" y1="9" x2="9" y2="15"/>
                    <line stroke-linecap="round" x1="9" y1="9" x2="15" y2="15"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] overflow-hidden">
        {{-- Header --}}
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-bold text-slate-800 text-[1rem]">Daftar Pengajuan</h2>
            <form method="GET" action="{{ route('siswa.pengajuan') }}" class="m-0">
                <select name="status" class="bg-white border border-slate-200 text-slate-500 text-[0.82rem] pl-3 pr-8 py-1.5 rounded-lg outline-none focus:border-indigo-500" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="menunggu"  {{ request('status') == 'menunggu'  ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak"   {{ request('status') == 'ditolak'   ? 'selected' : '' }}>Ditolak</option>
                </select>
            </form>
        </div>

        @if($pengajuan->isEmpty())
            <div class="px-5 py-14 text-center">
                <div class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/>
                            <polyline stroke-linecap="round" stroke-linejoin="round" points="14 2 14 8 20 8"/>
                            <line stroke-linecap="round" x1="16" y1="13" x2="8" y2="13"/>
                            <line stroke-linecap="round" x1="16" y1="17" x2="8" y2="17"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-700 text-[0.95rem] m-0">Belum ada pengajuan</h3>
                    <p class="text-slate-400 text-[0.82rem] mb-4">Kamu belum pernah mengusulkan buku ke perpustakaan.</p>
                    <button type="button" class="btn-usulkan" onclick="toggleView('form')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Usulkan Buku Sekarang
                    </button>
                </div>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse min-w-[600px]">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">JUDUL BUKU</th>
                            <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">KATEGORI</th>
                            <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">TANGGAL USUL</th>
                            <th class="px-5 py-3 text-center text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($pengajuan as $item)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-5 py-3.5 align-middle">
                                <div class="font-semibold text-slate-800 text-[0.85rem] leading-tight">
                                    {{ $item->judul_buku }}
                                </div>
                                @if($item->penulis)
                                    <div class="text-[0.75rem] text-slate-400 mt-0.5">
                                        {{ $item->penulis }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-slate-500 text-[0.8rem] align-middle">
                                {{ $item->category->name ?? '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-slate-500 text-[0.8rem] align-middle">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3.5 align-middle text-center">
                                @if($item->status === 'menunggu')
                                    <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fef9c3] text-[#a16207]">MENUNGGU</span>
                                @elseif($item->status === 'disetujui')
                                    <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#dcfce7] text-[#16a34a]">DISETUJUI</span>
                                @else
                                    <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fee2e2] text-[#dc2626]">DITOLAK</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(method_exists($pengajuan, 'hasPages') && $pengajuan->hasPages())
                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $pengajuan->links() }}
                </div>
            @endif
        @endif
    </div>

</div>

{{-- Wrapper for Form View --}}
<div id="view-form" @if(!$errors->any()) style="display:none;" @endif>
    
    <div style="margin-bottom: 20px;">
        <button type="button" class="btn-secondary" onclick="toggleView('list')">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Kembali
        </button>
    </div>

    <form method="POST" action="{{ route('siswa.pengajuan.store') }}">
    @csrf

    <div class="usul-grid">
    <div>
        {{-- Banner --}}
        <div class="mb-6">
            <h1 class="text-[1.35rem] font-bold text-indigo-950">Usulkan Buku Baru</h1>
            <p class="text-slate-500 text-[0.875rem] mt-1">Bantu kembangkan koleksi perpustakaan</p>
        </div>

        {{-- Informasi Buku --}}
        <div class="usul-card">
            <div class="usul-card-hdr">
                <h2>Informasi Buku</h2>
                <p>Detail buku yang ingin Anda usulkan</p>
            </div>
            <div class="usul-card-body">
                {{-- Judul Buku --}}
                <div class="form-group">
                    <label>Judul Buku <span class="req">*</span></label>
                    <input type="text" name="judul_buku" class="form-control {{ $errors->has('judul_buku') ? 'is-invalid' : '' }}"
                        placeholder=""
                        value="{{ old('judul_buku') }}" required>
                    @error('judul_buku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Nama Penulis --}}
                <div class="form-group">
                    <label>Nama Penulis / Pengarang <span class="req">*</span></label>
                    <input type="text" name="penulis" class="form-control {{ $errors->has('penulis') ? 'is-invalid' : '' }}"
                        placeholder=""
                        value="{{ old('penulis') }}" required>
                    @error('penulis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- ISBN & Penerbit --}}
                <div class="form-row">
                    <div class="form-group">
                        <label>Nomor ISBN <span class="opt">(opsional)</span></label>
                        <input type="text" name="isbn" class="form-control {{ $errors->has('isbn') ? 'is-invalid' : '' }}"
                            placeholder=""
                            value="{{ old('isbn') }}">
                        @error('isbn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Penerbit <span class="opt">(opsional)</span></label>
                        <input type="text" name="penerbit" class="form-control {{ $errors->has('penerbit') ? 'is-invalid' : '' }}"
                            placeholder=""
                            value="{{ old('penerbit') }}">
                        @error('penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Tahun & Kategori --}}
                <div class="form-row">
                    <div class="form-group">
                        <label>Tahun Terbit <span class="opt">(opsional)</span></label>
                        <input type="number" name="tahun_terbit" class="form-control {{ $errors->has('tahun_terbit') ? 'is-invalid' : '' }}"
                            placeholder=""
                            value="{{ old('tahun_terbit') }}" min="1900" max="{{ date('Y') + 1 }}">
                        @error('tahun_terbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label>Kategori <span class="opt">(opsional)</span></label>
                        <select name="category_id" class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Right column ── --}}
    <div class="usul-right">
        {{-- Informasi Pengusul --}}
        <div class="usul-card">
            <div class="usul-card-hdr">
                <h2>Informasi Pengusul</h2>
                <p>Data diri dan alasan pengusulan</p>
            </div>
            <div class="usul-card-body">
                {{-- Nama --}}
                <div class="form-group">
                    <label>Nama Lengkap Pengusul <span class="req">*</span></label>
                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                </div>

                {{-- Alasan --}}
                <div class="form-group">
                    <label>Alasan Pengusulan <span class="req">*</span></label>
                    <textarea name="alasan" class="form-control {{ $errors->has('alasan') ? 'is-invalid' : '' }}"
                        placeholder="Jelaskan mengapa buku ini perlu diadakan di perpustakaan..." required>{{ old('alasan') }}</textarea>
                    <div style="font-size:0.73rem;color:#94a3b8;margin-top:5px;">Minimal 10 karakter</div>
                    @error('alasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Footer --}}
                <div class="usul-footer">
                    <span class="note"><span>*</span> Wajib diisi</span>
                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <line x1="22" y1="2" x2="11" y2="13"/>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                        Kirim Pengajuan
                    </button>
                </div>
            </div>
        </div>

        {{-- Info note --}}
        <div class="usul-info">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="16" x2="12" y2="12"/>
                <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            Pengajuan Anda akan ditinjau oleh admin perpustakaan. Proses review biasanya membutuhkan 1–3 hari kerja.
        </div>
    </div>
    </div>
    </form>
</div>

{{-- Kirim Pesan ke Penjaga --}}
<div class="mt-8 mb-6">
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] border border-slate-100">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#4361ee" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0l-8 4-8-4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-slate-800 text-[0.95rem] m-0">Kirim Pesan ke Penjaga</h2>
                    <p class="text-[0.75rem] text-slate-400 m-0">Ada pertanyaan atau hal yang ingin disampaikan?</p>
                </div>
            </div>
        </div>

        <div id="pesanForm" class="px-6 py-5">
            @if(session('success') && str_contains(session('success'), 'Pesan'))
            <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-4 text-[0.82rem] flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
            @endif

            <form method="POST" action="{{ route('siswa.pengajuan.pesan') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-[0.8rem] font-semibold text-slate-700 mb-1.5">Subjek <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        name="subject"
                        placeholder="Mis: Pertanyaan tentang peminjaman..."
                        value="{{ old('subject') }}"
                        required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[0.86rem] text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all box-border"
                    >
                    @error('subject')
                    <p class="text-red-500 text-[0.73rem] mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-[0.8rem] font-semibold text-slate-700 mb-1.5">Pesan <span class="text-red-500">*</span></label>
                    <textarea
                        name="body"
                        rows="4"
                        placeholder="Tulis pesanmu di sini..."
                        required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-[0.86rem] text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all resize-none box-border"
                    >{{ old('body') }}</textarea>
                    <p class="text-[0.72rem] text-slate-400 mt-1">Minimal 10 &bull; Maksimal 2000 karakter</p>
                    @error('body')
                    <p class="text-red-500 text-[0.73rem] mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div style="display:flex; justify-content:flex-end; margin-top:12px;">
                    <button type="submit"
                        class="focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500"
                        style="display:inline-flex; align-items:center; justify-content:center; gap:8px; background-color:#4f46e5; color:#ffffff; border:none; border-radius:8px; padding:10px 24px; font-size:0.875rem; font-weight:600; cursor:pointer; transition:background-color 0.2s;"
                        onmouseover="this.style.backgroundColor='#4338ca'"
                        onmouseout="this.style.backgroundColor='#4f46e5'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function toggleView(view) {
        if (view === 'form') {
            document.getElementById('view-list').style.display = 'none';
            document.getElementById('view-form').style.display = 'block';
        } else {
            document.getElementById('view-form').style.display = 'none';
            document.getElementById('view-list').style.display = 'block';
        }
    }
</script>
@endpush
