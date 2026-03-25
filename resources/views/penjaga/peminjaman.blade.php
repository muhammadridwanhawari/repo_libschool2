@extends('layouts.penjaga')

@section('title', 'Peminjaman - Penjaga')

@section('content')
<div>

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-[1.35rem] font-bold text-sky-950">Manajemen Peminjaman</h1>
        <p class="text-slate-500 text-[0.875rem] mt-1">Input kode booking siswa untuk memproses peminjaman.</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-5 text-[0.85rem] flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-5 text-[0.85rem] flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('error') }}
    </div>
    @endif

@push('styles')
<style>
    /* Stat Cards (Laporan Admin Style) */
    .stat-cards {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 16px; margin-bottom: 24px;
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
    .stat-card-value.warning { color: #f59e0b; }
    .stat-card-value.purple { color: #8b5cf6; }
    .stat-card-icon {
        width: 44px; height: 44px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; flex-shrink: 0;
    }
    .stat-card:nth-child(1) .stat-card-icon { background: #eef0ff; color: #4361ee; }
    .stat-card:nth-child(2) .stat-card-icon { background: #fef3c7; color: #f59e0b; }
    .stat-card:nth-child(3) .stat-card-icon { background: #ede9fe; color: #8b5cf6; }

    /* Pagination */
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

    {{-- Statistik --}}
    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Total Buku</p>
                <p class="stat-card-value">{{ $totalBuku }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Aktif</p>
                <p class="stat-card-value warning">{{ $sedangDipinjam }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
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

    {{-- Input Kode Booking --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] p-6 mb-6">
        <p class="text-[0.95rem] font-bold text-sky-950 mb-1">Input Kode Booking</p>
        <p class="text-[0.8rem] text-slate-400 mb-4">Masukkan kode booking dari siswa untuk memproses peminjaman.</p>

        {{-- Search Kode Booking --}}
        <div class="flex gap-3 mb-5">
            <input
                type="text"
                id="inputKodeBooking"
                placeholder="Contoh: BK-20260310-AB1C"
                class="flex-1 border border-slate-200 rounded-xl px-4 py-3 text-[0.88rem] font-mono font-semibold uppercase tracking-wider outline-none focus:border-sky-400 focus:ring-2 focus:ring-sky-100 transition-all"
                style="letter-spacing: 0.08em;"
                oninput="this.value = this.value.toUpperCase()"
            >
            <button
                onclick="cariBooking()"
                class="text-white font-semibold rounded-xl px-6 py-3 text-[0.88rem] transition-colors flex items-center gap-2"
                style="background:#4361ee;"
                onmouseover="this.style.background='#3a56d4'" onmouseout="this.style.background='#4361ee'"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                Cari
            </button>
        </div>

        {{-- Preview Hasil Pencarian --}}
        <div id="previewBooking" class="hidden">
            <div class="bg-sky-50 border border-sky-100 rounded-xl p-4">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#0ea5e9" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[0.7rem] font-bold text-sky-600 bg-sky-100 rounded-md px-2 py-0.5 font-mono" id="previewCode">—</span>
                            <span class="text-[0.7rem] text-slate-400">Kode Booking</span>
                        </div>
                        <p class="text-[0.95rem] font-bold text-sky-950 mb-0.5" id="previewBook">—</p>
                        <p class="text-[0.78rem] text-slate-400" id="previewAuthor">—</p>
                        <div class="mt-2 pt-2 border-t border-sky-100">
                            <p class="text-[0.78rem] text-slate-500">Siswa: <span class="font-semibold text-sky-950" id="previewStudent">—</span></p>
                            <p class="text-[0.75rem] text-slate-400 mt-0.5" id="previewEmail">—</p>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('penjaga.peminjaman.konfirmasi') }}" class="mt-4">
                    @csrf
                    <input type="hidden" name="borrowing_id" id="previewBorrowingId">
                    <button type="submit"
                        class="w-full text-white font-semibold rounded-xl py-3 text-[0.9rem] transition-colors flex items-center justify-center gap-2"
                        style="background:#4361ee;" onmouseover="this.style.background='#3a56d4'" onmouseout="this.style.background='#4361ee'"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span id="labelKonfirmasiPinjam">Konfirmasi Pinjam (Deadline +7 Hari)</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Error State --}}
        <div id="previewError" class="hidden bg-red-50 border border-red-100 rounded-xl p-4 text-[0.85rem] text-red-600 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span id="previewErrorMsg">Kode tidak ditemukan.</span>
        </div>
    </div>

    {{-- Tabel Peminjaman Aktif --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-bold text-slate-800 text-[1rem]">Daftar Peminjaman Aktif</h2>
            <span class="text-[0.75rem] text-slate-400 font-medium">{{ $peminjaman->total() }} data</span>
        </div>
        <p class="px-6 pt-3 pb-1 text-[0.78rem] text-slate-400">Booking & sedang dipinjam</p>

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
                    @forelse ($peminjaman as $p)
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
                                    <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[150px]">
                                        {{ $p->book->title ?? '-' }}
                                    </p>
                                    <p class="text-[0.7rem] text-slate-400 truncate max-w-[150px]">
                                        {{ $p->book->author ?? '' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        {{-- Siswa --}}
                        <td class="px-5 py-3.5 align-middle">
                            <p class="font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[150px]">
                                {{ $p->user->name ?? '-' }}
                            </p>
                            <p class="text-[0.7rem] text-slate-400 truncate max-w-[150px]">
                                {{ $p->user->email ?? '' }}
                            </p>
                        </td>
                        {{-- Tgl Pinjam --}}
                        <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                            {{ $p->borrow_date ? $p->borrow_date->format('d M Y') : '—' }}
                        </td>
                        {{-- Deadline --}}
                        <td class="px-5 py-3.5 text-slate-500 text-[0.78rem] align-middle">
                            @if($p->deadline)
                                <span class="{{ $isLate ? 'text-red-500 font-semibold' : '' }}">
                                    {{ $p->deadline->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                        {{-- Status --}}
                        <td class="px-5 py-3.5 align-middle">
                            @if($p->status === 'booking')
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#dbeafe] text-[#1d4ed8]">BOOKING</span>
                            @elseif($isLate)
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fee2e2] text-[#dc2626]">TERLAMBAT</span>
                            @elseif($isDeadline)
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#ffedd5] text-[#ea580c]">DEADLINE</span>
                            @elseif($p->status === 'dipinjam')
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide bg-[#fef9c3] text-[#a16207]">AKTIF</span>
                            @endif
                        </td>
                        {{-- Aksi --}}
                        <td class="px-5 py-3.5 text-center align-middle">
                            @if($p->status === 'dipinjam')
                                <span class="text-slate-300 text-[0.8rem]">—</span>
                            @else
                                <button
                                    onclick="isiKodeBooking('{{ $p->booking_code }}')"
                                    class="text-white text-[0.75rem] font-semibold rounded-lg px-3 py-1.5 transition-colors"
                                    style="background:#4361ee;" onmouseover="this.style.background='#3a56d4'" onmouseout="this.style.background='#4361ee'"
                                >Proses</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                </svg>
                                <p class="text-slate-400 text-[0.85rem]">Tidak ada peminjaman aktif saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($peminjaman->hasPages())
        <div class="pagination-wrap">
            {{ $peminjaman->links() }}
        </div>
        @endif
    </div>

</div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

function cariBooking() {
    const kode = document.getElementById('inputKodeBooking').value.trim().toUpperCase();
    if (!kode) return;

    document.getElementById('previewBooking').classList.add('hidden');
    document.getElementById('previewError').classList.add('hidden');

    fetch('{{ route("penjaga.peminjaman.cari") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': CSRF,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ booking_code: kode })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('previewCode').textContent    = data.booking_code;
            document.getElementById('previewBook').textContent    = data.book_title;
            document.getElementById('previewAuthor').textContent  = data.book_author;
            document.getElementById('previewStudent').textContent = data.student_name;
            document.getElementById('previewEmail').textContent   = data.student_email;
            document.getElementById('previewBorrowingId').value   = data.id;
            document.getElementById('labelKonfirmasiPinjam').textContent = `Konfirmasi Pinjam (Deadline +${data.duration || 7} Hari)`;
            document.getElementById('previewBooking').classList.remove('hidden');
        } else {
            document.getElementById('previewErrorMsg').textContent = data.message;
            document.getElementById('previewError').classList.remove('hidden');
        }
    })
    .catch(() => {
        document.getElementById('previewErrorMsg').textContent = 'Terjadi kesalahan. Coba lagi.';
        document.getElementById('previewError').classList.remove('hidden');
    });
}

function isiKodeBooking(kode) {
    document.getElementById('inputKodeBooking').value = kode;
    cariBooking();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Enter key support
document.getElementById('inputKodeBooking').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') cariBooking();
});
</script>
@endsection
