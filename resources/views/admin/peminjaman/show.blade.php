@extends('layouts.admin')

@section('title', 'Detail Peminjaman')

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
    .badge-warning { background: #fef9c3; color: #92400e; }
    .badge-success { background: #d1fae5; color: #065f46; }

    .fine-box {
        background: #fff5f5; border: 1px solid #fca5a5;
        border-radius: 10px; padding: 16px 20px;
        margin-top: 24px;
    }
    .fine-box h4 { font-size: 0.9rem; color: #dc2626; font-weight: 700; margin: 0 0 10px; }
    .fine-amount { font-size: 1.4rem; font-weight: 800; color: #dc2626; }
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
        <a href="{{ route('admin.peminjaman.index') }}">Peminjaman</a>
        <span> / Detail</span>
    </div>

    <div class="detail-card">
        <h3>Detail Peminjaman</h3>

        <div class="detail-row">
            <span class="detail-label">Nama Peminjam</span>
            <span class="detail-value">{{ $peminjaman->user->name ?? '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Email</span>
            <span class="detail-value">{{ $peminjaman->user->email ?? '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Judul Buku</span>
            <span class="detail-value">{{ $peminjaman->book->title ?? '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Tgl Pinjam</span>
            <span class="detail-value">{{ $peminjaman->borrow_date ? $peminjaman->borrow_date->format('Y-m-d') : '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Deadline</span>
            <span class="detail-value">{{ $peminjaman->deadline ? $peminjaman->deadline->format('Y-m-d') : '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Tgl Kembali</span>
            <span class="detail-value">{{ $peminjaman->return_date ? $peminjaman->return_date->format('Y-m-d') : '-' }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Status</span>
            <span class="detail-value">
                @php $st = $peminjaman->status_display; @endphp
                @if($st === 'terlambat')
                    <span class="badge badge-danger">Terlambat</span>
                @elseif($st === 'dipinjam')
                    <span class="badge badge-warning">Dipinjam</span>
                @else
                    <span class="badge badge-success">Dikembalikan</span>
                @endif
            </span>
        </div>

        @if($peminjaman->status_display === 'terlambat' && $peminjaman->deadline)
        @php
            $hariTerlambat = now()->diffInDays($peminjaman->deadline);
            $dendaPerHari = 1000;
            $totalDenda = $hariTerlambat * $dendaPerHari;
        @endphp
        <div class="fine-box">
            <h4>⚠ Denda Keterlambatan</h4>
            <div class="fine-amount">IDR {{ number_format($totalDenda, 0, ',', '.') }}</div>
            <div class="fine-days">{{ $hariTerlambat }} hari × IDR {{ number_format($dendaPerHari, 0, ',', '.') }}/hari</div>
        </div>
        @endif

        <a href="{{ route('admin.peminjaman.index') }}" class="btn-back">← Kembali</a>
    </div>
@endsection
