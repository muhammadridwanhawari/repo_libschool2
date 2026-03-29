@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.penjaga')

@section('title', 'Data Buku')

@push('styles')
<style>
    .page-header {
        display: flex; align-items: center;
        justify-content: space-between; margin-bottom: 20px;
    }
    .page-header h1 { font-size: 1.4rem; font-weight: 700; color: #222; margin: 0 0 4px; }
    .page-header p { font-size: 0.82rem; color: #4361ee; margin: 0; }
    .btn-tambah {
        background: linear-gradient(135deg, #4361ee, #3a56d4); color: #fff;
        border: none; border-radius: 8px;
        padding: 10px 18px; font-size: 0.85rem;
        font-weight: 600; cursor: pointer;
        font-family: inherit; text-decoration: none;
        display: inline-flex; align-items: center; gap: 6px;
        transition: all 0.2s;
    }
    .btn-tambah:hover {
        background: linear-gradient(135deg, #3a56d4, #2f49c0);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(67,97,238,0.3);
    }

    /* Search */
    .search-wrap {
        display: flex; align-items: center; gap: 10px;
        background: #fff; border-radius: 10px;
        border: 1px solid #ddd; padding: 10px 16px;
        margin-bottom: 16px;
    }
    .search-wrap svg { color: #bbb; flex-shrink: 0; }
    .search-wrap input {
        flex: 1; border: none; outline: none;
        font-size: 0.9rem; color: #555; background: transparent;
        font-family: inherit;
    }

    /* Content Panel */
    .content-panel {
        background: #fff; border-radius: 14px;
        border: 1px solid #eee; overflow: hidden;
    }

    /* Table */
    .buku-table { width: 100%; border-collapse: collapse; }
    .buku-table th {
        text-align: left; font-size: 0.72rem;
        font-weight: 700; color: #888;
        text-transform: uppercase; padding: 14px 16px;
        border-bottom: 1px solid #f0f0f0;
        background: #fafafa;
    }
    .buku-table td {
        padding: 14px 16px; font-size: 0.85rem;
        color: #444; border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .buku-table tr:last-child td { border-bottom: none; }
    .buku-table tr:hover td { background: #f8f9ff; }

    /* Cover */
    .cover-img {
        width: 48px; height: 64px; object-fit: cover;
        border-radius: 4px; border: 1px solid #eee;
    }
    .no-cover {
        width: 48px; height: 64px; background: #f0f0f0;
        border-radius: 4px; display: flex; align-items: center;
        justify-content: center; font-size: 0.6rem; color: #999;
        border: 1px solid #eee; text-align: center; line-height: 1.3;
    }

    /* Book title */
    .book-title { font-weight: 600; color: #222; margin-bottom: 2px; }
    .book-isbn { font-size: 0.75rem; color: #888; }
    .book-tags { display: flex; flex-wrap: wrap; gap: 4px; margin-top: 4px; }
    .tag {
        background: #f0f3ff; color: #4361ee;
        border-radius: 4px; padding: 1px 8px;
        font-size: 0.7rem; font-weight: 500;
    }

    /* Author */
    .author-name { font-weight: 500; color: #333; }
    .author-publisher { font-size: 0.75rem; color: #888; }

    /* Action btns */
    .action-btns { display: flex; gap: 8px; align-items: center; }
    .btn-edit, .btn-delete {
        width: 30px; height: 30px;
        display: inline-flex; align-items: center;
        justify-content: center; border: none;
        border-radius: 6px; cursor: pointer;
        transition: all 0.15s;
    }
    .btn-edit { background: #eef0ff; color: #4361ee; }
    .btn-edit:hover { background: #dde1ff; }
    .btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-delete:hover { background: #fecaca; }

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

    /* Alert */
    .alert-success {
        background: #d1fae5; color: #065f46;
        border: 1px solid #a7f3d0; border-radius: 8px;
        padding: 10px 16px; margin-bottom: 16px;
        font-size: 0.85rem;
    }

    /* ======= MODAL ======= */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.45); z-index: 1000;
        align-items: center; justify-content: center;
    }
    .modal-overlay.active { display: flex; }

    .modal {
        background: #fff; border-radius: 16px;
        padding: 36px 40px; width: 780px; max-width: 95vw;
        max-height: 90vh; overflow-y: auto;
        position: relative;
    }
    .modal h2 {
        font-size: 1.2rem; font-weight: 700;
        color: #222; margin: 0 0 28px;
    }

    .modal-body {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 24px 40px;
    }
    .modal-left, .modal-right { display: flex; flex-direction: column; gap: 18px; }

    .form-group label {
        display: block; font-size: 0.85rem;
        font-weight: 600; color: #333; margin-bottom: 6px;
    }
    .form-group label .required { color: #ef4444; }
    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="file"] {
        width: 100%; padding: 10px 14px;
        border: 1px solid #ddd; border-radius: 8px;
        font-size: 0.85rem; font-family: inherit;
        outline: none; transition: border 0.2s;
        box-sizing: border-box;
    }
    .form-group input:focus { border-color: #4361ee; }

    /* Kategori toggle buttons */
    .kategori-box {
        border: 1px solid #ddd; border-radius: 8px;
        padding: 14px; display: flex; flex-wrap: wrap; gap: 8px;
        min-height: 80px;
    }
    .kat-btn {
        border: 1.5px solid #ddd; background: #fff;
        border-radius: 10px; padding: 7px 18px;
        font-size: 0.85rem; cursor: pointer;
        font-family: inherit; transition: all 0.18s;
        color: #333; user-select: none;
    }
    .kat-btn:hover { border-color: #4361ee; color: #4361ee; background: #f0f3ff; }
    .kat-btn.selected {
        background: #4361ee; color: #fff; border-color: #4361ee;
        box-shadow: 0 2px 8px rgba(67,97,238,0.25);
    }
    .kat-hint { font-size: 0.75rem; color: #999; margin-top: 6px; }

    /* File input wrapper */
    .file-input-wrap {
        border: 1px solid #ddd; border-radius: 8px;
        padding: 10px 14px; display: flex; align-items: center;
        gap: 12px; cursor: pointer;
    }
    .file-input-wrap input[type="file"] {
        border: none; padding: 0; cursor: pointer;
        font-size: 0.82rem;
    }

    /* Modal footer */
    .modal-footer {
        display: flex; justify-content: flex-end;
        gap: 10px; margin-top: 28px;
        padding-top: 20px; border-top: 1px solid #f0f0f0;
    }
    .btn-batal {
        background: #fff; color: #555;
        border: 1px solid #ddd; border-radius: 8px;
        padding: 9px 24px; font-size: 0.85rem;
        font-weight: 600; cursor: pointer; font-family: inherit;
    }
    .btn-batal:hover { background: #f5f5f5; }
    .btn-simpan {
        background: linear-gradient(135deg, #4361ee, #3a56d4); color: #fff;
        border: none; border-radius: 8px;
        padding: 9px 24px; font-size: 0.85rem;
        font-weight: 600; cursor: pointer; font-family: inherit;
        transition: all 0.2s;
    }
    .btn-simpan:hover {
        background: linear-gradient(135deg, #3a56d4, #2f49c0);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(67,97,238,0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        .btn-tambah { width: 100%; justify-content: center; }
        .page-header h1 { font-size: 1.15rem; }
    }
    @media (max-width: 640px) {
        .modal-body { grid-template-columns: 1fr; }
        .modal { padding: 24px 18px; }
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1>Data Buku</h1>
        <p>Kelola direktori dan informasi buku perpustakaan</p>
    </div>
    <a href="{{ route('admin.buku.create') }}" class="btn-tambah">+ Tambah Buku</a>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif

{{-- Statistic Cards --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; margin-bottom: 20px;">
    {{-- Card 1: Jumlah Buku --}}
    <div style="background: #fff; border: 1px solid #eee; border-radius: 14px; padding: 20px; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h3 style="font-size: 0.9rem; color: #666; font-weight: 600; margin: 0 0 5px 0;">Jumlah Buku</h3>
            <div style="font-size: 1.5rem; font-weight: 700; color: #4361ee;">{{ number_format($totalBuku, 0, ',', '.') }}</div>
        </div>
        <div style="background: #eff2fe; color: #4361ee; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
        </div>
    </div>
    
    {{-- Card 2: Jumlah Stok --}}
    <div style="background: #fff; border: 1px solid #eee; border-radius: 14px; padding: 20px; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h3 style="font-size: 0.9rem; color: #666; font-weight: 600; margin: 0 0 5px 0;">Jumlah Stok</h3>
            <div style="font-size: 1.5rem; font-weight: 700; color: #10b981;">{{ number_format($totalStok, 0, ',', '.') }}</div>
        </div>
        <div style="background: #d1fae5; color: #10b981; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
    </div>
</div>

{{-- Main Panel --}}
<div class="content-panel">
    {{-- Search --}}
    <div class="px-6 pt-5 pb-3">
        <form action="{{ route('admin.buku.index') }}" method="GET">
            <div class="flex items-center gap-2 border border-slate-200 rounded-xl px-4 py-2.5 bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Judul, Penulis atau ISBN.." class="flex-1 border-none outline-none text-[0.88rem] text-slate-600 bg-transparent font-[inherit]">
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">SAMPUL</th>
                    <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">JUDUL &amp; ISBN</th>
                    <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">PENULIS</th>
                    <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">STOK</th>
                    <th class="px-5 py-3 text-left text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">LOKASI</th>
                    <th class="px-5 py-3 text-center text-[0.72rem] font-bold text-[#888] uppercase border-b border-slate-100">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse ($books as $buku)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-3.5 align-middle">
                    @if($buku->cover)
                        <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover" class="cover-img">
                    @else
                        <div class="no-cover">No<br>Image</div>
                    @endif
                </td>
                <td class="px-5 py-3.5 align-middle">
                    <div class="book-title">{{ $buku->title }}</div>
                    @if($buku->isbn)
                        <div class="book-isbn">ISBN: {{ $buku->isbn }}</div>
                    @endif
                    @if($buku->categories->isNotEmpty())
                        <div class="book-tags">
                            @foreach($buku->categories as $cat)
                                <span class="tag">{{ $cat->name }}</span>
                            @endforeach
                        </div>
                    @endif
                </td>
                <td class="px-5 py-3.5 align-middle">
                    <div class="author-name">{{ $buku->author ?? '-' }}</div>
                    @if($buku->publisher)
                        <div class="author-publisher">{{ $buku->publisher }}</div>
                    @endif
                    </td>
                    <td class="px-5 py-3.5 align-middle text-[#444] text-[0.85rem]">{{ $buku->stock }}</td>
                    <td class="px-5 py-3.5 align-middle text-[#444] text-[0.85rem]">{{ $buku->location ?? '-' }}</td>
                    <td class="px-5 py-3.5 text-center align-middle">
                    <div class="action-btns">
                        <button type="button" class="btn-edit btn-edit-buku" title="Edit"
                            data-id="{{ $buku->id }}"
                            data-title="{{ $buku->title }}"
                            data-isbn="{{ $buku->isbn ?? '' }}"
                            data-stock="{{ $buku->stock }}"
                            data-author="{{ $buku->author ?? '' }}"
                            data-publisher="{{ $buku->publisher ?? '' }}"
                            data-pages="{{ $buku->pages ?? '' }}"
                            data-series="{{ $buku->book_series_id ?? '' }}"
                            data-location="{{ $buku->location ?? '' }}"
                            data-sinopsis="{{ $buku->sinopsis ?? '' }}"
                            data-categories="{{ $buku->categories->pluck('id')->join(',') }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </button>
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST"
                              onsubmit="confirmAction(event, 'Yakin ingin menghapus buku {{ addslashes($buku->title) }}?', 'Ya, Hapus', 'Konfirmasi Hapus'); return false;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                                </svg>
                            </button>
                        </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-14 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                            <p class="text-slate-400 text-[0.85rem]">Belum ada data buku.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($books->hasPages())
    <div class="pagination-wrap">
        {{ $books->appends(['search' => $search])->links() }}
    </div>
    @endif
</div>

{{-- ============ MODAL EDIT BUKU ============ --}}
<div class="modal-overlay" id="modalEdit">
    <div class="modal">
        <h2>Edit Buku</h2>
        <form id="editForm" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="modal-left">
                    <div class="form-group">
                        <label>Judul Buku <span class="required">*</span></label>
                        <input type="text" name="title" id="editTitle" required>
                    </div>
                    <div class="form-group">
                        <label>ISBN</label>
                        <input type="text" name="isbn" id="editIsbn">
                    </div>
                    <div class="form-group">
                        <label>Stok <span class="required">*</span></label>
                        <input type="number" name="stock" id="editStock" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Penulis</label>
                        <input type="text" name="author" id="editAuthor">
                    </div>
                    <div class="form-group">
                        <label>Penerbit</label>
                        <input type="text" name="publisher" id="editPublisher">
                    </div>
                    <div class="form-group">
                        <label>Jumlah Halaman</label>
                        <input type="number" name="pages" id="editPages" min="1">
                    </div>
                    <div class="form-group">
                        <label>Lokasi Rak</label>
                        <input type="text" name="location" id="editLocation">
                    </div>
                </div>
                <div class="modal-right">
                    <div class="form-group">
                        <label>Kategori</label>
                        <div class="kategori-box" id="editKategoriBox">
                            @foreach($categories as $cat)
                                <button type="button" class="kat-btn"
                                    data-id="{{ $cat->id }}"
                                    onclick="toggleKat(this, 'edit')">
                                    {{ $cat->name }}
                                </button>
                            @endforeach
                        </div>
                        <div id="editKatInputs"></div>
                        <div class="kat-hint">Klik untuk memilih kategori !</div>
                    </div>
                    <div class="form-group">
                        <label>Ganti Sampul Buku (opsional)</label>
                        <div class="file-input-wrap">
                            <input type="file" name="cover" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Series Buku</label>
                        <select name="book_series_id" id="editSeries" style="width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.85rem; font-family: inherit; outline: none; background: #fff;">
                            <option value="">-- Tidak Ada --</option>
                            @foreach($series as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label>Sinopsis</label>
                    <textarea name="sinopsis" id="editSinopsis" rows="5" style="width: 100%; padding: 12px 16px; border: 1px solid #ddd; border-radius: 8px; font-size: 0.9rem; font-family: inherit; outline: none; transition: border 0.2s; box-sizing: border-box; resize: vertical; min-height: 120px;"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-batal" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // ======= KATEGORI TOGGLE =======
    function toggleKat(btn, mode) {
        btn.classList.toggle('selected');
        syncKatInputs(mode);
    }

    function syncKatInputs(mode) {
        const box    = document.getElementById(mode === 'tambah' ? 'tambahKategoriBox' : 'editKategoriBox');
        const wrap   = document.getElementById(mode === 'tambah' ? 'tambahKatInputs'   : 'editKatInputs');
        wrap.innerHTML = '';
        box.querySelectorAll('.kat-btn.selected').forEach(btn => {
            const inp = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'category_ids[]';
            inp.value = btn.dataset.id;
            wrap.appendChild(inp);
        });
    }

    function clearKatSelection(mode) {
        const box = document.getElementById(mode === 'tambah' ? 'tambahKategoriBox' : 'editKategoriBox');
        box.querySelectorAll('.kat-btn').forEach(b => b.classList.remove('selected'));
        syncKatInputs(mode);
    }

    function setKatSelection(mode, ids) {
        clearKatSelection(mode);
        const box = document.getElementById(mode === 'tambah' ? 'tambahKategoriBox' : 'editKategoriBox');
        ids.forEach(id => {
            const btn = box.querySelector('.kat-btn[data-id="' + id + '"]');
            if (btn) btn.classList.add('selected');
        });
        syncKatInputs(mode);
    }

    // ======= MODAL EDIT =======
    document.querySelectorAll('.btn-edit-buku').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const route = '{{ route("admin.buku.update", ":id") }}'.replace(':id', id);
            document.getElementById('editForm').action = route;
            document.getElementById('editTitle').value    = this.dataset.title;
            document.getElementById('editIsbn').value     = this.dataset.isbn;
            document.getElementById('editStock').value    = this.dataset.stock;
            document.getElementById('editAuthor').value   = this.dataset.author;
            document.getElementById('editPublisher').value = this.dataset.publisher;
            document.getElementById('editPages').value    = this.dataset.pages;
            document.getElementById('editSeries').value   = this.dataset.series;
            document.getElementById('editLocation').value = this.dataset.location;
            document.getElementById('editSinopsis').value = this.dataset.sinopsis;
            // Set selected categories (array)
            const categoryIds = this.dataset.categories;
            const ids = typeof categoryIds === 'string' && categoryIds !== '' ? categoryIds.split(',') : [];
            setKatSelection('edit', ids);
            document.getElementById('modalEdit').classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });
    function closeEditModal() {
        document.getElementById('modalEdit').classList.remove('active');
        document.body.style.overflow = '';
    }
    document.getElementById('modalEdit').addEventListener('click', function(e) {
        if (e.target === this) closeEditModal();
    });
</script>

@endpush

@endsection
