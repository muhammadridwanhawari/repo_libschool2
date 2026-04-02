@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.penjaga')

@section('title', 'Peminjaman')

@push('styles')
<style>
    .page-header {
        margin-bottom: 20px;
        display: flex; align-items: center;
        justify-content: space-between; flex-wrap: wrap; gap: 12px;
    }
    .page-header h1 { font-size: 1.4rem; font-weight: 700; color: #222; margin: 0 0 4px; }
    .page-header p { font-size: 0.82rem; color: #4361ee; margin: 0; }

    .content-panel {
        background: #fff; border-radius: 14px;
        border: 1px solid #eee; overflow: hidden;
    }

    .search-wrap {
        display: flex; align-items: center; gap: 10px;
        background: #fff; border-radius: 10px;
        border: 1px solid #ddd; padding: 10px 16px;
        margin: 16px 16px 0;
    }
    .search-wrap svg { color: #bbb; flex-shrink: 0; }
    .search-wrap input {
        flex: 1; border: none; outline: none;
        font-size: 0.9rem; color: #555; background: transparent;
        font-family: inherit;
    }

    .pagination-wrap {
        padding: 16px; border-top: 1px solid #f0f0f0;
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

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: flex-start; }
        .page-header h1 { font-size: 1.15rem; }
    }
</style>
@endpush

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <h1>Peminjaman</h1>
        <p>Kelola data transaksi peminjaman buku</p>
    </div>

    <div class="content-panel">
        {{-- Search --}}
        <div class="px-6 pt-5 pb-3">
            <form action="{{ route('admin.peminjaman.index') }}" method="GET">
                <div class="flex items-center gap-2 border border-slate-200 rounded-xl px-4 py-2.5 bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Nama Peminjam atau Judul Buku.." class="flex-1 border-none outline-none text-[0.88rem] text-slate-600 bg-transparent font-[inherit]">
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">KODE BOOKING</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">BUKU</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">SISWA</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">TGL PINJAM</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">DEADLINE</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">STATUS</th>
                        <th class="px-5 py-3 text-center text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($borrowings as $p)
                    @php
                        $isLate = false;
                        $isDeadline = false;

                        if ($p->status === 'dipinjam' && $p->deadline) {
                            $deadlineDate = \Carbon\Carbon::parse($p->deadline)->startOfDay();
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
                        {{-- Kode Booking --}}
                        <td class="px-5 py-3.5 align-middle">
                            @if($p->booking_code)
                            <span class="font-mono text-[0.75rem] text-slate-500 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">
                                {{ $p->booking_code }}
                            </span>
                            @else
                            <span class="text-slate-400 text-[0.8rem]">—</span>
                            @endif
                        </td>
                        {{-- Buku --}}
                        <td class="px-5 py-3.5 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-11 rounded bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200 flex items-center justify-center">
                                    @if($p->book && $p->book->cover)
                                        <img src="{{ asset('storage/' . $p->book->cover) }}" alt="Cover" class="w-full h-full object-cover">
                                    @elseif($p->book && $p->book->cover_image)
                                        <img src="{{ asset('storage/' . $p->book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[150px]">{{ $p->book->title ?? '-' }}</p>
                                    <p class="text-[0.7rem] text-slate-400 truncate max-w-[150px]">{{ $p->book->author ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        {{-- Siswa --}}
                        <td class="px-5 py-3.5 align-middle">
                            <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[150px]">{{ $p->user->name ?? '-' }}</p>
                            <p class="text-[0.7rem] text-slate-400 truncate max-w-[150px]">{{ $p->user->email ?? '' }}</p>
                        </td>
                        {{-- Tgl Pinjam --}}
                        <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                            {{ $p->borrow_date ? $p->borrow_date->format('d M Y') : '—' }}
                        </td>
                        {{-- Deadline --}}
                        <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                            @if($p->deadline)
                                <span class="{{ $p->status_display === 'terlambat' ? 'text-red-500 font-semibold' : '' }}">
                                    {{ \Carbon\Carbon::parse($p->deadline)->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                        {{-- Status --}}
                        <td class="px-5 py-3.5 align-middle">
                            @if($p->status === 'booking')
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#dbeafe] text-[#1d4ed8]">BOOKING</span>
                            @elseif($isDeadline)
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#ffedd5] text-[#ea580c]">DEADLINE</span>
                            @elseif($isLate || $p->status_display === 'terlambat')
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fee2e2] text-[#dc2626]">TERLAMBAT</span>
                            @elseif($p->status === 'dipinjam')
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fef9c3] text-[#a16207]">AKTIF</span>
                            @elseif($p->status === 'dikembalikan')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#dcfce7] text-[#16a34a]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#16a34a] inline-block"></span>DIKEMBALIKAN
                                </span>
                            @endif
                        </td>
                        {{-- Aksi --}}
                        <td class="px-5 py-3.5 text-center align-middle">
                            <a href="{{ route('admin.peminjaman.show', $p->id) }}"
                               class="text-slate-600 text-[0.75rem] font-semibold rounded-lg px-3 py-1.5 border border-slate-200 bg-white hover:bg-slate-50 transition-colors inline-flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                <p class="text-slate-400 text-[0.85rem]">Belum ada data peminjaman.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($borrowings->hasPages())
        <div class="pagination-wrap">
            {{ $borrowings->appends(['search' => $search])->links() }}
        </div>
        @endif
    </div>
@endsection
