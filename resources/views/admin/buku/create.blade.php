@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.penjaga')

@section('title', 'Tambah Buku Baru')

@push('styles')
<style>
    .breadcrumb { font-size: 0.85rem; margin-bottom: 0; }
    .breadcrumb a { color: #4361ee; text-decoration: none; }
    .breadcrumb span { color: #666; }

    .page-header {
        display: flex; align-items: center;
        justify-content: space-between; margin-bottom: 20px;
    }
    
    .content-panel {
        background: #fff; border-radius: 14px;
        border: 1px solid #eee; padding: 36px 40px;
    }

    .form-row {
        display: grid; grid-template-columns: 1fr 1fr;
        gap: 24px 40px;
    }

    .form-group { margin-bottom: 18px; }
    .form-group label {
        display: block; font-size: 0.85rem;
        font-weight: 600; color: #333; margin-bottom: 6px;
    }
    .form-group label .required { color: #ef4444; }
    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="file"],
    .form-group select,
    .form-group textarea {
        width: 100%; padding: 10px 14px;
        border: 1px solid #ddd; border-radius: 8px;
        font-size: 0.85rem; font-family: inherit;
        outline: none; transition: border 0.2s;
        box-sizing: border-box; background: #fff;
    }
    .form-group input:focus, .form-group textarea:focus, .form-group select:focus { border-color: #4361ee; }

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

    .footer-actions {
        display: flex; justify-content: flex-end; gap: 10px;
        margin-top: 28px; padding-top: 20px; border-top: 1px solid #f0f0f0;
    }
    .btn-batal {
        background: #fff; color: #555;
        border: 1px solid #ddd; border-radius: 8px;
        padding: 9px 24px; font-size: 0.85rem; text-decoration: none;
        font-weight: 600; cursor: pointer; font-family: inherit;
        display: inline-flex; align-items: center; justify-content: center;
    }
    .btn-batal:hover { background: #f5f5f5; }
    .btn-simpan {
        background: #4361ee; color: #fff;
        border: none; border-radius: 8px;
        padding: 9px 24px; font-size: 0.85rem;
        font-weight: 600; cursor: pointer; font-family: inherit;
        transition: background 0.2s;
    }
    .btn-simpan:hover { background: #3a56d4; }
    
    .alert-error {
        background: #fee2e2; color: #dc2626;
        border: 1px solid #fecaca; border-radius: 8px;
        padding: 12px 16px; margin-bottom: 20px;
        font-size: 0.85rem;
    }
    .alert-error ul {
        margin: 0; padding-left: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-row { grid-template-columns: 1fr; gap: 0; }
        .content-panel { padding: 20px 16px; }
        .footer-actions { flex-direction: column; }
        .btn-batal, .btn-simpan { width: 100%; text-align: center; justify-content: center; }
    }
</style>
@endpush

@section('content')

<div class="page-header">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Kelola Data</a>
        <span> / </span>
        <a href="{{ route('admin.buku.index') }}">Data Buku</a>
        <span> / Tambah Buku</span>
    </div>
</div>

<div class="content-panel">
    <h2 style="font-size: 1.2rem; font-weight: 700; color: #222; margin-top: 0; margin-bottom: 24px;">Tambah Buku Baru</h2>
    
    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            {{-- Kiri --}}
            <div>
                <div class="form-group">
                    <label>Judul Buku <span class="required">*</span></label>
                    <input type="text" name="title" required value="{{ old('title') }}" placeholder="">
                </div>
                <div class="form-group">
                    <label>ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}" placeholder="">
                </div>
                <div class="form-group">
                    <label>Stok <span class="required">*</span></label>
                    <input type="number" name="stock" min="0" required value="{{ old('stock', '') }}" placeholder="">
                </div>
                <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="author" value="{{ old('author') }}" placeholder="">
                </div>
                <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" name="publisher" value="{{ old('publisher') }}" placeholder="">
                </div>
                <div class="form-group">
                    <label>Jumlah Halaman</label>
                    <input type="number" name="pages" min="1" value="{{ old('pages') }}" placeholder="">
                </div>
                <div class="form-group">
                    <label>Lokasi Rak</label>
                    <input type="text" name="location" value="{{ old('location') }}" placeholder="">
                </div>
            </div>

            {{-- Kanan --}}
            <div>
                <div class="form-group">
                    <label>Kategori <span class="required">*</span></label>
                    <div class="kategori-box" id="tambahKategoriBox">
                        @foreach($categories as $cat)
                            <button type="button" class="kat-btn"
                                data-id="{{ $cat->id }}"
                                onclick="toggleKat(this)">
                                {{ $cat->name }}
                            </button>
                        @endforeach
                    </div>
                    <div id="tambahKatInputs"></div>
                    <div class="kat-hint">Klik untuk memilih kategori !</div>
                </div>
                <div class="form-group">
                    <label>Sampul Buku</label>
                    <div class="file-input-wrap">
                        <input type="file" name="cover" accept="image/*">
                    </div>
                </div>
                <div class="form-group">
                    <label>Series Buku</label>
                    <select name="book_series_id">
                        <option value="">-- Tidak Ada --</option>
                        @foreach($series as $s)
                            <option value="{{ $s->id }}" {{ old('book_series_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-group" style="grid-column: 1 / -1;">
                <label>Sinopsis</label>
                <textarea name="sinopsis" rows="5" placeholder="Masukkan sinopsis buku (opsional)" style="resize: vertical; min-height: 120px;">{{ old('sinopsis') }}</textarea>
            </div>
        </div>

        <div class="footer-actions">
            <a href="{{ route('admin.buku.index') }}" class="btn-batal">Batal</a>
            <button type="submit" class="btn-simpan">Simpan</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function toggleKat(btn) {
        btn.classList.toggle('selected');
        syncKatInputs();
    }

    function syncKatInputs() {
        const box    = document.getElementById('tambahKategoriBox');
        const wrap   = document.getElementById('tambahKatInputs');
        wrap.innerHTML = '';
        box.querySelectorAll('.kat-btn.selected').forEach(btn => {
            const inp = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'category_ids[]';
            inp.value = btn.dataset.id;
            wrap.appendChild(inp);
        });
    }

    // Recover old categories selection if any
    document.addEventListener('DOMContentLoaded', () => {
        const oldCatsStr = '{!! addslashes(json_encode(old("category_ids", []))) !!}';
        const oldCats = oldCatsStr ? JSON.parse(oldCatsStr) : [];
        if(oldCats && Array.isArray(oldCats)) {
            const box = document.getElementById('tambahKategoriBox');
            oldCats.forEach(id => {
                const btn = box.querySelector(`.kat-btn[data-id="${id}"]`);
                if(btn) btn.classList.add('selected');
            });
            syncKatInputs();
        }
    });
</script>
@endpush

@endsection
