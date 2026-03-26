@extends('layouts.siswa')

@section('title', 'Riwayat & Denda')

@push('styles')
<style>
    .content-panel {
        background: #fff; border-radius: 14px;
        border: 1px solid #eee; overflow: hidden;
    }

    /* ── Stat Cards ── */
    .pj-stats {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 16px; margin-bottom: 24px;
    }
    @media (max-width: 900px) { .pj-stats { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px)  { .pj-stats { grid-template-columns: repeat(2, 1fr); gap: 10px; } }

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

    /* Total / Blue */
    .pj-stat-blue { background: #eff6ff; border-color: #bfdbfe; }
    .pj-stat-blue .pj-stat-label { color: #2563eb; }
    .pj-stat-blue .pj-stat-value { color: #1e40af; }
    .pj-stat-blue .pj-stat-icon  { background: #dbeafe; color: #2563eb; }

    /* Warning / Yellow (Wait) */
    .pj-stat-wait { background: #fefce8; border-color: #fef08a; }
    .pj-stat-wait .pj-stat-label  { color: #ca8a04; }
    .pj-stat-wait .pj-stat-value  { color: #ca8a04; }
    .pj-stat-wait .pj-stat-icon   { background: #fef08a; }

    /* Success / Green */
    .pj-stat-ok { background: #f0fdf4; border-color: #bbf7d0; }
    .pj-stat-ok .pj-stat-label { color: #16a34a; }
    .pj-stat-ok .pj-stat-value { color: #166534; }
    .pj-stat-ok .pj-stat-icon  { background: #dcfce7; color: #16a34a; }

    /* Danger / Red */
    .pj-stat-no { background: #fff1f2; border-color: #fecdd3; }
    .pj-stat-no .pj-stat-label { color: #dc2626; }
    .pj-stat-no .pj-stat-value { color: #991b1b; }
    .pj-stat-no .pj-stat-icon  { background: #fecdd3; color: #dc2626; }

    /* Default / White-Grey */
    .pj-stat-total { background: #fff; border-color: #e2e8f0; }
    .pj-stat-total .pj-stat-label { color: #64748b; }
    .pj-stat-total .pj-stat-value { color: #1e293b; }
    .pj-stat-total .pj-stat-icon  { background: #f1f5f9; color: #64748b; }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-[1.5rem] font-bold text-slate-900">Riwayat & Denda</h1>
        <p class="text-slate-500 text-[0.875rem] mt-1">Pantau riwayat transaksi dan denda Anda</p>
    </div>

    {{-- ── 4 Stat Cards ─────────────────── --}}
    <div class="pj-stats">

        {{-- Buku Dipinjam --}}
        <div class="pj-stat pj-stat-blue">
            <div>
                <p class="pj-stat-label">Buku Dipinjam</p>
                <p class="pj-stat-value">{{ $totalBorrowed }}</p>
            </div>
            <div class="pj-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>

        {{-- Tepat Waktu --}}
        <div class="pj-stat pj-stat-ok">
            <div>
                <p class="pj-stat-label">Tepat Waktu</p>
                <p class="pj-stat-value">{{ $totalTepatWaktu }}</p>
            </div>
            <div class="pj-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        {{-- Terlambat --}}
        <div class="pj-stat pj-stat-wait">
            <div>
                <p class="pj-stat-label">Terlambat</p>
                <p class="pj-stat-value">{{ $totalTerlambat }}</p>
            </div>
            <div class="pj-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        {{-- Total Denda --}}
        <div class="pj-stat {{ $totalSemuaDenda > 0 ? 'pj-stat-no' : 'pj-stat-total' }}">
            <div>
                <p class="pj-stat-label">Total Denda</p>
                <p class="pj-stat-value" style="font-size: 1.4rem; padding-top: 5px;">Rp {{ number_format($totalSemuaDenda, 0, ',', '.') }}</p>
            </div>
            <div class="pj-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

    </div>



    {{-- ── Denda Panel (Side by Side) ───────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mb-6">
        
        {{-- Total Tagihan Denda --}}
        @if($totalDenda > 0)
        <div class="lg:col-span-4 bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] p-6">
            <p class="text-[0.75rem] font-semibold text-slate-400 uppercase tracking-wide mb-2">Total Tagihan Denda</p>
            <p class="text-[1.8rem] font-bold text-slate-900 mb-2">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
            <p class="text-[0.75rem] text-orange-500 font-medium">⚠ Denda perlu dilunasi ke petugas perpustakaan agar akun tidak diblokir.</p>
        </div>
        @endif

        {{-- Rincian Tagihan --}}
        <div class="{{ $totalDenda > 0 ? 'lg:col-span-8' : 'lg:col-span-12' }} bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-slate-800 text-[1rem]">Rincian Tagihan</h2>
                @php
                    $totalTagihanItems = $unpaidFines->count() + $lateWithoutFine->count();
                @endphp
                <span class="text-[0.75rem] text-slate-400 font-medium">{{ $totalTagihanItems }} item</span>
            </div>

            @if($unpaidFines->isEmpty() && $lateWithoutFine->isEmpty())
                <div class="flex flex-col items-center justify-center py-10 gap-2">
                    <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="font-bold text-slate-700 text-[0.9rem]">Tidak ada tagihan</p>
                    <p class="text-[0.78rem] text-slate-400 text-center">Anda belum memiliki denda yang harus dibayar.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse min-w-[500px]">
                        <thead>
                            <tr class="bg-slate-50">
                                <th class="px-6 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">BUKU</th>
                                <th class="px-6 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">KETERANGAN</th>
                                <th class="px-6 py-3 text-right text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">NOMINAL</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">

                            @foreach($unpaidFines as $fine)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-6 py-3.5 align-middle">
                                    <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight max-w-[200px] truncate">
                                        {{ $fine->borrowing->book->title ?? 'Buku tidak diketahui' }}
                                    </p>
                                </td>
                                <td class="px-6 py-3.5 align-middle">
                                    @if($fine->payment_status === 'pending')
                                        <div class="flex flex-col items-start">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-amber-50 text-amber-600 border border-amber-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                                Menunggu Verifikasi
                                            </span>
                                            <p class="text-[0.65rem] text-slate-400 mt-1 uppercase font-semibold">REF: {{ $fine->payment_code }}</p>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fee2e2] text-[#dc2626]">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#dc2626] inline-block"></span>Denda Terlambat
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-3.5 align-middle text-right">
                                    <p class="font-bold {{ $fine->payment_status === 'pending' ? 'text-amber-600' : 'text-slate-800' }} text-[0.85rem]">
                                        Rp {{ number_format(abs($fine->amount), 0, ',', '.') }}
                                    </p>
                                </td>
                            </tr>
                            @endforeach

                            @foreach($lateWithoutFine as $loan)
                            @php
                                $estAmount = now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($loan->deadline)->startOfDay()) * 2000;
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-6 py-3.5 align-middle">
                                    <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight max-w-[200px] truncate">
                                        {{ $loan->book->title ?? 'Buku tidak diketahui' }}
                                    </p>
                                </td>
                                <td class="px-6 py-3.5 align-middle">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-orange-50 text-orange-600 border border-orange-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/></svg>
                                        Estimasi Berjalan
                                    </span>
                                </td>
                                <td class="px-6 py-3.5 align-middle text-right">
                                    <p class="font-bold text-slate-800 text-[0.85rem]">
                                        Rp {{ number_format($estAmount, 0, ',', '.') }}
                                    </p>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

                @php
                    $payableFines = $unpaidFines->where('payment_status', 'unpaid');
                    $payableAmount = $payableFines->sum('amount');
                @endphp

                @if($payableFines->isNotEmpty())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <p class="text-[0.7rem] text-slate-500 font-medium">Total Menunggu Pembayaran</p>
                        <p class="text-[1.1rem] font-bold text-slate-800">Rp {{ number_format(abs($payableAmount), 0, ',', '.') }}</p>
                    </div>
                    <button type="button" onclick="openBayarModal()" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-[0.85rem] rounded-xl transition-colors whitespace-nowrap">
                        Bayar Sekarang
                    </button>
                </div>
                @endif
            @endif
        </div>
    </div>

{{-- Riwayat Peminjaman Panel --}}
    <div class="content-panel" style="margin-bottom: 24px;">
        {{-- History Table --}}
        <div class="px-6 pt-5 pb-2 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-slate-800 text-[1rem]">Riwayat Peminjaman</h2>
                <p class="text-[0.78rem] text-slate-400 mt-0.5">{{ $recentHistory->count() }} data denda atau buku yang dikembalikan</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">BUKU</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">TGL PINJAM</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">TGL KEMBALI</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">STATUS</th>
                        <th class="px-5 py-3 text-right text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">DENDA</th>
                    </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($recentHistory as $loan)
                            @php
                                $isLate = false;
                                $isDeadline = false;
                                $isReturnedLate = false;
                                
                                if ($loan->status === 'dipinjam' && $loan->deadline) {
                                    $deadlineDate = \Carbon\Carbon::parse($loan->deadline)->startOfDay();
                                    $today = now()->startOfDay();
                                    $diff = $today->diffInDays($deadlineDate, false);
                                    
                                    if ($diff < 0) {
                                        $isLate = true;
                                    } elseif ($diff >= 0 && $diff <= 1) {
                                        $isDeadline = true;
                                    }
                                } elseif ($loan->status === 'dikembalikan' && $loan->deadline && $loan->return_date) {
                                    $deadlineDate = \Carbon\Carbon::parse($loan->deadline)->startOfDay();
                                    $returnDate = \Carbon\Carbon::parse($loan->return_date)->startOfDay();
                                    if ($returnDate->gt($deadlineDate) || $loan->fine) {
                                        $isReturnedLate = true;
                                    }
                                }
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                {{-- Buku --}}
                                <td class="px-5 py-3.5 align-middle">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-11 rounded bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200 flex items-center justify-center">
                                            @if($loan->book && $loan->book->cover)
                                                <img src="{{ asset('storage/' . $loan->book->cover) }}" alt="Cover" class="w-full h-full object-cover">
                                            @elseif($loan->book && $loan->book->cover_image)
                                                <img src="{{ asset('storage/' . $loan->book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-5 h-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[160px]">{{ $loan->book->title ?? '-' }}</p>
                                            <p class="text-[0.7rem] text-slate-400 truncate max-w-[160px]">{{ $loan->book->author ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                                    {{ $loan->borrow_date ? $loan->borrow_date->format('d M Y') : '—' }}
                                </td>
                                <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                                    {{ $loan->return_date ? $loan->return_date->format('d M Y') : ($loan->deadline ? $loan->deadline->format('d M Y') : '—') }}
                                </td>
                                <td class="px-5 py-3.5 align-middle">
                                    @if($isReturnedLate)
                                        <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fee2e2] text-[#dc2626]">TERLAMBAT</span>
                                    @else
                                        <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#dcfce7] text-[#16a34a]">TEPAT WAKTU</span>
                                    @endif
                                </td>
                                {{-- Denda --}}
                                <td class="px-5 py-3.5 text-right align-middle">
                                    @php $fineAmount = $loan->fine?->amount ?? 0; @endphp
                                    @if(abs($fineAmount) > 0)
                                        <span class="font-bold text-[0.78rem] text-red-600">Rp {{ number_format(abs($fineAmount), 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-slate-300 text-[0.78rem]">—</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-5 py-14 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                        </svg>
                                        <p class="text-slate-400 text-[0.85rem]">Belum ada riwayat peminjaman.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
        </div>
    </div>

    </div>

{{-- MODAL BAYAR --}}
<div class="modal-overlay" id="bayarModal">
    <div class="modal-box">
        <h2 id="modalTitle">Bayar Denda</h2>
        <form id="formBayar" action="{{ route('siswa.denda.bayar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group" style="margin-bottom: 14px;">
                <label>Total Tagihan Dibayar</label>
                <div style="padding: 12px 16px; background: #f8f9ff; border: 1px solid #e2e8f0; border-radius: 8px; color: #1e293b; font-weight: 700; font-size: 0.95rem;">
                    Rp {{ number_format(abs($unpaidFines->where('payment_status', 'unpaid')->sum('amount')), 0, ',', '.') }}
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 14px;">
                <label>Metode Pembayaran</label>
                <select name="payment_method" id="payment_method" onchange="toggleProofField()" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="diperpus">Bayar Tunai di Perpus</option>
                    <option value="digital">Bayar Digital (Transfer)</option>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 20px; display: none;" id="proof_field_container">
                <label>Bukti Transfer (Foto)</label>
                <input type="file" name="payment_proof" id="payment_proof" accept="image/*">
                <p style="font-size: 0.7rem; color: #64748b; margin-top: 4px; margin-bottom: 0;">Format: JPG, PNG, max 2MB.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel-modal" onclick="closeBayarModal()">Batal</button>
                <button type="submit" class="btn-save">Proses Pembayaran</button>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<div class="modal-overlay show" id="successModal" style="z-index: 9999;">
    <div class="modal-box" style="text-align: center; max-width: 400px; animation: modalPopBounce 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;">
        <div style="width: 70px; height: 70px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#16a34a" stroke-width="3" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 6L9 17l-5-5"/>
            </svg>
        </div>
        <h2 style="font-size: 1.25rem; margin-bottom: 12px; color: #166534; border-bottom: none; padding-bottom: 0;">Pembayaran Berhasil!</h2>
        <p style="font-size: 0.9rem; color: #475569; line-height: 1.5; margin-bottom: 24px;">
            {{ session('success') }}
        </p>
        <button type="button" onclick="document.getElementById('successModal').classList.remove('show')" style="background: #16a34a; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; width: 100%; font-size: 0.9rem; transition: background 0.2s;" onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
            Tutup
        </button>
    </div>
</div>
@endif

@endsection

@push('styles')
<style>
    /* ─── MODAL ─────────────────────────────── */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.4); z-index: 1000;
        align-items: center; justify-content: center;
        padding: 20px;
    }
    .modal-overlay.show { display: flex; }

    .modal-box {
        background: #fff; border-radius: 16px;
        width: 100%; max-width: 500px;
        max-height: 90vh; overflow-y: auto;
        padding: 28px 32px; box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        animation: modalPop 0.2s ease;
    }
    @keyframes modalPop {
        from { transform: scale(0.95); opacity: 0; }
        to   { transform: scale(1);    opacity: 1; }
    }
    @keyframes modalPopBounce {
        0% { transform: scale(0.8); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    .modal-box h2 {
        font-size: 1.05rem; font-weight: 700;
        color: #222; margin: 0 0 24px; padding-bottom: 14px;
        border-bottom: 1px solid #f0f0f0;
    }

    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-group label { font-size: 0.8rem; font-weight: 600; color: #333; }
    .form-group input, .form-group select {
        padding: 9px 13px; border: 1px solid #ddd; border-radius: 8px;
        font-size: 0.85rem; font-family: inherit; outline: none;
        transition: border 0.2s; background: #fff;
    }
    .form-group input:focus, .form-group select:focus { border-color: #4361ee; }

    .modal-footer {
        display: flex; justify-content: flex-end; gap: 10px;
        margin-top: 22px; padding-top: 18px; border-top: 1px solid #f0f0f0;
    }
    .btn-cancel-modal {
        padding: 9px 22px; border-radius: 8px; border: 1px solid #ddd;
        background: #fff; color: #555; font-size: 0.85rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all 0.15s;
    }
    .btn-cancel-modal:hover { background: #f5f5f5; }
    .btn-save {
        padding: 9px 22px; border-radius: 8px; border: none;
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        color: #fff; font-size: 0.85rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all 0.2s;
    }
    .btn-save:hover { opacity: 0.9; }
</style>
@endpush

@push('scripts')
<script>
    function openBayarModal() {
        document.getElementById('bayarModal').classList.add('show');
    }
    function closeBayarModal() {
        document.getElementById('bayarModal').classList.remove('show');
    }
    document.getElementById('bayarModal').addEventListener('click', function (e) {
        if (e.target === this) closeBayarModal();
    });
    
    function toggleProofField() {
        var method = document.getElementById('payment_method').value;
        var proofContainer = document.getElementById('proof_field_container');
        var proofInput = document.getElementById('payment_proof');
        if (method === 'digital') {
            proofContainer.style.display = 'flex';
            proofInput.required = true;
        } else {
            proofContainer.style.display = 'none';
            proofInput.required = false;
        }
    }
</script>
@endpush
