@extends('layouts.penjaga')

@section('title', 'Inbox - Penjaga')

@push('styles')
<style>
    /* Stat Cards */
    .stat-cards {
        display: grid; grid-template-columns: repeat(2, 1fr);
        gap: 16px; margin-bottom: 28px;
    }
    .stat-card {
        background: #fff; border-radius: 14px;
        padding: 20px 24px; border: 1.5px solid #e5e7eb;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .stat-card-label { font-size: 0.8rem; color: #666; margin: 0 0 4px; font-weight: 500; }
    .stat-card-value { font-size: 2rem; font-weight: 700; color: #222; margin: 0; }
    .stat-card-value.primary { color: #4361ee; }
    .stat-card-value.warning { color: #f59e0b; }
    .stat-card-icon {
        width: 44px; height: 44px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; flex-shrink: 0;
    }
    .stat-card:nth-child(1) .stat-card-icon { background: #eef0ff; color: #4361ee; }
    .stat-card:nth-child(2) .stat-card-icon { background: #fef3c7; color: #f59e0b; }

    /* Message List */
    .msg-item {
        display: flex; align-items: flex-start; gap: 14px;
        padding: 16px 24px; border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s; text-decoration: none; color: inherit;
    }
    .msg-item:hover { background: #f8faff; }
    .msg-item.unread { background: #f5f7ff; }
    .msg-avatar {
        width: 38px; height: 38px; border-radius: 50%;
        background: #eef0ff; color: #4361ee;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-weight: 700; font-size: 0.9rem;
    }
    .msg-unread-dot {
        width: 8px; height: 8px; border-radius: 50%; background: #4361ee;
        flex-shrink: 0; margin-top: 6px;
    }
    .msg-subject { font-size: 0.88rem; font-weight: 600; color: #1e293b; margin: 0 0 2px; }
    .msg-preview { font-size: 0.77rem; color: #64748b; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 480px; }
    .msg-meta { font-size: 0.7rem; color: #94a3b8; margin-top: 3px; }
    .msg-read .msg-subject { font-weight: 500; color: #475569; }
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

    /* Modal Styles for Pengajuan */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.45); z-index: 1000;
        align-items: center; justify-content: center;
    }
    .modal-overlay.active { display: flex; }
    .modal-card {
        background: #fff; border-radius: 16px;
        width: 500px; max-width: 95vw;
        max-height: 90vh; overflow-y: auto;
    }
    .modal-header {
        padding: 24px 30px 16px; border-bottom: 1px solid #eee;
        display: flex; justify-content: space-between; align-items: center;
    }
    .modal-header h2 { font-size: 1.25rem; font-weight: 700; color: #222; margin: 0; }
    .modal-close {
        background: none; border: none; font-size: 1.5rem; color: #999;
        cursor: pointer; padding: 0; line-height: 1;
    }
    .modal-close:hover { color: #333; }
    .modal-body { padding: 24px 30px; }
    .detail-row { display: flex; margin-bottom: 16px; }
    .detail-label { width: 140px; font-weight: 600; font-size: 0.85rem; color: #555; flex-shrink: 0; }
    .detail-value { flex: 1; font-size: 0.85rem; color: #222; }
    .detail-reason { font-size: 0.85rem; color: #444; background: #f8f9fa; padding: 12px; border-radius: 8px; border: 1px solid #eee; }

    /* Status Badges untuk Pengajuan */
    .badge-menunggu { background: #fef9c3; color: #92400e; border: 1px solid #fde68a; }
    .badge-disetujui { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
    .badge-ditolak { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }

    /* Action Buttons untuk Pengajuan */
    .btn-setujui {
        border: 1px solid #6ee7b7; background: #fff; color: #065f46;
        border-radius: 6px; padding: 5px 14px;
        font-size: 0.75rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        transition: background 0.15s;
    }
    .btn-setujui:hover { background: #d1fae5; }
    .btn-setujui:disabled { opacity: 0.5; cursor: default; }

    .btn-tolak {
        border: 1px solid #fca5a5; background: #fff; color: #dc2626;
        border-radius: 6px; padding: 5px 14px;
        font-size: 0.75rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        transition: background 0.15s;
    }
    .btn-tolak:hover { background: #fee2e2; }
    .btn-tolak:disabled { opacity: 0.5; cursor: default; }

    .btn-detail {
        border: 1px solid #4361ee; background: #fff; color: #4361ee;
        border-radius: 6px; padding: 5px 14px;
        font-size: 0.75rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        transition: all 0.15s;
    }
    .btn-detail:hover { background: #eff2fe; }

    /* Responsive */
    @media (max-width: 1024px) {
        .stat-cards { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .modal-card { width: 95vw; }
        .modal-body, .modal-header { padding: 18px 20px; }
        .detail-label { width: 110px; }
        .msg-preview { max-width: 200px; }
    }
</style>
@endpush

@section('content')
<div>

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-[1.35rem] font-bold text-sky-950">Inbox</h1>
        <p class="text-slate-500 text-[0.875rem] mt-1">Pesan dan pengajuan buku dari siswa.</p>
    </div>

    {{-- Flash --}}

    {{-- Daftar Pengajuan Buku --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] overflow-hidden mb-8" id="pengajuan">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="font-bold text-slate-800 text-[1rem]">Pengajuan Buku Baru</h2>
                <p class="text-[0.78rem] text-slate-400 mt-0.5">{{ $pengajuan->total() }} usulan dari siswa.</p>
            </div>
        </div>

        {{-- Filter Row Pengajuan --}}
        <div class="px-6 pt-5 pb-3">
            <form action="{{ route('penjaga.inbox') }}#pengajuan" method="GET" id="filterFormPengajuan">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <div class="flex items-center gap-3 flex-wrap">
                    <div class="flex-1 flex items-center gap-2 border border-slate-200 rounded-xl px-4 py-2.5 bg-white" style="min-width:200px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <input type="text" name="search_pengajuan" id="searchPengajuanInput" value="{{ $searchPengajuan ?? '' }}" placeholder="Cari judul buku, penulis, atau nama pengusul.." class="flex-1 border-none outline-none text-[0.85rem] text-slate-600 bg-transparent font-[inherit]">
                    </div>
                    <select name="status_pengajuan" class="border border-slate-200 rounded-xl px-4 py-2.5 text-[0.85rem] text-slate-600 bg-white outline-none cursor-pointer font-[inherit]" style="appearance: none; -webkit-appearance: none; padding-right: 36px; background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' stroke=\'%2394a3b8\' stroke-width=\'2\' viewBox=\'0 0 24 24\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M19 9l-7 7-7-7\'/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 15px;" onchange="document.getElementById('filterFormPengajuan').submit()">
                        <option value="semua" {{ (!$statusPengajuan || $statusPengajuan === 'semua') ? 'selected' : '' }}>Semua Status</option>
                        <option value="menunggu" {{ $statusPengajuan === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui" {{ $statusPengajuan === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ $statusPengajuan === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <button type="submit" class="hidden">Cari</button>
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50">
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">Judul Buku</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">Penulis</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">Pengusul</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">Kategori</th>
                        <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">Status</th>
                        <th class="px-5 py-3 text-center text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse ($pengajuan as $item)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-5 py-3.5 align-middle font-semibold text-slate-800 text-[0.82rem] leading-tight truncate max-w-[200px]">{{ $item->judul_buku }}</td>
                        <td class="px-5 py-3.5 align-middle text-[#444] text-[0.82rem] truncate max-w-[150px]">{{ $item->penulis }}</td>
                        <td class="px-5 py-3.5 align-middle text-[#444] text-[0.82rem]">{{ $item->user->name ?? '-' }}</td>
                        <td class="px-5 py-3.5 align-middle text-[#444] text-[0.82rem]">{{ $item->category->name ?? '-' }}</td>
                        <td class="px-5 py-3.5 align-middle">
                            @if($item->status === 'menunggu')
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide badge-menunggu">MENUNGGU</span>
                            @elseif($item->status === 'disetujui')
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide badge-disetujui">DISETUJUI</span>
                            @elseif($item->status === 'ditolak')
                                <span class="inline-block px-3 py-1 rounded-lg font-bold text-[0.65rem] tracking-wide badge-ditolak">DITOLAK</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-center align-middle">
                            <div class="flex gap-1.5 items-center justify-center">
                                {{-- Tombol Detail --}}
                                <button type="button" class="btn-detail"
                                    data-judul="{{ $item->judul_buku }}"
                                    data-penulis="{{ $item->penulis ?? '-' }}"
                                    data-isbn="{{ $item->isbn ?? '-' }}"
                                    data-penerbit="{{ $item->penerbit ?? '-' }}"
                                    data-tahun="{{ $item->tahun_terbit ?? '-' }}"
                                    data-pengusul="{{ $item->user->name ?? '-' }}"
                                    data-kategori="{{ $item->category->name ?? '-' }}"
                                    data-alasan="{{ $item->alasan ?? '-' }}"
                                    data-status="{{ $item->status }}"
                                    onclick="openDetailModal(this)">
                                    Detail
                                </button>
                                @if($item->status === 'menunggu')
                                {{-- Tombol Disetujui --}}
                                <form action="{{ route('penjaga.inbox.updateStatusPengajuan', $item->id) }}" method="POST" class="m-0 inline-block">
                                    @csrf
                                    <input type="hidden" name="status" value="disetujui">
                                    <button type="submit" class="btn-setujui">Setujui</button>
                                </form>
                                {{-- Tombol Ditolak --}}
                                <form action="{{ route('penjaga.inbox.updateStatusPengajuan', $item->id) }}" method="POST" class="m-0 inline-block">
                                    @csrf
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" class="btn-tolak">Tolak</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                                <p class="text-slate-400 text-[0.85rem]">Belum ada data pengajuan buku.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengajuan->hasPages())
        <div class="pagination-wrap">
            {{ $pengajuan->appends(['search_pengajuan' => $searchPengajuan, 'status_pengajuan' => $statusPengajuan, 'search' => request('search'), 'msg_page' => request('msg_page')])->links() }}
        </div>
        @endif
    </div>

    {{-- Stat Cards --}}
    @php
        $totalMessages = $messages->total();
    @endphp
    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Total Pesan</p>
                <p class="stat-card-value primary">{{ $totalMessages }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0l-8 4-8-4"/></svg>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Belum Dibaca</p>
                <p class="stat-card-value warning">{{ $unreadCount }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
        </div>
    </div>

    {{-- Message List --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between flex-wrap gap-3">
            <h2 class="font-bold text-slate-800 text-[1rem]">Pesan Masuk</h2>
            <div class="flex items-center gap-4 flex-wrap">
                <form method="GET" action="{{ route('penjaga.inbox') }}" class="m-0">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pengirim..." class="bg-white border border-slate-200 text-slate-600 text-[0.82rem] pl-9 pr-4 py-1.5 rounded-lg outline-none focus:border-indigo-500 w-full transition-colors" style="min-width:180px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </div>
                </form>
                <span class="text-[0.75rem] text-slate-400 font-medium whitespace-nowrap">{{ $totalMessages }} pesan</span>
            </div>
        </div>

        @forelse ($messages as $msg)
        <a href="{{ route('penjaga.inbox.show', $msg->id) }}"
           class="msg-item {{ $msg->is_read ? 'msg-read' : 'unread' }} flex">
            <div class="msg-avatar">
                {{ strtoupper(substr($msg->user->name ?? 'S', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="msg-subject">{{ $msg->subject }}</p>
                <p class="msg-preview">{{ Str::limit($msg->body, 100) }}</p>
                <p class="msg-meta">
                    Dari: <strong>{{ $msg->user->name ?? 'Siswa' }}</strong>
                    &bull; {{ $msg->created_at->diffForHumans() }}
                </p>
            </div>
            @if(!$msg->is_read)
            <div class="msg-unread-dot self-center"></div>
            @endif
        </a>
        @empty
        <div class="px-6 py-14 text-center">
            <div class="flex flex-col items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0l-8 4-8-4"/>
                </svg>
                <p class="text-slate-400 text-[0.85rem]">
                    {{ request('search') ? 'Tidak ada pesan dari pengirim dengan nama tersebut.' : 'Belum ada pesan masuk.' }}
                </p>
            </div>
        </div>
        @endforelse

        @if($messages->hasPages())
        <div class="pagination-wrap">
            {{ $messages->links() }}
        </div>
        @endif
    </div>

    </div>

    {{-- Modal Detail Pengajuan --}}
    <div class="modal-overlay" id="detailModal">
        <div class="modal-card">
            <div class="modal-header">
                <h2>Detail Pengajuan</h2>
                <button type="button" class="modal-close" onclick="closeDetailModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="detail-row">
                    <div class="detail-label">Judul Buku</div>
                    <div class="detail-value" id="mdl-judul"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Penulis</div>
                    <div class="detail-value" id="mdl-penulis"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Penerbit & Tahun</div>
                    <div class="detail-value"><span id="mdl-penerbit"></span> (<span id="mdl-tahun"></span>)</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">ISBN</div>
                    <div class="detail-value" id="mdl-isbn"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Kategori</div>
                    <div class="detail-value" id="mdl-kategori"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Pengusul</div>
                    <div class="detail-value" id="mdl-pengusul"></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Status</div>
                    <div class="detail-value" id="mdl-status" style="text-transform: capitalize; font-weight: 600;"></div>
                </div>
                <div style="margin-top: 20px;">
                    <div class="detail-label" style="width: auto; margin-bottom: 6px;">Alasan Pengajuan:</div>
                    <div class="detail-reason" id="mdl-alasan"></div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Auto-submit search on Enter
    document.getElementById('searchPengajuanInput').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('filterFormPengajuan').submit();
        }
    });

    // Modal logic
    function openDetailModal(btn) {
        document.getElementById('mdl-judul').innerText = btn.dataset.judul;
        document.getElementById('mdl-penulis').innerText = btn.dataset.penulis;
        document.getElementById('mdl-penerbit').innerText = btn.dataset.penerbit;
        document.getElementById('mdl-tahun').innerText = btn.dataset.tahun;
        document.getElementById('mdl-isbn').innerText = btn.dataset.isbn;
        document.getElementById('mdl-kategori').innerText = btn.dataset.kategori;
        document.getElementById('mdl-pengusul').innerText = btn.dataset.pengusul;
        
        const status = btn.dataset.status;
        const statusEl = document.getElementById('mdl-status');
        statusEl.innerText = status;
        if (status === 'disetujui') statusEl.style.color = '#065f46';
        else if (status === 'ditolak') statusEl.style.color = '#dc2626';
        else statusEl.style.color = '#92400e';

        document.getElementById('mdl-alasan').innerText = btn.dataset.alasan;
        
        document.getElementById('detailModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close on click outside
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) closeDetailModal();
    });
</script>
@endpush
