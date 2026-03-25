@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.penjaga')

@section('title', 'Detail Denda')

@push('styles')
<style>
    .breadcrumb { font-size: 0.85rem; margin-bottom: 20px; }
    .breadcrumb a { color: #4361ee; text-decoration: none; }
    .breadcrumb span { color: #666; }

    .detail-card {
        background: #fff; border-radius: 14px;
        border: 1px solid #eee; padding: 32px;
        max-width: 640px;
    }
    .detail-card h3 {
        font-size: 1.1rem; font-weight: 700;
        color: #222; margin: 0 0 24px;
        padding-bottom: 16px; border-bottom: 1px solid #f0f0f0;
        display: flex; align-items: center; gap: 8px;
    }

    .detail-section {
        background: #fafafa; border-radius: 10px;
        border: 1px solid #f0f0f0;
        padding: 16px 20px; margin-bottom: 16px;
    }
    .detail-section-title {
        font-size: 0.72rem; font-weight: 700;
        color: #aaa; text-transform: uppercase;
        letter-spacing: 0.05em; margin-bottom: 14px;
    }
    .detail-row {
        display: flex; gap: 16px; margin-bottom: 10px;
        align-items: flex-start;
    }
    .detail-row:last-child { margin-bottom: 0; }
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
    .badge-danger { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }

    .fine-box {
        background: linear-gradient(135deg, #fff1f2, #fff5f5);
        border: 1.5px solid #fca5a5;
        border-radius: 12px; padding: 20px 24px;
        margin-bottom: 20px;
        display: flex; align-items: center; justify-content: space-between; gap: 16px;
    }
    .fine-box-left h4 {
        font-size: 0.82rem; color: #b91c1c;
        font-weight: 700; margin: 0 0 6px;
        text-transform: uppercase; letter-spacing: 0.04em;
    }
    .fine-amount { font-size: 1.9rem; font-weight: 800; color: #dc2626; line-height: 1; }
    .fine-days { font-size: 0.78rem; color: #ef4444; margin-top: 6px; font-weight: 500; }

    .fine-box-icon {
        background: #fee2e2; color: #dc2626;
        width: 52px; height: 52px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .btn-back {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f5f5f5; color: #444; border: 1px solid #ddd;
        border-radius: 8px; padding: 9px 18px;
        font-size: 0.85rem; font-weight: 600;
        text-decoration: none;
        transition: background 0.15s; font-family: inherit;
    }
    .btn-back:hover { background: #eee; }

    .btn-selesaikan {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #16a34a, #15803d);
        color: #fff; border: none;
        border-radius: 8px; padding: 9px 22px;
        font-size: 0.85rem; font-weight: 700;
        cursor: pointer; font-family: inherit;
        transition: opacity 0.15s; margin-right: 10px;
        box-shadow: 0 2px 8px rgba(22,163,74,0.25);
    }
    .btn-selesaikan:hover { opacity: 0.88; }
</style>
@endpush

@section('content')
    <div class="breadcrumb">
        <a href="{{ route('admin.denda.index') }}">Denda</a>
        <span> / Detail</span>
    </div>

    <div class="detail-card">
        <h3>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            Detail Keterlambatan
        </h3>

        {{-- Info Peminjam --}}
        <div class="detail-section">
            <div class="detail-section-title">Data Peminjam</div>
            <div class="detail-row">
                <span class="detail-label">Nama</span>
                <span class="detail-value">{{ $denda->user->name ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">{{ $denda->user->email ?? '-' }}</span>
            </div>
        </div>

        {{-- Info Buku --}}
        <div class="detail-section">
            <div class="detail-section-title">Data Peminjaman</div>
            <div class="detail-row">
                <span class="detail-label">Judul Buku</span>
                <span class="detail-value">{{ $denda->book->title ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tgl Pinjam</span>
                <span class="detail-value">{{ $denda->borrow_date ? $denda->borrow_date->format('d M Y') : '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Deadline</span>
                <span class="detail-value">{{ $denda->deadline ? $denda->deadline->format('d M Y') : '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status</span>
                <span class="detail-value">
                    <span class="badge badge-danger">Terlambat</span>
                </span>
            </div>
        </div>

        {{-- Kalkulasi Denda --}}
        @if($denda->deadline)
        @php
            $hariTerlambat = now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($denda->deadline)->startOfDay());
            $dendaPerHari  = 2000;
            $totalDenda    = $hariTerlambat * $dendaPerHari;
        @endphp
        <div class="fine-box">
            <div class="fine-box-left">
                <h4>⚠ Total Denda Keterlambatan</h4>
                <div class="fine-amount">Rp {{ number_format($totalDenda, 0, ',', '.') }}</div>
                <div class="fine-days">
                    {{ $hariTerlambat }} hari × Rp {{ number_format($dendaPerHari, 0, ',', '.') }}/hari
                    &nbsp;·&nbsp; Deadline: {{ $denda->deadline->format('d M Y') }}
                </div>
            </div>
            <div class="fine-box-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v20m5-17H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
        </div>
        @endif

        <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 10px;">
            <form action="{{ route('admin.denda.kembalikan', $denda->id) }}" method="POST" data-name="{{ $denda->user->name ?? '' }}"
                  onsubmit="confirmAction(event, 'Terima buku dan selesaikan denda untuk ' + this.dataset.name + '?', 'Ya, Selesaikan', 'Konfirmasi Denda', false); return false;">
                @csrf
                <button type="submit" class="btn-selesaikan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Selesaikan Denda
                </button>
            </form>
            <a href="{{ route('admin.denda.index') }}" class="btn-back">← Kembali</a>
        </div>
    </div>
@endsection
