@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.penjaga')

@section('title', 'Pengajuan Buku')

@push('styles')
<style>
    .page-header { margin-bottom: 20px; }
    .page-header h1 { font-size: 1.4rem; font-weight: 700; color: #222; margin: 0 0 4px; }
    .page-header p { font-size: 0.82rem; color: #4361ee; margin: 0; }

    .content-panel {
        background: #fff; border-radius: 14px;
        border: 1px solid #eee; overflow: hidden;
    }

    /* Search & Filter Row */
    .filter-row {
        display: flex; align-items: center; gap: 10px;
        padding: 16px 16px 0;
    }
    .search-wrap {
        flex: 1; display: flex; align-items: center; gap: 10px;
        background: #fff; border-radius: 10px;
        border: 1px solid #ddd; padding: 10px 16px;
    }
    .search-wrap svg { color: #bbb; flex-shrink: 0; }
    .search-wrap input {
        flex: 1; border: none; outline: none;
        font-size: 0.88rem; color: #555; background: transparent;
        font-family: inherit;
    }
    .status-select {
        border: 1px solid #ddd; border-radius: 10px;
        padding: 10px 16px; font-size: 0.88rem;
        color: #555; background: #fff; outline: none;
        cursor: pointer; font-family: inherit;
        appearance: none; -webkit-appearance: none;
        padding-right: 36px;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23999' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 15px;
    }
    .filter-submit-btn {
        display: none;
    }

    /* Table */
    .pengajuan-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
    .pengajuan-table th {
        text-align: left; font-size: 0.72rem;
        font-weight: 700; color: #888;
        text-transform: uppercase; padding: 14px 16px;
        border-bottom: 1px solid #f0f0f0;
        background: #fafafa;
    }
    .pengajuan-table td {
        padding: 13px 16px; font-size: 0.85rem;
        color: #444; border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .pengajuan-table tr:last-child td { border-bottom: none; }
    .pengajuan-table tr:hover td { background: #f8f9ff; }

    .title-main { font-weight: 600; color: #222; }

    /* Status Badges */
    .badge {
        display: inline-block; padding: 4px 14px;
        border-radius: 20px; font-size: 0.72rem;
        font-weight: 700; white-space: nowrap;
        text-align: center; min-width: 80px;
    }
    .badge-menunggu { background: #fef9c3; color: #92400e; border: 1px solid #fde68a; }
    .badge-disetujui { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
    .badge-ditolak { background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }

    /* Action Buttons */
    .action-btns { display: flex; gap: 6px; align-items: center; }
    .btn-setujui {
        border: 1px solid #6ee7b7; background: #fff; color: #065f46;
        border-radius: 6px; padding: 5px 14px;
        font-size: 0.78rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        transition: background 0.15s;
    }
    .btn-setujui:hover { background: #d1fae5; }
    .btn-setujui:disabled { opacity: 0.5; cursor: default; }

    .btn-tolak {
        border: 1px solid #fca5a5; background: #fff; color: #dc2626;
        border-radius: 6px; padding: 5px 14px;
        font-size: 0.78rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        transition: background 0.15s;
    }
    .btn-tolak:hover { background: #fee2e2; }
    .btn-tolak:disabled { opacity: 0.5; cursor: default; }

    .btn-detail {
        border: 1px solid #4361ee; background: #fff; color: #4361ee;
        border-radius: 6px; padding: 5px 14px;
        font-size: 0.78rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        transition: all 0.15s;
    }
    .btn-detail:hover { background: #eff2fe; }

    /* Modal Styles */
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

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state svg { color: #d1d5db; margin-bottom: 16px; }
    .empty-state h3 { font-size: 0.95rem; color: #555; margin: 0 0 6px; font-weight: 600; }
    .empty-state p { font-size: 0.82rem; color: #999; margin: 0; }

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

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <h1>Pengajuan Buku</h1>
        <p>Daftar buku yang diusulkan oleh anggota perpustakaan</p>
    </div>

    <div class="content-panel">
        {{-- Filter Row --}}
        <form action="{{ route('admin.pengajuan.index') }}" method="GET" id="filterForm">
            <div class="filter-row">
                <div class="search-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                    </svg>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari judul buku, penulis, atau nama pengusul..">
                </div>
                <select name="status" class="status-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="semua" {{ (!$status || $status === 'semua') ? 'selected' : '' }}>Semua Status</option>
                    <option value="menunggu" {{ $status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="disetujui" {{ $status === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ $status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <button type="submit" class="filter-submit-btn">Cari</button>
            </div>
        </form>

        {{-- Table --}}
        <table class="pengajuan-table">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Pengusul</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengajuan as $item)
                <tr>
                    <td><div class="title-main">{{ $item->judul_buku }}</div></td>
                    <td>{{ $item->penulis }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->category->name ?? '-' }}</td>
                    <td>
                        @if($item->status === 'menunggu')
                            <span class="badge badge-menunggu">Menunggu</span>
                        @elseif($item->status === 'disetujui')
                            <span class="badge badge-disetujui">Disetujui</span>
                        @elseif($item->status === 'ditolak')
                            <span class="badge badge-ditolak">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-btns">
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
                            {{-- Tombol Disetujui --}}
                            <form action="{{ route('admin.pengajuan.updateStatus', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="status" value="disetujui">
                                <button type="submit" class="btn-setujui" {{ $item->status === 'disetujui' ? 'disabled' : '' }}>Disetujui</button>
                            </form>
                            {{-- Tombol Ditolak --}}
                            <form action="{{ route('admin.pengajuan.updateStatus', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" class="btn-tolak" {{ $item->status === 'ditolak' ? 'disabled' : '' }}>Ditolak</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <h3>Belum ada pengajuan buku</h3>
                            <p>Pengajuan dari anggota akan muncul di sini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($pengajuan->hasPages())
        <div class="pagination-wrap">
            {{ $pengajuan->links() }}
        </div>
        @endif
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
                    <div class="detail-label" style="width: auto;">Alasan Pengajuan:</div>
                    <div class="detail-reason" id="mdl-alasan"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Auto-submit search on Enter (it auto-submits on status change via onchange)
    document.querySelector('.search-wrap input').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('filterForm').submit();
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
