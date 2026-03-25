@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<style>
    .breadcrumb { font-size: 0.85rem; color: #4361ee; margin-bottom: 20px; }

    /* Stat Cards (Laporan Admin Style) */
    .stat-cards {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 16px; margin-bottom: 28px;
    }
    .stat-card {
        background: #fff; border-radius: 14px;
        padding: 20px 24px; border: 1.5px solid #e5e7eb;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .stat-card-label { font-size: 0.8rem; color: #666; margin: 0 0 4px; font-weight: 500; }
    .stat-card-value { font-size: 2rem; font-weight: 700; color: #222; margin: 0; }
    .stat-card-value.danger { color: #ef4444; }
    .stat-card-value.success { color: #22c55e; }
    .stat-card-value.warning { color: #f59e0b; }
    .stat-card-icon {
        width: 44px; height: 44px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; flex-shrink: 0;
    }
    .stat-card:nth-child(1) .stat-card-icon { background: #eef0ff; color: #4361ee; }
    .stat-card:nth-child(2) .stat-card-icon { background: #ede9fe; color: #8b5cf6; }
    .stat-card:nth-child(3) .stat-card-icon { background: #fef3c7; color: #f59e0b; }
    .stat-card:nth-child(4) .stat-card-icon { background: #dcfce7; color: #16a34a; }
    /* Aksi Cepat */
    .quick-actions-section {
        background: #f8f9fb; border-radius: 14px;
        padding: 24px; border: 1px solid #eee;
    }
    .quick-actions-section h3 { font-size: 1rem; font-weight: 700; color: #222; margin: 0 0 16px; }
    .quick-actions-grid {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;
    }
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
    .quick-action-card:nth-child(1) .quick-action-icon { background: #eef0ff; color: #4361ee; }
    .quick-action-card:nth-child(2) .quick-action-icon { background: #ede9fe; color: #8b5cf6; }
    .quick-action-card:nth-child(3) .quick-action-icon { background: #d1fae5; color: #059669; }
    .quick-action-card:hover .quick-action-icon { background: #4361ee; color: #fff; }
    .quick-action-title { font-size: 0.9rem; font-weight: 600; text-align: center; margin: 0; }
</style>
@endpush

@section('content')
    {{-- Breadcrumb --}}
    <div class="breadcrumb">Dashboard</div>

    {{-- Stat Cards --}}
    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Total Buku</p>
                <p class="stat-card-value">{{ $totalBuku }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Total Pengguna</p>
                <p class="stat-card-value">{{ $totalPengguna }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Peminjaman Aktif</p>
                <p class="stat-card-value warning">{{ $peminjamanAktif }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Total Denda Terkumpul (Lunas)</p>
                <p class="stat-card-value success" style="font-size: 1.5rem;">Rp {{ number_format(abs($totalDenda), 0, ',', '.') }}</p>
            </div>
            <div class="stat-card-icon" style="border-radius: 12px; width: 48px; height: 48px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v20m5-17H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Aksi Cepat --}}
    <div class="quick-actions-section">
        <h3>Aksi Cepat</h3>
        <div class="quick-actions-grid">
            <a href="{{ route('admin.kategori.index') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <p class="quick-action-title">Kelola Data</p>
            </a>
            <a href="{{ route('admin.pengguna.index') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p class="quick-action-title">Kelola Pengguna</p>
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <p class="quick-action-title">Laporan</p>
            </a>
        </div>
    </div>
@endsection
