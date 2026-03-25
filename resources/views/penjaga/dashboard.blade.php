@extends('layouts.penjaga')

@section('title', 'Dashboard Penjaga')

@section('content')
<div>

    {{-- Sambutan --}}
    <div class="mb-6">
        <h1 class="text-[1.35rem] font-bold text-sky-950">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-slate-500 text-[0.875rem] mt-1">Panel penjaga perpustakaan LibSchool.</p>
    </div>

    {{-- Kartu Statistik --}}
    @php
        use App\Models\Book;
        use App\Models\Borrowing;
        use App\Models\Fine;
        $totalBuku      = Book::sum('stock');
        $sedangDipinjam = Borrowing::where('status', 'dipinjam')->count();
        $belumKembali   = Borrowing::where('status', 'dipinjam')
                            ->whereNotNull('deadline')
                            ->whereDate('deadline', '<', now())
                            ->count();
        $menungguBooking = Borrowing::where('status', 'booking')->count();

        // Ambil Hak Akses Penjaga
        $perms = json_decode(Auth::user()->permissions ?? '[]', true) ?? [];
        $aksesDasar = ['Peminjaman', 'Pengembalian', 'Riwayat Transaksi'];
        
        $semuaFiturTambahan = [
            'kategori'   => 'Kategori Buku',
            'buku'       => 'Data Buku',
            'series'     => 'Series Buku',
            'peminjaman' => 'Kelola Peminjaman (Admin)',
            'denda'      => 'Kelola Denda',
            'pengajuan'  => 'Pengajuan Buku',
            'laporan'    => 'Laporan Transaksi'
        ];

        $aksesArray = [];
        foreach ($aksesDasar as $dasar) {
            $aksesArray[] = ['name' => $dasar, 'has_access' => true];
        }
        foreach ($semuaFiturTambahan as $key => $label) {
            $aksesArray[] = [
                'name' => $label,
                'has_access' => in_array($key, $perms)
            ];
        }
    @endphp
@push('styles')
<style>
    /* Stat Cards (Laporan Admin Style) */
    .stat-cards {
        display: grid; grid-template-columns: repeat(3, 1fr);
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
    .stat-card-value.purple { color: #8b5cf6; }
    .stat-card-value.indigo { color: #4f46e5; }
    .stat-card-icon {
        width: 44px; height: 44px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; flex-shrink: 0;
    }
    .stat-card:nth-child(1) .stat-card-icon { background: #eef0ff; color: #4361ee; }
    .stat-card:nth-child(2) .stat-card-icon { background: #fef3c7; color: #f59e0b; }
    .stat-card:nth-child(3) .stat-card-icon { background: #ede9fe; color: #8b5cf6; }

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
    .quick-action-card:hover .quick-action-icon { background: #4361ee; color: #fff; }
    .quick-action-title { font-size: 0.9rem; font-weight: 600; text-align: center; margin: 0; }

    /* Akses Fitur */
    .akses-section {
        background: #fff; border-radius: 14px;
        padding: 24px; border: 1px solid #eee; margin-top: 24px;
    }
    .akses-section h3 { font-size: 1rem; font-weight: 700; color: #222; margin: 0 0 6px; }
    .akses-section p.subtitle { font-size: 0.85rem; color: #666; margin: 0 0 16px; }
    .akses-list { display: flex; flex-wrap: wrap; gap: 10px; }
    .akses-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f8f9fa; border: 1px solid #e5e7eb;
        color: #4b5563; padding: 6px 14px; border-radius: 20px;
        font-size: 0.8rem; font-weight: 600;
    }
    .akses-badge.active svg { color: #10b981; }
    .akses-badge.inactive { background: #fef2f2; border-color: #fecaca; color: #9ca3af; }
    .akses-badge.inactive svg { color: #ef4444; }
</style>
@endpush

    <div class="stat-cards">
        {{-- Total Buku --}}
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Total Stok Buku</p>
                <p class="stat-card-value">{{ $totalBuku }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
        </div>
        {{-- Sedang Dipinjam --}}
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Aktif</p>
                <p class="stat-card-value warning">{{ $sedangDipinjam }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        {{-- Menunggu Konfirmasi --}}
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Menunggu Konfirmasi</p>
                <p class="stat-card-value purple">{{ $menungguBooking }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            </div>
        </div>

    </div>

    <div class="quick-actions-section">
        <h3>Aksi Cepat</h3>
        <div class="quick-actions-grid">
            <a href="{{ route('penjaga.peminjaman') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                </div>
                <p class="quick-action-title">Peminjaman</p>
            </a>
            <a href="{{ route('penjaga.pengembalian') }}" class="quick-action-card">
                <div class="quick-action-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                </div>
                <p class="quick-action-title">Pengembalian</p>
            </a>
            <a href="{{ route('penjaga.inbox') }}" class="quick-action-card">
                <div class="quick-action-icon relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0l-8 4-8-4"/></svg>
                    @php $inboxUnread = \App\Models\Message::where('is_read', false)->count(); @endphp
                    @if($inboxUnread > 0)
                    <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[0.6rem] font-bold text-white tracking-tighter">{{ $inboxUnread }}</span>
                    @endif
                </div>
                <p class="quick-action-title">Inbox Pesan</p>
            </a>
        </div>
    </div>

    {{-- Akses Fitur yang Dimiliki --}}
    <div class="akses-section">
        <h3>Fitur Tambahan</h3>
        <p class="subtitle">Berikut adalah daftar status akses fitur tambahan anda</p>
        <div class="akses-list">
            @foreach($aksesArray as $akses)
                <span class="akses-badge {{ $akses['has_access'] ? 'active' : 'inactive' }}">
                    @if($akses['has_access'])
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    @endif
                    {{ $akses['name'] }}
                </span>
            @endforeach
        </div>
    </div>

</div>
@endsection
