@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.penjaga')

@section('title', 'Laporan')

@push('styles')
<style>
    .page-header { margin-bottom: 20px; }
    .page-header h1 { font-size: 1.4rem; font-weight: 700; color: #222; margin: 0 0 4px; }
    .page-header p { font-size: 0.82rem; color: #4361ee; margin: 0; }

    /* Search / Filter Box */
    .filter-box {
        background: #f8f9fb; border-radius: 14px;
        padding: 20px 24px; margin-bottom: 20px;
        border: 1px solid #eee;
    }
    .filter-box h2 { font-size: 1rem; font-weight: 700; color: #222; margin: 0 0 12px; }
    .filter-label { font-size: 0.78rem; color: #666; margin-bottom: 8px; }
    .filter-row {
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    }
    .date-input-wrap {
        display: flex; align-items: center; gap: 8px;
        background: #fff; border-radius: 8px; border: 1px solid #ddd;
        padding: 8px 14px; min-width: 180px;
    }
    .date-input-wrap svg { color: #4361ee; flex-shrink: 0; }
    .date-input-wrap input[type="date"] {
        border: none; outline: none; font-size: 0.85rem;
        color: #444; background: transparent; font-family: inherit;
    }
    .filter-sep {
        font-size: 0.82rem; color: #888; font-weight: 500;
    }
    .btn-filter {
        background: linear-gradient(135deg, #4361ee, #3a56d4); color: #fff; border: none;
        border-radius: 8px; padding: 9px 20px;
        font-size: 0.84rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        transition: all 0.2s;
    }
    .btn-filter:hover {
        background: linear-gradient(135deg, #3a56d4, #2f49c0);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(67,97,238,0.3);
    }

    /* Stat Cards */
    .stat-cards {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 16px; margin-bottom: 20px;
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
    .stat-card-value.warning { color: #d97706; }
    .stat-card-value.info { color: #0284c7; }
    .stat-card-icon {
        width: 44px; height: 44px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; flex-shrink: 0;
    }
    .stat-card:nth-child(1) .stat-card-icon { background: #eef0ff; color: #4361ee; }
    .stat-card:nth-child(2) .stat-card-icon { background: #fee2e2; color: #ef4444; }
    .stat-card:nth-child(3) .stat-card-icon { background: #dcfce7; color: #16a34a; }
    .stat-card:nth-child(4) .stat-card-icon { background: #e0f2fe; color: #0284c7; }

    /* Pagination */
    .pagination-wrap {
        padding: 14px 16px; border-top: 1px solid #f0f0f0;
        display: flex; align-items: center; gap: 4px;
    }
    .pagination-wrap a, .pagination-wrap span {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: 6px;
        font-size: 0.8rem; text-decoration: none;
        color: #666; border: 1px solid #e5e7eb;
    }
    .pagination-wrap .active { background: #4361ee; color: #fff; border-color: #4361ee; }
    .pagination-wrap nav p.text-sm.text-gray-700 { display: none !important; }

    /* Responsive */
    @media (max-width: 1024px) {
        .stat-cards { grid-template-columns: repeat(2, 1fr); }
        .filter-row { flex-wrap: wrap; }
        .date-input-wrap { min-width: 140px; }
    }
    @media (max-width: 640px) {
        .stat-cards { grid-template-columns: 1fr; }
        .filter-row { flex-direction: column; align-items: stretch; }
        .date-input-wrap { width: 100%; }
        .btn-filter { width: 100%; text-align: center; }
        .page-header h1 { font-size: 1.15rem; }
    }
</style>
@endpush

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <h1>Laporan Peminjaman</h1>
        <p>Rekap dan statistik seluruh transaksi peminjaman perpustakaan</p>
    </div>

    {{-- Filter Box --}}
    <div class="filter-box">
        <h2>Cari Transaksi</h2>
        <p class="filter-label">Filter Berdasarkan Tanggal</p>
        <form method="GET" action="{{ route('admin.laporan.index') }}">
            <div class="filter-row">
                <div class="date-input-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <input type="date" name="from" value="{{ $from }}">
                </div>
                <span class="filter-sep">From</span>
                <div class="date-input-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <input type="date" name="until" value="{{ $until }}">
                </div>
                <span class="filter-sep">Until</span>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
        </form>
    </div>

    {{-- Stat Cards --}}
    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Total Transaksi</p>
                <p class="stat-card-value">{{ $totalPeminjaman }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Terlambat</p>
                <p class="stat-card-value danger">{{ $statusTerlambat }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Dikembalikan</p>
                <p class="stat-card-value success">{{ $statusDikembalikan }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Masih Dipinjam</p>
                <p class="stat-card-value info">{{ $statusDipinjam }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    {{-- Preview Table --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-800 text-[1rem]">Pratinjau Laporan (Peminjaman)</h3>
                <p class="text-[0.76rem] text-slate-400 mt-0.5">{{ $from }} s/d {{ $until }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.laporan.export', ['from' => $from, 'until' => $until, 'type' => 'pdf']) }}"
                   class="inline-flex items-center gap-1.5 border border-slate-200 bg-white text-slate-600 rounded-lg px-3 py-2 text-[0.76rem] font-semibold hover:bg-slate-50 transition-colors no-underline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    PDF
                </a>
                <a href="{{ route('admin.laporan.export', ['from' => $from, 'until' => $until, 'type' => 'print']) }}"
                   class="inline-flex items-center gap-1.5 border border-slate-200 bg-white text-slate-600 rounded-lg px-3 py-2 text-[0.76rem] font-semibold hover:bg-slate-50 transition-colors no-underline" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[820px]">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">BUKU</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">PEMINJAM</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">TGL PINJAM</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">DEADLINE</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">STATUS</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">DENDA</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($borrowings as $b)
                    @php
                        $isLate = false;
                        $isDeadline = false;

                        if ($b->status === 'dipinjam' && $b->deadline) {
                            $deadlineDate = \Carbon\Carbon::parse($b->deadline)->startOfDay();
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
                                    @if($b->book && $b->book->cover)
                                        <img src="{{ asset('storage/' . $b->book->cover) }}" alt="Cover" class="w-full h-full object-cover">
                                    @elseif($b->book && $b->book->cover_image)
                                        <img src="{{ asset('storage/' . $b->book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[160px]">
                                        {{ $b->book->title ?? '-' }}
                                    </p>
                                    <p class="text-[0.7rem] text-slate-400 truncate max-w-[160px]">
                                        {{ $b->book->author ?? '' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        {{-- Peminjam --}}
                        <td class="px-5 py-3.5 align-middle">
                            <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[150px]">
                                {{ $b->user->name ?? '-' }}
                            </p>
                            <p class="text-[0.7rem] text-slate-400 truncate max-w-[150px]">
                                {{ $b->user->email ?? '' }}
                            </p>
                        </td>
                        {{-- Tgl Pinjam --}}
                        <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                            {{ $b->borrow_date ? $b->borrow_date->format('d M Y') : '—' }}
                        </td>
                        {{-- Deadline --}}
                        <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                            @if($b->deadline)
                                <span class="{{ $isLate ? 'text-red-500 font-semibold' : '' }}">
                                    {{ $b->deadline->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                        {{-- Status --}}
                        <td class="px-5 py-3.5 align-middle">
                            @if($b->status === 'booking')
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#dbeafe] text-[#1d4ed8]">BOOKING</span>
                            @elseif($isLate)
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fee2e2] text-[#dc2626]">TERLAMBAT</span>
                            @elseif($isDeadline)
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#ffedd5] text-[#ea580c]">DEADLINE</span>
                            @elseif($b->status === 'dipinjam')
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fef9c3] text-[#a16207]">AKTIF</span>
                            @elseif($b->status === 'dikembalikan')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#dcfce7] text-[#16a34a]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#16a34a] inline-block"></span>Dikembalikan
                                </span>
                            @endif
                        </td>
                        {{-- Denda --}}
                        <td class="px-5 py-3.5 align-middle">
                            @if($b->fine)
                                <span class="text-[0.82rem] font-semibold text-red-500">Rp. {{ number_format($b->fine->amount, 0, ',', '.') }}</span>
                            @else
                                <span class="text-slate-300 text-[0.82rem]">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                </svg>
                                <p class="text-slate-400 text-[0.85rem]">Tidak ada data pada rentang tanggal ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($borrowings->hasPages())
        <div class="pagination-wrap">
            {{ $borrowings->appends(['from' => $from, 'until' => $until])->links() }}
        </div>
        @endif
    </div>
@endsection
