@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.penjaga')

@section('title', 'Denda')

@push('styles')
<style>
    .page-header { margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
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

    .denda-table { width: 100%; border-collapse: collapse; }
    .denda-table th {
        text-align: left; font-size: 0.72rem;
        font-weight: 700; color: #888;
        text-transform: uppercase; padding: 14px 16px;
        border-bottom: 1px solid #f0f0f0;
        background: #fafafa;
    }
    .denda-table td {
        padding: 12px 16px; font-size: 0.85rem;
        color: #444; border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .denda-table tr:last-child td { border-bottom: none; }
    .denda-table tr:hover td { background: #fff5f5; }

    .name-main { font-weight: 600; color: #222; }

    .badge {
        display: inline-block; padding: 4px 14px;
        border-radius: 20px; font-size: 0.72rem;
        font-weight: 700;
    }
    .badge-danger { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }

    .btn-detail {
        border: 1px solid #ddd; background: #fff; color: #444;
        border-radius: 6px; padding: 5px 14px;
        font-size: 0.78rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        text-decoration: none; display: inline-block;
        transition: background 0.15s;
    }
    .btn-detail:hover { background: #f5f5f5; color: #222; }

    .btn-selesaikan {
        border: none; background: linear-gradient(135deg, #16a34a, #15803d); color: #fff;
        border-radius: 6px; padding: 5px 14px;
        font-size: 0.78rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        text-decoration: none; display: inline-block;
        transition: opacity 0.15s;
    }
    .btn-selesaikan:hover { opacity: 0.85; color: #fff; }

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
</style>
@endpush

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>Denda</h1>
            <p>Kelola data keterlambatan dan pembayaran denda</p>
        </div>
        <form action="{{ route('admin.denda.index') }}" method="GET" style="margin: 0; display: flex; gap: 8px;">
            <input type="hidden" name="search" value="{{ $search ?? '' }}">
            <input type="month" name="month" value="{{ $month ?? '' }}" 
                style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.85rem; outline: none; color: #555; background: #fff;">
            <button type="submit" style="background: linear-gradient(135deg, #4361ee, #3a56d4); color: #fff; border: none; padding: 6px 16px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                Filter
            </button>
            @if(request('month'))
                <a href="{{ route('admin.denda.index', ['search' => request('search')]) }}" style="background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; padding: 6px 12px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; display: flex; align-items: center;">Reset</a>
            @endif
        </form>
    </div>

    {{-- Total Pendapatan Denda --}}
    <div style="background: #fff; border: 1px solid #eee; border-radius: 14px; padding: 20px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
        <div>
            <h3 style="font-size: 0.9rem; color: #666; font-weight: 600; margin: 0 0 5px 0;">Total Denda Terkumpul (Lunas)</h3>
            <div style="font-size: 1.5rem; font-weight: 700; color: #16a34a;">Rp {{ number_format(abs($totalDendaDibayar), 0, ',', '.') }}</div>
        </div>
        <div style="background: #dcfce7; color: #16a34a; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v20m5-17H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
            </svg>
        </div>
    </div>

    @if(session('success'))
    <div style="background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-size:0.85rem; display:flex; align-items:center; gap:8px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="background:#fef2f2; border:1px solid #fecaca; color:#b91c1c; padding:12px 16px; border-radius:10px; margin-bottom:16px; font-size:0.85rem; display:flex; align-items:center; gap:8px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="content-panel">
        {{-- Pembayaran Pending --}}
        @if($pendingPayments->isNotEmpty())
        <div style="padding: 16px; background: #fffaf0; border-bottom: 1px solid #feebd0;">
            <h3 style="font-size: 1rem; font-weight: 700; color: #b45309; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                Verifikasi Pembayaran Denda
            </h3>
            <table class="denda-table" style="background: transparent;">
                <thead>
                    <tr>
                        <th>KODE BAYAR</th>
                        <th>NAMA PEMINJAM</th>
                        <th>TOTAL (Rp)</th>
                        <th>METODE</th>
                        <th>BUKTI</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingPayments as $code => $finesGroup)
                    @php
                        $firstFine = $finesGroup->first();
                        $borrowingUser = $firstFine->borrowing->user->name ?? '-';
                        $totalAmount = $finesGroup->sum('amount');
                    @endphp
                    <tr>
                        <td style="font-weight: 600; color: #b45309;">{{ $code }}</td>
                        <td>{{ $borrowingUser }}</td>
                        <td style="font-weight: 700;">{{ number_format(abs($totalAmount), 0, ',', '.') }}</td>
                        <td style="text-transform: capitalize;">{{ $firstFine->payment_method == 'diperpus' ? 'Tunai di Perpus' : 'Digital (Transfer)' }}</td>
                        <td>
                            @if($firstFine->payment_method == 'digital' && $firstFine->payment_proof)
                            <a href="{{ asset('storage/' . $firstFine->payment_proof) }}" target="_blank" style="color: #4361ee; font-size: 0.8rem; text-decoration: underline;">Lihat Bukti</a>
                            @else
                            <span style="color:#aaa; font-size:0.8rem;">-</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.denda.verifikasi', $code) }}" method="POST" style="margin: 0;" onsubmit="confirmAction(event, 'Verifikasi pembayaran ini?', 'Ya, Verifikasi', 'Konfirmasi Verifikasi', false); return false;">
                                @csrf
                                <button type="submit" style="background: #16a34a; color: white; border: none; padding: 5px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; cursor: pointer;">
                                    Verifikasi
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        {{-- Search --}}
        <div class="px-6 pt-5 pb-2 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-slate-800 text-[1rem]">Daftar Keterlambatan</h2>
                <p class="text-[0.78rem] text-slate-400 mt-0.5">{{ $dendaList->total() }} data terlambat</p>
            </div>
        </div>
        <div class="px-6 pb-3">
            <form action="{{ route('admin.denda.index') }}" method="GET">
                <div class="flex items-center gap-2 border border-slate-200 rounded-xl px-4 py-2.5 bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Nama Peminjam atau Judul Buku.." class="flex-1 border-none outline-none text-[0.88rem] text-slate-600 bg-transparent font-[inherit]">
                </div>
            </form>
        </div>

        {{-- Table Keterlambatan --}}
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
                    @forelse ($dendaList as $p)
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
                                        <svg class="w-5 h-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[160px]">{{ $p->book->title ?? '-' }}</p>
                                    <p class="text-[0.7rem] text-slate-400 truncate max-w-[160px]">{{ $p->book->author ?? '' }}</p>
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
                        <td class="px-5 py-3.5 text-[0.78rem] align-middle">
                            <span class="text-red-500 font-semibold">{{ $p->deadline ? $p->deadline->format('d M Y') : '—' }}</span>
                        </td>
                        {{-- Status --}}
                        <td class="px-5 py-3.5 align-middle">
                            <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fee2e2] text-[#dc2626]">TERLAMBAT</span>
                        </td>
                        {{-- Aksi --}}
                        <td class="px-5 py-3.5 text-center align-middle">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.denda.show', $p->id) }}"
                                   class="text-slate-600 text-[0.75rem] font-semibold rounded-lg px-3 py-1.5 border border-slate-200 bg-white hover:bg-slate-50 transition-colors inline-flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </a>
                                <form action="{{ route('admin.denda.kembalikan', $p->id) }}" method="POST" style="margin:0;" data-name="{{ $p->user->name ?? '' }}"
                                      onsubmit="confirmAction(event, 'Terima buku dan selesaikan denda untuk ' + this.dataset.name + '?', 'Ya, Selesaikan', 'Konfirmasi Denda', false); return false;">
                                    @csrf
                                    <button type="submit"
                                        class="text-white text-[0.75rem] font-semibold rounded-lg px-3 py-1.5 transition-colors inline-flex items-center gap-1"
                                        style="background:#16a34a;" onmouseover="this.style.background='#15803d'" onmouseout="this.style.background='#16a34a'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        Selesaikan Denda
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                <p class="text-slate-400 text-[0.85rem]">Tidak ada denda saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($dendaList->hasPages())
        <div class="pagination-wrap">
            {{ $dendaList->appends(['search' => $search, 'month' => $month, 'riwayat_page' => request('riwayat_page'), 'unpaid_page' => request('unpaid_page')])->links() }}
        </div>
        @endif
    </div>

    {{-- Daftar Denda Belum Dibayar Panel --}}
    <div class="content-panel" style="margin-top: 20px;">
        <div class="px-6 pt-5 pb-2 flex items-center justify-between border-b border-slate-100 mb-3">
            <div>
                <h2 class="font-bold text-slate-800 text-[1rem]">Denda Belum Dibayar</h2>
                <p class="text-[0.78rem] text-slate-400 mt-0.5">{{ $unpaidFines->total() }} data denda belum lunas</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">SISWA</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">BUKU TERKAIT</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">TOTAL DENDA (Rp)</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">TANGGAL KEMBALI</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">STATUS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($unpaidFines as $ub)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-5 py-3.5 align-middle">
                            <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight">{{ $ub->borrowing->user->name ?? '-' }}</p>
                            <p class="text-[0.7rem] text-slate-400">{{ $ub->borrowing->user->email ?? '' }}</p>
                        </td>
                        <td class="px-5 py-3.5 align-middle">
                            <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[200px]">{{ $ub->borrowing->book->title ?? '-' }}</p>
                        </td>
                        <td class="px-5 py-3.5 align-middle">
                            <span class="font-bold text-slate-800 text-[0.85rem] text-red-600">Rp {{ number_format(abs($ub->amount), 0, ',', '.') }}</span>
                        </td>
                        <td class="px-5 py-3.5 align-middle text-[0.78rem] text-slate-500">
                            {{ $ub->borrowing->return_date ? \Carbon\Carbon::parse($ub->borrowing->return_date)->format('d M Y') : '—' }}
                        </td>
                        <td class="px-5 py-3.5 align-middle">
                            <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fee2e2] text-[#dc2626] uppercase">Belum Lunas</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                <p class="text-slate-400 text-[0.85rem]">Tidak ada tagihan denda belum dibayar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($unpaidFines->hasPages())
        <div class="pagination-wrap">
            {{ $unpaidFines->appends(['search' => $search, 'month' => $month, 'riwayat_page' => request('riwayat_page'), 'page' => request('page')])->links() }}
        </div>
        @endif
    </div>

    {{-- Riwayat Denda Panel --}}
    <div class="content-panel" style="margin-top: 20px;">
        {{-- History Table --}}
        <div class="px-6 pt-5 pb-2 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-slate-800 text-[1rem]">Riwayat Denda</h2>
                <p class="text-[0.78rem] text-slate-400 mt-0.5">{{ $riwayatDenda->total() }} total catatan denda</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">BUKU</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">SISWA</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">TOTAL DENDA (Rp)</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">STATUS</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-slate-500 border-b border-slate-100">METODE / TGL BAYAR</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($riwayatDenda as $r)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        {{-- Buku --}}
                        <td class="px-5 py-3.5 align-middle">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-11 rounded bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200 flex items-center justify-center">
                                    @if($r->borrowing->book && $r->borrowing->book->cover)
                                        <img src="{{ asset('storage/' . $r->borrowing->book->cover) }}" alt="Cover" class="w-full h-full object-cover">
                                    @elseif($r->borrowing->book && $r->borrowing->book->cover_image)
                                        <img src="{{ asset('storage/' . $r->borrowing->book->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[160px]">{{ $r->borrowing->book->title ?? '-' }}</p>
                                    <p class="text-[0.7rem] text-slate-400 truncate max-w-[160px]">{{ $r->borrowing->book->author ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        {{-- Siswa --}}
                        <td class="px-5 py-3.5 align-middle">
                            <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[150px]">{{ $r->borrowing->user->name ?? '-' }}</p>
                            <p class="text-[0.7rem] text-slate-400 truncate max-w-[150px]">{{ $r->borrowing->user->email ?? '' }}</p>
                        </td>
                        {{-- Total Denda --}}
                        <td class="px-5 py-3.5 align-middle">
                            <span class="font-bold text-slate-800 text-[0.85rem]">Rp {{ number_format(abs($r->amount), 0, ',', '.') }}</span>
                        </td>
                        {{-- Status --}}
                        <td class="px-5 py-3.5 align-middle">
                            @if($r->paid)
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#dcfce7] text-[#16a34a]">LUNAS</span>
                            @else
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fee2e2] text-[#dc2626]">BELUM LUNAS</span>
                            @endif
                        </td>
                        {{-- Metode / Tgl Bayar --}}
                        <td class="px-5 py-3.5 align-middle">
                            @if($r->paid)
                                <p class="text-[0.8rem] text-slate-600 font-medium capitalize">
                                    {{ $r->payment_method == 'diperpus' ? 'Tunai di Perpus' : ($r->payment_method == 'digital' ? 'Digital (Transfer)' : '-') }}
                                </p>
                                <p class="text-[0.72rem] text-slate-400">{{ $r->updated_at->format('d M Y, H:i') }}</p>
                            @else
                                <span class="text-slate-300 text-[0.8rem]">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                <p class="text-slate-400 text-[0.85rem]">Tidak ada riwayat denda.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($riwayatDenda->hasPages())
        <div class="pagination-wrap">
            {{ $riwayatDenda->appends(['search' => $search, 'month' => $month, 'page' => request('page')])->links() }}
        </div>
        @endif
    </div>
@endsection
