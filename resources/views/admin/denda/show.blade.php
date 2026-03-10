@extends('layouts.admin')

@section('title', 'Detail Denda')

@push('styles')
<style>
    .breadcrumb { font-size: 0.85rem; margin-bottom: 20px; }
    .breadcrumb a { color: #4361ee; text-decoration: none; }
    .breadcrumb span { color: #666; }

    .detail-card {
        background: #fff; border-radius: 14px;
        border: 1px solid #eee; padding: 32px;
        max-width: 600px;
    }
    .detail-card h3 {
        font-size: 1.1rem; font-weight: 700;
        color: #222; margin: 0 0 24px;
        padding-bottom: 16px; border-bottom: 1px solid #f0f0f0;
    }
    .detail-row {
        display: flex; gap: 16px; margin-bottom: 16px;
        align-items: flex-start;
    }
    .detail-label {
        font-size: 0.78rem; font-weight: 700;
        color: #888; text-transform: uppercase;
        min-width: 130px; padding-top: 2px;
    }
    .detail-value { font-size: 0.88rem; color: #333; font-weight: 500; }

    .badge {
        display: inline-block; padding: 4px 14px;
        border-radius: 20px; font-size: 0.72rem; font-weight: 700;
    }
    .badge-danger { background: #fee2e2; color: #dc2626; }

    .fine-box {
        background: #fff5f5; border: 1px solid #fca5a5;
        border-radius: 10px; padding: 20px 24px;
        margin-top: 24px; margin-bottom: 10px;
    }
    .fine-box h4 { font-size: 0.9rem; color: #dc2626; font-weight: 700; margin: 0 0 10px; }
    .fine-amount { font-size: 1.6rem; font-weight: 800; color: #dc2626; }
    .fine-days { font-size: 0.78rem; color: #888; margin-top: 4px; }

    .btn-back {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f5f5f5; color: #444; border: 1px solid #ddd;
        border-radius: 8px; padding: 8px 18px;
        font-size: 0.85rem; font-weight: 600;
        text-decoration: none; margin-top: 24px;
        transition: background 0.15s;
    }
    .btn-back:hover { background: #ebebeb; color: #222; }
</style>
@endpush

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.denda.index') }}">Denda</a>
        <span> / Detail</span>
    </div>

    <div class="detail-card">
        <h3>Detail Denda</h3>

        <div class="detail-row">
            <span class="detail-label">Nama Peminjam</span>
            <span class="detail-value">{{ $denda->user->name ?? '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Email</span>
            <span class="detail-value">{{ $denda->user->email ?? '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Judul Buku</span>
            <span class="detail-value">{{ $denda->book->title ?? '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Tgl Pinjam</span>
            <span class="detail-value">{{ $denda->borrow_date ? $denda->borrow_date->format('Y-m-d') : '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Deadline</span>
            <span class="detail-value">{{ $denda->deadline ? $denda->deadline->format('Y-m-d') : '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Status</span>
            <span class="detail-value">
                <span class="badge badge-danger">Terlambat</span>
            </span>
        </div>

        @if($denda->deadline)
        @php
            $hariTerlambat = now()->diffInDays($denda->deadline);
            $dendaPerHari = 1000;
            $totalDenda = $hariTerlambat * $dendaPerHari;
        @endphp
        <div class="fine-box">
            <h4>⚠ Total Denda Keterlambatan</h4>
            <div class="fine-amount">IDR {{ number_format($totalDenda, 0, ',', '.') }}</div>
            <div class="fine-days">{{ $hariTerlambat }} hari × IDR {{ number_format($dendaPerHari, 0, ',', '.') }}/hari</div>
        </div>
        @endif

        <a href="{{ route('admin.denda.index') }}" class="btn-back">← Kembali ke Daftar Denda</a>
    </div>
@endsection
