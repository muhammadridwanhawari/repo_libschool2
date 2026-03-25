@extends('layouts.siswa')

@section('title', 'Transaksi')

@section('content')
<div>

@push('styles')
<style>
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

    /* Total / Blue */
    .pj-stat-blue { background: #eff6ff; border-color: #bfdbfe; }
    .pj-stat-blue .pj-stat-label { color: #2563eb; }
    .pj-stat-blue .pj-stat-value { color: #1e40af; }
    .pj-stat-blue .pj-stat-icon  { background: #dbeafe; color: #2563eb; }

    /* Warning / Orange */
    .pj-stat-orange { background: #fff7ed; border-color: #fed7aa; }
    .pj-stat-orange .pj-stat-label  { color: #c2410c; }
    .pj-stat-orange .pj-stat-value  { color: #9a3412; }
    .pj-stat-orange .pj-stat-icon   { background: #fed7aa; color: #c2410c; }

    /* Warning / Yellow */
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

<div>

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-[1.35rem] font-bold text-indigo-950">Pinjaman Saya</h1>
        <p class="text-slate-500 text-[0.875rem] mt-1">Rekap status peminjaman</p>
    </div>

    {{-- ── 4 Stat Cards ─────────────────── --}}
    <div class="pj-stats">

        {{-- Dipinjam --}}
        <div class="pj-stat pj-stat-wait">
            <div>
                <p class="pj-stat-label">Sedang Dipinjam</p>
                <p class="pj-stat-value">{{ $totalActive }}</p>
            </div>
            <div class="pj-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>

        {{-- Segera Dikembalikan --}}
        <div class="pj-stat pj-stat-orange">
            <div>
                <p class="pj-stat-label">Segera Dikembalikan</p>
                <p class="pj-stat-value">{{ $totalSegeraKembali }}</p>
            </div>
            <div class="pj-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>

        {{-- Selesai --}}
        <div class="pj-stat pj-stat-ok">
            <div>
                <p class="pj-stat-label">Selesai Dibaca</p>
                <p class="pj-stat-value">{{ $totalSelesai }}</p>
            </div>
            <div class="pj-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        {{-- Total Denda --}}
        <div class="pj-stat {{ $totalDenda > 0 ? 'pj-stat-no' : 'pj-stat-total' }}">
            <div>
                <p class="pj-stat-label">Denda Tertunggak</p>
                <p class="pj-stat-value" style="font-size: 1.4rem; padding-top: 5px;">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
            </div>
            <div class="pj-stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

    </div>

    {{-- Keterangan Status --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6">
        <h3 class="text-[0.95rem] font-bold text-slate-800 mb-4">Keterangan Status</h3>
        <div class="flex flex-wrap gap-4">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 text-white rounded-lg text-[0.75rem] font-bold w-fit" style="background: linear-gradient(to right, #3b82f6, #2563eb); box-shadow: 0 2px 10px rgba(59,130,246,0.3);">
                <span class="w-1.5 h-1.5 rounded-full bg-white opacity-80"></span>
                BOOKING <span class="font-medium text-blue-50">— Menunggu pengambilan di perpustakaan</span>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-yellow-50 text-yellow-600 rounded-lg text-[0.75rem] font-bold w-fit">
                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                AKTIF <span class="font-medium">— Sedang dipinjam, belum jatuh tempo</span>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-orange-50 text-orange-600 rounded-lg text-[0.75rem] font-bold w-fit">
                <span class="w-1.5 h-1.5 rounded-full bg-orange-400"></span>
                DEADLINE <span class="font-medium">— Mendekati batas waktu pengembalian</span>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-50 text-red-700 rounded-lg text-[0.75rem] font-bold w-fit">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                TERLAMBAT <span class="font-medium">— Melewati batas waktu pengembalian</span>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] overflow-hidden">
        {{-- Header --}}
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-bold text-slate-800 text-[1rem]">Daftar Peminjaman Aktif</h2>
            <span class="text-[0.75rem] text-slate-400 font-medium">{{ $transactions->total() }} data</span>
        </div>
        <p class="px-6 pt-3 pb-1 text-[0.78rem] text-slate-400">Buku yang sedang Anda pinjam atau dalam proses pemesanan</p>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[700px]">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">BUKU</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">KODE BOOKING</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">TGL PINJAM</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">TGL KEMBALI</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($transactions as $t)
                    @php
                        $isLate = false;
                        $isDeadline = false;
                        
                        if ($t->status === 'dipinjam' && $t->deadline) {
                            $deadlineDate = \Carbon\Carbon::parse($t->deadline)->startOfDay();
                            $today = now()->startOfDay();
                            $diff = $today->diffInDays($deadlineDate, false);
                            
                            if ($diff < 0) {
                                $isLate = true;
                            } elseif ($diff >= 0 && $diff <= 1) {
                                $isDeadline = true;
                            }
                        }
                    @endphp
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        {{-- Buku --}}
                        <td class="px-5 py-3.5 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-11 rounded bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200 flex items-center justify-center">
                                    @if($t->book && $t->book->cover)
                                        <img src="{{ asset('storage/' . $t->book->cover) }}" alt="Cover" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[160px]">
                                        {{ $t->book->title ?? '-' }}
                                    </p>
                                    <p class="text-[0.7rem] text-slate-400 truncate max-w-[160px]">
                                        {{ $t->book->author ?? '' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        {{-- Booking Code --}}
                        <td class="px-5 py-3.5 align-middle">
                            @if($t->booking_code)
                            <div class="flex items-center gap-1.5">
                                <span class="font-mono text-[0.75rem] text-slate-500 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                    {{ $t->booking_code }}
                                </span>
                                <button
                                    type="button"
                                    onclick="copyBookingCode(this, '{{ $t->booking_code }}')"
                                    title="Salin kode"
                                    class="copy-btn flex items-center justify-center w-6 h-6 rounded bg-transparent hover:bg-slate-100 transition-colors text-slate-400 hover:text-slate-600 flex-shrink-0"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                                        <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/>
                                    </svg>
                                </button>
                            </div>
                            @else
                            <span class="text-slate-400 text-[0.8rem]">—</span>
                            @endif
                        </td>
                        {{-- Tgl Pinjam --}}
                        <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                            {{ $t->borrow_date ? $t->borrow_date->format('d M Y') : '—' }}
                        </td>
                        {{-- Tgl Kembali --}}
                        <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                            {{ $t->return_date ? $t->return_date->format('d M Y') : ($t->deadline ? $t->deadline->format('d M Y') : '—') }}
                        </td>
                        {{-- Status --}}
                        <td class="px-5 py-3.5 align-middle">
                            @if($t->status === 'booking')
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#dbeafe] text-[#1d4ed8]">BOOKING</span>
                            @elseif($isLate)
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fee2e2] text-[#dc2626]">TERLAMBAT</span>
                            @elseif($isDeadline)
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#ffedd5] text-[#ea580c]">DEADLINE</span>
                            @elseif($t->status === 'dipinjam')
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fef9c3] text-[#a16207]">AKTIF</span>
                            @elseif($t->status === 'dikembalikan')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#dcfce7] text-[#16a34a]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#16a34a] inline-block"></span>Dikembalikan
                                </span>
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
                                <p class="text-slate-400 text-[0.85rem]">Belum ada transaksi peminjaman aktif.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
function copyBookingCode(btn, code) {
    navigator.clipboard.writeText(code).then(() => {
        const original = btn.innerHTML;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" stroke="#22c55e" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
        btn.style.color = '#22c55e';
        setTimeout(() => {
            btn.innerHTML = original;
            btn.style.color = '';
        }, 1500);
    }).catch(() => {
        // fallback for older browsers
        const el = document.createElement('textarea');
        el.value = code;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
    });
}
</script>
@endpush
