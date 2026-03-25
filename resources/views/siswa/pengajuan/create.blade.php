@extends('layouts.siswa')

@section('title', 'Usulkan Buku Baru')

@push('styles')
<style>
    /* ── Layout ── */
    .usul-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 22px;
        align-items: start;
    }
    @media (max-width: 900px) { .usul-grid { grid-template-columns: 1fr; } }

    /* ── Header Banner ── */
    .usul-banner {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        border-radius: 16px;
        padding: 22px 24px;
        display: flex; align-items: center; gap: 18px;
        color: #fff;
        box-shadow: 0 6px 20px rgba(67,97,238,0.25);
        margin-bottom: 22px;
    }
    .usul-banner-icon {
        width: 52px; height: 52px; border-radius: 14px;
        background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        backdrop-filter: blur(4px);
    }
    .usul-banner h1 { font-size: 1.2rem; font-weight: 800; margin: 0 0 3px; }
    .usul-banner p  { font-size: 0.82rem; opacity: 0.85; margin: 0; }

    /* ── Cards ── */
    .usul-card {
        background: #fff; border-radius: 16px;
        border: 1px solid #e8e8e8;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .usul-card-body { padding: 22px; }
    .usul-card-hdr {
        padding: 18px 22px 14px;
        border-bottom: 1px solid #f0f0f0;
    }
    .usul-card-hdr h2 { font-size: 0.95rem; font-weight: 800; color: #1a1a2e; margin: 0 0 3px; }
    .usul-card-hdr p  { font-size: 0.78rem; color: #94a3b8; margin: 0; }

    /* ── Form Elements ── */
    .form-group { margin-bottom: 18px; }
    .form-group:last-child { margin-bottom: 0; }
    .form-group label {
        display: block; font-size: 0.8rem; font-weight: 700;
        color: #334155; margin-bottom: 7px;
    }
    .form-group label .opt {
        font-weight: 400; color: #94a3b8; font-size: 0.75rem;
    }
    .form-group label .req { color: #ef4444; }

    .form-control {
        width: 100%; padding: 10px 13px;
        border: 1.5px solid #e0e0e0; border-radius: 9px;
        font-size: 0.86rem; color: #1a1a2e; font-family: inherit;
        background: #fff; transition: border-color 0.15s;
        box-sizing: border-box;
    }
    .form-control::placeholder { color: #c0c8d8; }
    .form-control:focus { outline: none; border-color: #4361ee; box-shadow: 0 0 0 3px rgba(67,97,238,0.1); }
    .form-control.is-invalid { border-color: #ef4444; }
    .form-control[readonly] { background: #f8fafc; color: #64748b; cursor: default; }
    .invalid-feedback { font-size: 0.75rem; color: #ef4444; margin-top: 4px; }

    textarea.form-control { resize: vertical; min-height: 130px; }

    .form-row {
        display: grid; grid-template-columns: 1fr 1fr; gap: 16px;
    }
    @media (max-width: 600px) { .form-row { grid-template-columns: 1fr; } }

    /* ── Right column ── */
    .usul-right { display: flex; flex-direction: column; gap: 16px; }

    /* Submit area */
    .usul-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding-top: 18px; margin-top: 4px;
        border-top: 1px solid #f0f0f0;
    }
    .usul-footer .note { font-size: 0.75rem; color: #94a3b8; }
    .usul-footer .note span { color: #ef4444; }

    .btn-submit {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        color: #fff; border: none; border-radius: 10px;
        padding: 11px 22px; font-size: 0.85rem; font-weight: 700;
        cursor: pointer; font-family: inherit;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(67,97,238,0.3);
    }
    .btn-submit:hover { background: linear-gradient(135deg, #3a56d4, #2f49c0); box-shadow: 0 6px 18px rgba(67,97,238,0.4); }
    .btn-submit:active { transform: scale(0.97); }

    @media (max-width: 500px) {
        .usul-banner { flex-direction: column; text-align: center; gap: 12px; }
        .usul-footer { flex-direction: column; gap: 12px; align-items: flex-start; }
        .btn-submit { width: 100%; justify-content: center; }
    }

    /* Info note */
    .usul-info {
        background: #eff6ff; border: 1px solid #bfdbfe;
        border-radius: 12px; padding: 16px 18px;
        display: flex; align-items: flex-start; gap: 12px;
        font-size: 0.8rem; color: #1d4ed8; line-height: 1.5;
    }
    .usul-info svg { flex-shrink: 0; color: #3b82f6; margin-top: 1px; }

    /* Alert success */
    .alert-success {
        display: flex; align-items: center; gap: 10px;
        background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px;
        padding: 12px 16px; margin-bottom: 20px;
        font-size: 0.85rem; color: #16a34a; font-weight: 500;
    }
</style>
@endpush

@section('content')

@if(session('success'))
<div class="alert-success">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('siswa.pengajuan.store') }}">
@csrf

{{-- ── Left column ── --}}
<div class="usul-grid">
<div>
    {{-- Banner --}}
    <div class="usul-banner">
        <div class="usul-banner-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="white" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5v-15A2.5 2.5 0 016.5 2H20v20H6.5a2.5 2.5 0 010-5H20"/>
            </svg>
        </div>
        <div>
            <h1>Usulkan Buku Baru</h1>
            <p>Bantu kembangkan koleksi perpustakaan</p>
        </div>
    </div>

    {{-- Informasi Buku --}}
    <div class="usul-card">
        <div class="usul-card-hdr">
            <h2>Informasi Buku</h2>
            <p>Detail buku yang ingin Anda usulkan</p>
        </div>
        <div class="usul-card-body">
            {{-- Judul Buku --}}
            <div class="form-group">
                <label>Judul Buku <span class="req">*</span></label>
                <input type="text" name="judul_buku" class="form-control {{ $errors->has('judul_buku') ? 'is-invalid' : '' }}"
                    placeholder=""
                    value="{{ old('judul_buku') }}" required>
                @error('judul_buku') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Nama Penulis --}}
            <div class="form-group">
                <label>Nama Penulis / Pengarang <span class="req">*</span></label>
                <input type="text" name="penulis" class="form-control {{ $errors->has('penulis') ? 'is-invalid' : '' }}"
                    placeholder=""
                    value="{{ old('penulis') }}" required>
                @error('penulis') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- ISBN & Penerbit --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Nomor ISBN <span class="opt">(opsional)</span></label>
                    <input type="text" name="isbn" class="form-control {{ $errors->has('isbn') ? 'is-invalid' : '' }}"
                        placeholder=""
                        value="{{ old('isbn') }}">
                    @error('isbn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Penerbit <span class="opt">(opsional)</span></label>
                    <input type="text" name="penerbit" class="form-control {{ $errors->has('penerbit') ? 'is-invalid' : '' }}"
                        placeholder=""
                        value="{{ old('penerbit') }}">
                    @error('penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Tahun & Kategori --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Tahun Terbit <span class="opt">(opsional)</span></label>
                    <input type="number" name="tahun_terbit" class="form-control {{ $errors->has('tahun_terbit') ? 'is-invalid' : '' }}"
                        placeholder=""
                        value="{{ old('tahun_terbit') }}" min="1900" max="{{ date('Y') + 1 }}">
                    @error('tahun_terbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label>Kategori <span class="opt">(opsional)</span></label>
                    <select name="category_id" class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                        <option value="">Pilih Kategori...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Right column ── --}}
<div class="usul-right">

    {{-- Informasi Pengusul --}}
    <div class="usul-card">
        <div class="usul-card-hdr">
            <h2>Informasi Pengusul</h2>
            <p>Data diri dan alasan pengusulan</p>
        </div>
        <div class="usul-card-body">
            {{-- Nama --}}
            <div class="form-group">
                <label>Nama Lengkap Pengusul <span class="req">*</span></label>
                <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
            </div>

            {{-- Alasan --}}
            <div class="form-group">
                <label>Alasan Pengusulan <span class="req">*</span></label>
                <textarea name="alasan" class="form-control {{ $errors->has('alasan') ? 'is-invalid' : '' }}"
                    placeholder="Jelaskan mengapa buku ini perlu diadakan di perpustakaan..." required>{{ old('alasan') }}</textarea>
                <div style="font-size:0.73rem;color:#94a3b8;margin-top:5px;">Minimal 10 karakter</div>
                @error('alasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Footer --}}
            <div class="usul-footer">
                <span class="note"><span>*</span> Wajib diisi</span>
                <button type="submit" class="btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <line x1="22" y1="2" x2="11" y2="13"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                    </svg>
                    Kirim Pengajuan
                </button>
            </div>
        </div>
    </div>

    {{-- Info note --}}
    <div class="usul-info">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="16" x2="12" y2="12"/>
            <line x1="12" y1="8" x2="12.01" y2="8"/>
        </svg>
        Pengajuan Anda akan ditinjau oleh admin perpustakaan. Proses review biasanya membutuhkan 1–3 hari kerja.
    </div>

</div>
</div>

</form>
@endsection
