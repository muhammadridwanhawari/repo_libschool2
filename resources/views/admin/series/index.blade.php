@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.penjaga')

@section('title', 'Series Buku')

@push('styles')
<style>
    .page-header { margin-bottom: 20px; }
    .page-header h1 { font-size: 1.4rem; font-weight: 700; color: #222; margin: 0 0 4px; }
    .page-header p { font-size: 0.82rem; color: #4361ee; margin: 0; }

    .kategori-wrapper {
        display: grid;
        grid-template-columns: 1fr 1.4fr;
        gap: 24px;
        align-items: start;
    }

    /* Form panel */
    .form-panel {
        background: #f8f9fb; border-radius: 14px;
        padding: 24px; border: 1px solid #eee;
    }
    .form-panel h3 {
        font-size: 1rem; font-weight: 700;
        color: #222; margin: 0 0 20px;
    }
    .form-row {
        display: flex; gap: 16px; margin-bottom: 16px;
    }
    .form-group { flex: 1; margin-bottom: 16px; }
    .form-group label {
        display: block; font-size: 0.82rem;
        font-weight: 600; color: #333; margin-bottom: 6px;
    }
    .form-group label span { color: #ef4444; }
    .form-group input, .form-group textarea {
        width: 100%; padding: 10px 14px;
        border: 1px solid #ddd; border-radius: 10px;
        font-size: 0.85rem; font-family: inherit;
        outline: none; transition: border 0.2s;
        box-sizing: border-box;
    }
    .form-group input:focus, .form-group textarea:focus { border-color: #4361ee; }
    .form-group input.is-invalid, .form-group textarea.is-invalid { border-color: #ef4444; }
    .error-msg { font-size: 0.75rem; color: #ef4444; margin-top: 4px; }

    .btn-submit {
        display: block; width: 100%;
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        color: #fff; border: none; border-radius: 10px;
        padding: 13px; font-size: 0.9rem;
        font-weight: 600; cursor: pointer;
        transition: all 0.2s; font-family: inherit;
    }
    .btn-submit:hover {
        background: linear-gradient(135deg, #3a56d4, #2f49c0);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(67,97,238,0.3);
    }
    .btn-cancel {
        display: block; width: 100%;
        background: #e5e7eb; color: #444;
        border: none; border-radius: 10px;
        padding: 11px; font-size: 0.85rem;
        font-weight: 600; cursor: pointer;
        margin-top: 8px; transition: all 0.2s;
        text-align: center; text-decoration: none;
        font-family: inherit;
    }
    .btn-cancel:hover { background: #d1d5db; }

    /* Table panel */
    .table-panel {
        background: #f8f9fb; border-radius: 14px;
        padding: 24px; border: 1px solid #eee;
    }
    .table-panel h3 {
        font-size: 1rem; font-weight: 700;
        color: #222; margin: 0 0 16px;
    }

    .search-table-wrap {
        display: flex; align-items: center; gap: 10px;
        background: #fff; border-radius: 10px;
        border: 1px solid #ddd; padding: 8px 14px;
        margin-bottom: 16px;
    }
    .search-table-wrap svg { color: #bbb; flex-shrink: 0; }
    .search-table-wrap input {
        flex: 1; border: none; outline: none;
        font-size: 0.85rem; color: #555;
        background: transparent; font-family: inherit;
    }

    .cat-table { width: 100%; border-collapse: collapse; }
    .cat-table th {
        text-align: left; font-size: 0.72rem;
        font-weight: 700; color: #888;
        text-transform: uppercase; padding: 10px 12px;
        border-bottom: 2px solid #e5e7eb;
    }
    .cat-table td {
        padding: 11px 12px; font-size: 0.85rem;
        color: #444; border-bottom: 1px solid #f0f0f0;
    }
    .cat-table tr:hover td { background: #f0f3ff; }

    .action-btns { display: flex; gap: 8px; }
    .btn-edit, .btn-delete {
        width: 30px; height: 30px;
        display: inline-flex; align-items: center;
        justify-content: center; border: none;
        border-radius: 6px; cursor: pointer;
        transition: all 0.15s;
    }
    .btn-edit {
        background: #eef0ff; color: #4361ee;
    }
    .btn-edit:hover { background: #dde1ff; }
    .btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-delete:hover { background: #fecaca; }

    .empty-state {
        text-align: center; padding: 30px;
        color: #999; font-size: 0.85rem;
    }

    .pagination-wrap {
        display: flex; align-items: center;
        gap: 4px; margin-top: 14px;
    }
    .pagination-wrap a, .pagination-wrap span {
        display: inline-flex; align-items: center;
        justify-content: center; width: 30px; height: 30px;
        border-radius: 6px; font-size: 0.8rem;
        text-decoration: none; color: #666;
        border: 1px solid #e5e7eb;
    }
    .pagination-wrap .active {
        background: #4361ee; color: #fff; border-color: #4361ee;
    }
    .pagination-wrap nav p.text-sm.text-gray-700 { display: none !important; }

    /* Responsive */
    @media (max-width: 1024px) {
        .kategori-wrapper { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .page-header h1 { font-size: 1.15rem; }
        .form-panel, .table-panel { padding: 16px; }
    }
</style>
@endpush

@section('content')
    {{-- Page Header --}}
    <div class="page-header">
        <h1>Series Buku</h1>
        <p>Kelola data series buku perpustakaan</p>
    </div>

    @if(session('success'))
    <div style="background:#d1fae5; color:#065f46; padding:12px; border-radius:8px; margin-bottom:16px; border:1px solid #a7f3d0; font-size: 0.85rem;">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:16px; border:1px solid #fecaca; font-size: 0.85rem;">
        {{ session('error') }}
    </div>
    @endif

    <div class="kategori-wrapper">
        {{-- Left: Form --}}
        <div class="form-panel">
            @if($editSeries)
                <h3>Edit Series Buku</h3>
                <form action="{{ route('admin.series.update', $editSeries->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Nama Series <span>*</span></label>
                        <input type="text" name="name"
                                value="{{ old('name', $editSeries->name) }}"
                                placeholder="Masukan Nama Series"
                                class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                        @error('name')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" rows="3"
                                placeholder="Masukan Deskripsi"
                                class="{{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description', $editSeries->description) }}</textarea>
                        @error('description')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn-submit">✓ Simpan Perubahan</button>
                    <a href="{{ route('admin.series.index') }}" class="btn-cancel">Batal</a>
                </form>
            @else
                <h3>Tambah Series Baru</h3>
                <form action="{{ route('admin.series.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama Series <span>*</span></label>
                        <input type="text" name="name"
                                value="{{ old('name') }}"
                                placeholder="Masukan Nama Series"
                                class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                        @error('name')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" rows="3"
                                placeholder="Masukan Deskripsi"
                                class="{{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn-submit">+ Tambah Series</button>
                </form>
            @endif
        </div>

        {{-- Right: Table --}}
        <div class="table-panel">
            <h3>Daftar Series Buku</h3>

            {{-- Search --}}
            <form action="{{ route('admin.series.index') }}" method="GET">
                <div class="search-table-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                    </svg>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Nama Series...">
                </div>
            </form>

            <table class="cat-table">
                <thead>
                    <tr>
                        <th>Nama Series</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Buku</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($series as $s)
                    <tr>
                        <td style="font-weight:600; color:#222;">{{ $s->name }}</td>
                        <td>{{ Str::limit($s->description ?? '-', 50) }}</td>
                        <td>{{ $s->books_count }} Buku</td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('admin.series.index', ['edit' => $s->id]) }}" class="btn-edit" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.series.destroy', $s->id) }}" method="POST"
                                      onsubmit="confirmAction(event, 'Yakin ingin menghapus series {{ $s->name }}?', 'Ya, Hapus', 'Konfirmasi Hapus'); return false;">
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
                        <td colspan="4" class="empty-state">Belum ada series buku.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if($series->hasPages())
            <div class="pagination-wrap">
                {{ $series->appends(['search' => $search])->links() }}
            </div>
            @endif
        </div>
    </div>
@endsection
