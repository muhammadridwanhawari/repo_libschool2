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

    {{-- Statistik --}}
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl p-5 shadow-[0_1px_6px_rgba(0,0,0,0.06)]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#0ea5e9" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                </div>
                <div>
                    <p class="text-[0.72rem] text-slate-400 font-medium">Total Buku</p>
                    <p class="text-2xl font-bold text-sky-950">{{ $totalBuku }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-[0_1px_6px_rgba(0,0,0,0.06)]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-yellow-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#ca8a04" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-[0.72rem] text-slate-400 font-medium">Sedang Dipinjam</p>
                    <p class="text-2xl font-bold text-sky-950">{{ $sedangDipinjam }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-[0_1px_6px_rgba(0,0,0,0.06)]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                </div>
                <div>
                    <p class="text-[0.72rem] text-slate-400 font-medium">Menunggu Konfirmasi</p>
                    <p class="text-2xl font-bold text-sky-950">{{ $menungguBooking }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-[0_1px_6px_rgba(0,0,0,0.06)]">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
                </div>
                <div>
                    <p class="text-[0.72rem] text-slate-400 font-medium">Terlambat</p>
                    <p class="text-2xl font-bold text-sky-950">{{ $belumKembali }}</p>
                </div>
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
                class="bg-sky-500 hover:bg-sky-600 text-white font-semibold rounded-xl px-6 py-3 text-[0.88rem] transition-colors flex items-center gap-2"
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
                        class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold rounded-xl py-3 text-[0.9rem] transition-colors flex items-center justify-center gap-2"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Konfirmasi Pinjam (Deadline +7 Hari)
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
        <div class="px-6 py-4 border-b border-slate-100">
            <p class="text-[0.95rem] font-bold text-sky-950">Daftar Peminjaman Aktif</p>
            <p class="text-[0.78rem] text-slate-400 mt-0.5">Booking & sedang dipinjam</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-[0.82rem]">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Kode Booking</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Buku</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Siswa</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Tgl Pinjam</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Deadline</th>
                        <th class="text-left px-5 py-3 font-semibold text-slate-500">Status</th>
                        <th class="text-center px-5 py-3 font-semibold text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($peminjaman as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-5 py-3.5">
                            <span class="font-mono font-semibold text-sky-600 bg-sky-50 rounded-md px-2 py-0.5 text-[0.78rem]">
                                {{ $p->booking_code ?? '—' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="font-semibold text-slate-700 leading-tight">{{ Str::limit($p->book->title, 30) }}</p>
                            <p class="text-slate-400 text-[0.75rem]">{{ $p->book->author }}</p>
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="font-medium text-slate-700">{{ $p->user->name }}</p>
                            <p class="text-slate-400 text-[0.75rem]">{{ $p->user->email }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-slate-500">
                            {{ $p->borrow_date ? $p->borrow_date->format('d M Y') : '—' }}
                        </td>
                        <td class="px-5 py-3.5 text-slate-500">
                            @if($p->deadline)
                                <span class="{{ $p->status === 'dipinjam' && now()->gt($p->deadline) ? 'text-red-500 font-semibold' : '' }}">
                                    {{ $p->deadline->format('d M Y') }}
                                </span>
                            @else
                                <span class="text-slate-300">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            @if($p->status === 'booking')
                                <span class="bg-violet-50 text-violet-600 border border-violet-100 rounded-full px-2.5 py-0.5 text-[0.72rem] font-semibold">Booking</span>
                            @elseif($p->status === 'dipinjam' && $p->deadline && now()->gt($p->deadline))
                                <span class="bg-red-50 text-red-600 border border-red-100 rounded-full px-2.5 py-0.5 text-[0.72rem] font-semibold">Terlambat</span>
                            @else
                                <span class="bg-yellow-50 text-yellow-600 border border-yellow-100 rounded-full px-2.5 py-0.5 text-[0.72rem] font-semibold">Dipinjam</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @if($p->status === 'dipinjam')
                                <span class="text-slate-300">—</span>
                            @else
                            <button
                                onclick="isiKodeBooking('{{ $p->booking_code }}')"
                                class="bg-sky-500 hover:bg-sky-600 text-white text-[0.75rem] font-semibold rounded-lg px-3 py-1.5 transition-colors"
                            >Proses</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-slate-400 text-[0.85rem]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mx-auto mb-2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                            Tidak ada peminjaman aktif saat ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($peminjaman->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
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
