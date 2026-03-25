@extends('layouts.siswa')

@section('title', $book->title . ' - Detail Buku')

@push('styles')
<style>
    /* ===== PAGE HEADER / BREADCRUMB ===== */
    .breadcrumb-row {
        display: flex; align-items: center; gap: 6px;
        font-size: 0.8rem; color: #94a3b8; margin-bottom: 20px;
    }
    .breadcrumb-row a { color: #4361ee; text-decoration: none; font-weight: 600; }
    .breadcrumb-row a:hover { text-decoration: underline; }
    .breadcrumb-row span { color: #cbd5e1; }
    .breadcrumb-row .current { color: #475569; font-weight: 600; }

    /* ===== MAIN CARD ===== */
    .detail-card {
        background: #fff;
        border-radius: 16px;
        padding: 28px;
        display: flex;
        gap: 32px;
        margin-bottom: 28px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }

    /* ===== LEFT COLUMN: COVER + ACTIONS ===== */
    .detail-left {
        flex-shrink: 0;
        width: 210px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }
    .book-cover-box {
        width: 190px; height: 260px;
        border-radius: 10px;
        background: #cfe5d5;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,0.10);
    }
    .book-cover-box img { width: 100%; height: 100%; object-fit: cover; }

    .stock-badge {
        display: flex; align-items: center; gap: 6px;
        font-size: 0.78rem; font-weight: 700;
        color: #16a34a;
    }
    .stock-badge .dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: #22c55e;
    }
    .stock-badge.habis { color: #dc2626; }
    .stock-badge.habis .dot { background: #ef4444; }

    .btn-koleksi {
        width: 100%; padding: 10px;
        border: 1.5px solid #e2e8f0;
        border-radius: 9999px;
        background: #fff; color: #475569;
        font-size: 0.82rem; font-weight: 700;
        cursor: pointer; font-family: inherit;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        transition: all 0.2s;
    }
    .btn-koleksi:hover { border-color: #4361ee; color: #4361ee; }
    .btn-koleksi.active { border-color: #ef4444; color: #ef4444; }

    /* Durasi Slider */
    .durasi-wrap { width: 100%; }
    .durasi-label { font-size: 0.72rem; font-weight: 700; color: #64748b; margin-bottom: 4px; display: flex; justify-content: space-between; }
    .durasi-label span { color: #4361ee; }
    .durasi-slider {
        width: 100%; accent-color: #4361ee;
        cursor: pointer; height: 4px;
    }
    .durasi-info {
        display: flex; justify-content: space-between;
        font-size: 0.68rem; color: #94a3b8; margin-top: 4px;
    }
    .tanggal-info { font-size: 0.75rem; color: #475569; }
    .tanggal-info .row { display: flex; justify-content: space-between; padding: 4px 0; border-bottom: 1px solid #f1f5f9; }
    .tanggal-info .row:last-child { border-bottom: none; }
    .tanggal-info .label { color: #94a3b8; }
    .tanggal-info .val { font-weight: 700; }

    .btn-pinjam {
        width: 100%; padding: 12px;
        background: #4361ee;
        color: #fff; border: none; border-radius: 10px;
        font-size: 0.88rem; font-weight: 700;
        cursor: pointer; font-family: inherit;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        transition: background 0.2s, transform 0.15s;
    }
    .btn-pinjam:hover { background: #3a56d4; transform: translateY(-1px); }
    .btn-pinjam:disabled { background: #94a3b8; cursor: not-allowed; transform: none; }

    /* ===== RIGHT COLUMN: BOOK INFO ===== */
    .detail-right { flex: 1; min-width: 0; }

    .book-kategori-tag {
        display: inline-block;
        background: #f0fdf4; color: #16a34a;
        border: 1px solid #bbf7d0;
        border-radius: 6px; padding: 3px 10px;
        font-size: 0.72rem; font-weight: 800;
        text-transform: uppercase; letter-spacing: 0.5px;
        margin-bottom: 10px;
    }
    .book-title-main { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin-bottom: 4px; line-height: 1.2; }
    .book-author-main { font-size: 0.95rem; color: #4361ee; font-weight: 600; margin-bottom: 20px; }

    .meta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 14px 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 20px;
    }
    .meta-item .meta-label { font-size: 0.65rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 3px; }
    .meta-item .meta-val { font-size: 0.85rem; font-weight: 700; color: #334155; }
    .meta-item .meta-val a { color: #4361ee; text-decoration: none; }

    .sinopsis-heading { font-size: 0.85rem; font-weight: 800; color: #1e293b; margin-bottom: 8px; }
    .sinopsis-text { font-size: 0.88rem; color: #64748b; line-height: 1.75; }

    /* ===== REVIEWS SECTION ===== */
    .reviews-section {
        background: #fff;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }
    .reviews-heading { font-size: 1.2rem; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
    .reviews-sub { font-size: 0.82rem; color: #94a3b8; margin-bottom: 24px; }

    .reviews-layout { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
    @media (max-width: 900px) { .reviews-layout { grid-template-columns: 1fr; } }

    /* Write review card */
    .write-review-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 22px;
    }
    .write-review-title { font-size: 0.95rem; font-weight: 800; color: #1e293b; margin-bottom: 2px; }
    .write-review-sub { font-size: 0.75rem; color: #94a3b8; margin-bottom: 16px; }

    .star-label { font-size: 0.65rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .stars { display: flex; gap: 4px; margin-bottom: 16px; }
    .stars input[type="radio"] { display: none; }
    .stars label {
        cursor: pointer;
        font-size: 1.6rem;
        color: #d1d5db;
        transition: color 0.15s;
    }
    .stars input[type="radio"]:checked ~ label,
    .stars label:hover,
    .stars label:hover ~ label { color: #d1d5db; }
    .stars input[type="radio"]:checked + label,
    .stars label:hover { color: #f59e0b; }

    /* Fix: custom star rating logic via JS */
    .star-rating { display: flex; flex-direction: row-reverse; gap: 4px; margin-bottom: 16px; }
    .star-rating input { display: none; }
    .star-rating label {
        cursor: pointer; font-size: 1.6rem;
        color: #d1d5db; transition: color 0.15s;
    }
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label { color: #f59e0b; }

    .pesan-label { font-size: 0.65rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px; }
    .pesan-textarea {
        width: 100%; height: 100px;
        border: 1px solid #e2e8f0; border-radius: 8px;
        padding: 10px 14px; font-size: 0.85rem; color: #475569;
        font-family: inherit; resize: vertical; outline: none;
        margin-bottom: 14px;
        transition: border-color 0.2s;
    }
    .pesan-textarea:focus { border-color: #4361ee; }
    .pesan-textarea::placeholder { color: #cbd5e1; }

    .btn-kirim-ulasan {
        width: 100%; padding: 12px;
        background: #4361ee; color: #fff;
        border: none; border-radius: 10px;
        font-size: 0.88rem; font-weight: 700;
        cursor: pointer; font-family: inherit;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: background 0.2s;
    }
    .btn-kirim-ulasan:hover { background: #3a56d4; }

    /* Reviews list */
    .reviews-list { display: flex; flex-direction: column; gap: 16px; }
    .review-empty {
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        padding: 40px 20px; color: #94a3b8; text-align: center;
    }
    .review-empty .bubble {
        width: 54px; height: 54px;
        border-radius: 50%; background: #f1f5f9;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 12px;
    }
    .review-empty strong { color: #64748b; font-size: 0.9rem; display: block; margin-bottom: 4px; }
    .review-empty span { font-size: 0.8rem; }

    .review-item {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 10px; padding: 14px;
    }
    .review-header { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; }
    .review-avatar {
        width: 34px; height: 34px; border-radius: 50%;
        background: linear-gradient(135deg, #4361ee, #6366f1);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 0.75rem; font-weight: 800;
        flex-shrink: 0;
    }
    .review-name { font-size: 0.82rem; font-weight: 700; color: #1e293b; }
    .review-date { font-size: 0.7rem; color: #94a3b8; }
    .review-stars { color: #f59e0b; font-size: 0.85rem; margin-bottom: 6px; }
    .review-pesan { font-size: 0.82rem; color: #475569; line-height: 1.6; }

    /* Alert */
    .alert-success { background: #dcfce7; color: #166534; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 0.88rem; font-weight: 600; }
    .alert-error   { background: #fee2e2; color: #991b1b; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 0.88rem; font-weight: 600; }
    
    /* Responsive */
    @media (max-width: 768px) {
        .detail-card { flex-direction: column; gap: 24px; padding: 20px; }
        .detail-left { width: 100%; align-items: center; }
        .book-cover-box { width: 100%; max-width: 240px; height: auto; aspect-ratio: 3/4; }
        .meta-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 500px) {
        .meta-grid { grid-template-columns: 1fr; }
        .reviews-section { padding: 20px; }
    }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-error">✗ {{ session('error') }}</div>
@endif

{{-- Breadcrumb --}}
<div class="breadcrumb-row">
    <a href="{{ route('siswa.katalog') }}">← Katalog Buku</a>
    <span>/</span>
    <span class="current">{{ Str::limit($book->title, 40) }}</span>
</div>

@if($hasUnpaidFine)
<div style="background:#fff1f2; border:1.5px solid #fecdd3; border-radius:12px; padding:14px 18px; margin-bottom:20px; display:flex; align-items:flex-start; gap:12px;">
    <div style="flex-shrink:0; margin-top:2px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    </div>
    <div>
        <div style="font-size:0.88rem; font-weight:700; color:#991b1b; margin-bottom:2px;">Akun Dibatasi — Ada Tagihan Denda</div>
        <div style="font-size:0.8rem; color:#b91c1c; line-height:1.5;">Kamu tidak dapat meminjam buku baru karena memiliki tagihan denda yang belum dilunasi. Silakan lunasi denda di menu <a href="{{ route('siswa.riwayat') }}" style="font-weight:700; color:#b91c1c; text-decoration:underline;">Riwayat &amp; Denda</a>.</div>
    </div>
</div>
@endif

@if($activeCount >= 5)
<div style="background:#fffbeb; border:1.5px solid #fde68a; border-radius:12px; padding:14px 18px; margin-bottom:20px; display:flex; align-items:flex-start; gap:12px;">
    <div style="flex-shrink:0; margin-top:2px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    </div>
    <div>
        <div style="font-size:0.88rem; font-weight:700; color:#92400e; margin-bottom:2px;">Batas Pinjaman Aktif Tercapai (5/5)</div>
        <div style="font-size:0.8rem; color:#b45309; line-height:1.5;">Kamu sudah memiliki 5 pinjaman aktif. Kembalikan salah satu buku terlebih dahulu untuk bisa meminjam buku baru.</div>
    </div>
</div>
@endif

{{-- Main Detail Card --}}
<div class="detail-card">
    {{-- Left: Cover + Actions --}}
    <div class="detail-left">
        {{-- Cover --}}
        <div class="book-cover-box">
            @if($book->cover)
                <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div style="display:none; align-items:center; justify-content:center; color:#84a98c; width:100%; height:100%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
            @else
                <div style="display:flex; align-items:center; justify-content:center; color:#84a98c; width:100%; height:100%;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
            @endif
        </div>

        {{-- Stock Badge --}}
        @if($book->stock > 0)
            <div class="stock-badge">
                <div class="dot"></div>
                Tersedia · {{ $book->stock }} stok
            </div>
        @else
            <div class="stock-badge habis">
                <div class="dot"></div>
                Stok Habis
            </div>
        @endif

        {{-- Tambah ke Koleksi --}}
        <form id="favForm" action="{{ route('siswa.favorite.toggle', $book->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-koleksi {{ $isFav ? 'active' : '' }}" id="favBtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="{{ $isFav ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
                {{ $isFav ? 'Hapus dari Koleksi' : 'Tambah ke Koleksi' }}
            </button>
        </form>

        {{-- Durasi Pinjam Slider --}}
        <div class="durasi-wrap">
            <div class="durasi-label">
                Durasi: <span id="durasiVal">7</span> hari &nbsp; Maks. 14 hari
            </div>
            <input type="range" min="1" max="14" value="7" class="durasi-slider" id="durasiSlider">
            <div class="durasi-info">
                <span>1 hari</span>
                <span>14 hari</span>
            </div>
        </div>

        {{-- Tanggal Info --}}
        <div class="tanggal-info" style="width:100%;">
            <div class="row">
                <span class="label">Pinjam:</span>
                <span class="val" id="tglPinjam">{{ now()->format('d M Y') }}</span>
            </div>
            <div class="row">
                <span class="label">Jatuh tempo:</span>
                <span class="val" id="tglTempo">{{ now()->addDays(7)->format('d M Y') }}</span>
            </div>
        </div>

        {{-- Tombol Pinjam --}}
        @if($book->stock > 0 && !$hasUnpaidFine && $activeCount < 5)
            <button class="btn-pinjam" id="pinjamBtn" onclick="doPinjam('{{ $book->id }}', '{{ addslashes($book->title) }}')">
                + Pinjam Buku Sekarang
            </button>
        @elseif($book->stock < 1)
            <button class="btn-pinjam" disabled>
                Stok Habis
            </button>
        @elseif($hasUnpaidFine)
            <button class="btn-pinjam" disabled title="Lunasi denda terlebih dahulu">
                Ada Tagihan Denda
            </button>
        @else
            <button class="btn-pinjam" disabled title="Batas 5 pinjaman aktif tercapai">
                Batas Pinjaman Tercapai
            </button>
        @endif
    </div>

    {{-- Right: Book Info --}}
    <div class="detail-right">
        <span class="book-kategori-tag">{{ $book->category->name ?? 'Umum' }}</span>
        <h1 class="book-title-main">{{ $book->title }}</h1>
        <p class="book-author-main">{{ $book->author }}</p>

        {{-- Meta Grid --}}
        <div class="meta-grid">
            <div class="meta-item">
                <div class="meta-label">ISBN</div>
                <div class="meta-val">{{ $book->isbn ?? '-' }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Penerbit</div>
                <div class="meta-val">{{ $book->publisher ?? '-' }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Lokasi Rak</div>
                <div class="meta-val">{{ $book->location ?? '-' }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Tahun Terbit</div>
                <div class="meta-val">{{ $book->year ?? '-' }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Jumlah Halaman</div>
                <div class="meta-val">{{ $book->pages ? $book->pages . ' hal.' : '-' }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Rating</div>
                <div class="meta-val">
                    @if($avgRating)
                        ⭐ {{ number_format($avgRating, 1) }} / 5
                    @else
                        Belum ada rating
                    @endif
                </div>
            </div>
        </div>

        {{-- Sinopsis --}}
        <div class="sinopsis-heading">Sinopsis</div>
        <p class="sinopsis-text">
            {{ $book->sinopsis ?? 'Tidak ada sinopsis tersedia untuk buku ini.' }}
        </p>
    </div>
</div>

{{-- Ulasan & Rating Section --}}
<div class="reviews-section">
    <h2 class="reviews-heading">Ulasan & Rating</h2>
    <p class="reviews-sub">Apa kata mereka tentang <a href="#" style="color:#4361ee;">buku ini?</a></p>

    <div class="reviews-layout">
        {{-- Tulis Ulasan --}}
        @if($hasBorrowed)
        <div class="write-review-card">
            <div class="write-review-title">Tulis Ulasan</div>
            <div class="write-review-sub">Bagikan pendapat Anda</div>

            <form action="{{ route('siswa.katalog.review', $book->id) }}" method="POST">
                @csrf
                <div class="star-label">RATING ANDA</div>
                <div class="star-rating">
                    @for($i = 5; $i >= 1; $i--)
                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                            {{ ($myReview && $myReview->rating == $i) ? 'checked' : '' }}>
                        <label for="star{{ $i }}">★</label>
                    @endfor
                </div>

                <div class="pesan-label">PESAN ULASAN</div>
                <textarea name="pesan" class="pesan-textarea" placeholder="Apa yang Anda suka dari buku ini?">{{ $myReview->pesan ?? '' }}</textarea>

                <button type="submit" class="btn-kirim-ulasan">
                    Kirim Ulasan →
                </button>
            </form>
        </div>
        @else
        <div class="write-review-card" style="display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding: 40px 20px;">
            <div style="width:48px;height:48px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin-bottom:12px;color:#94a3b8;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div class="write-review-title">Belum Bisa Mengulas</div>
            <div class="write-review-sub" style="margin-bottom:0;">Anda harus meminjam buku ini terlebih dahulu sebelum dapat memberikan ulasan.</div>
        </div>
        @endif

        {{-- Daftar Ulasan --}}
        <div class="reviews-list">
            @forelse ($reviews as $rev)
            <div class="review-item">
                <div class="review-header">
                    <div class="review-avatar">{{ strtoupper(substr($rev->user->name ?? 'U', 0, 2)) }}</div>
                    <div>
                        <div class="review-name">{{ $rev->user->name ?? 'Pengguna' }}</div>
                        <div class="review-date">{{ $rev->created_at->format('d M Y') }}</div>
                    </div>
                </div>
                <div class="review-stars">
                    @for($i=1; $i<=5; $i++)
                        {{ $i <= $rev->rating ? '★' : '☆' }}
                    @endfor
                </div>
                @if($rev->pesan)
                    <div class="review-pesan">{{ $rev->pesan }}</div>
                @endif
            </div>
            @empty
            <div class="review-empty">
                <div class="bubble">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <strong>Belum ada ulasan.</strong>
                <span>Berikan ulasan pertama untuk buku ini!</span>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Modal Kode Booking --}}
<div class="modal-overlay" id="bookingModal" style="position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity 0.25s;">
    <div style="background:#fff;border-radius:20px;padding:32px;width:420px;max-width:92vw;position:relative;box-shadow:0 25px 60px rgba(0,0,0,0.25);transform:scale(0.95);transition:transform 0.25s;" id="bookingBox">
        <div style="width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#e0e7ff,#c7d2fe);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#4361ee" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12l5 5L20 7"/></svg>
        </div>
        <p style="font-size:1.25rem;font-weight:800;color:#1e293b;margin-bottom:6px;text-align:center;">Booking Berhasil! 🎉</p>
        <p style="font-size:0.9rem;color:#64748b;margin-bottom:20px;text-align:center;" id="modalStatus">Kode booking berhasil dibuat!</p>
        <div style="font-size:0.95rem;color:#334155;font-weight:700;background:#f8fafc;border-radius:10px;padding:12px;border:1px solid #e2e8f0;margin-bottom:16px;text-align:center;" id="modalBookTitle">—</div>
        <div style="background:linear-gradient(135deg,#4361ee,#3a56d4);border-radius:14px;padding:24px;margin-bottom:24px;text-align:center;">
            <div style="font-size:0.7rem;font-weight:700;color:rgba(255,255,255,0.8);margin-bottom:8px;letter-spacing:1px;">KODE BOOKING ANDA</div>
            <div style="font-family:'Courier New',monospace;font-size:2rem;font-weight:800;color:#fff;letter-spacing:4px;" id="modalBookCode">—</div>
        </div>
        <div style="display:flex;gap:8px;">
            <button onclick="copyCode()" style="flex:1;background:#4361ee;color:#fff;border:none;border-radius:10px;padding:12px;font-size:0.88rem;font-weight:700;cursor:pointer;">📋 Salin Kode</button>
            <button onclick="closeBookingModal()" style="background:#f1f5f9;color:#475569;border:none;border-radius:10px;padding:12px 16px;font-weight:700;cursor:pointer;">Tutup</button>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Pinjam --}}
<div class="modal-overlay" id="confirmPinjamModal" style="position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity 0.25s;">
    <div style="background:#fff;border-radius:20px;padding:32px;width:400px;max-width:92vw;position:relative;box-shadow:0 25px 60px rgba(0,0,0,0.25);transform:scale(0.95);transition:transform 0.25s;" id="confirmPinjamBox">
        <div style="width:60px;height:60px;border-radius:50%;background:#fef3c7;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#d97706" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
        </div>
        <p style="font-size:1.25rem;font-weight:800;color:#1e293b;margin-bottom:6px;text-align:center;">Konfirmasi Pinjaman</p>
        <p style="font-size:0.9rem;color:#64748b;margin-bottom:20px;text-align:center;">Anda yakin ingin meminjam buku <strong id="confirmBookTitle"></strong> sekarang?</p>
        <div style="display:flex;gap:12px;">
            <button onclick="closeConfirmModal()" style="flex:1;background:#f1f5f9;color:#475569;border:none;border-radius:10px;padding:12px;font-size:0.88rem;font-weight:700;cursor:pointer;transition:background 0.2s;">Batal</button>
            <button id="btnProceedPinjam" style="flex:1;background:#4361ee;color:#fff;border:none;border-radius:10px;padding:12px;font-size:0.88rem;font-weight:700;cursor:pointer;transition:background 0.2s;">Ya, Pinjam</button>
        </div>
    </div>
</div>

{{-- Modal Error / Pembatasan --}}
<div id="errorModal" style="position:fixed;inset:0;z-index:10000;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity 0.25s;">
    <div id="errorBox" style="background:#fff;border-radius:20px;padding:32px;width:420px;max-width:92vw;position:relative;box-shadow:0 25px 60px rgba(0,0,0,0.25);transform:scale(0.95);transition:transform 0.25s;text-align:center;">
        <div style="width:60px;height:60px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#dc2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
        </div>
        <p style="font-size:1.1rem;font-weight:800;color:#1e293b;margin-bottom:8px;">Tidak Dapat Meminjam</p>
        <p id="errorModalMsg" style="font-size:0.88rem;color:#64748b;margin-bottom:20px;line-height:1.6;"></p>
        <div style="display:flex;gap:8px;justify-content:center;">
            <a href="{{ route('siswa.riwayat') }}" style="flex:1;background:#dc2626;color:#fff;border:none;border-radius:10px;padding:12px;font-size:0.88rem;font-weight:700;cursor:pointer;text-decoration:none;display:flex;align-items:center;justify-content:center;">Lunasi Denda</a>
            <button onclick="closeErrorModal()" style="flex:1;background:#f1f5f9;color:#475569;border:none;border-radius:10px;padding:12px;font-size:0.88rem;font-weight:700;cursor:pointer;">Tutup</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// === Durasi Slider ===
const slider = document.getElementById('durasiSlider');
const durasiVal = document.getElementById('durasiVal');
const tglPinjam = document.getElementById('tglPinjam');
const tglTempo  = document.getElementById('tglTempo');

function updateDurasi() {
    const days = parseInt(slider.value);
    durasiVal.textContent = days;

    const today = new Date();
    const tempo  = new Date(today);
    tempo.setDate(today.getDate() + days);

    const opts = { day: '2-digit', month: 'short', year: 'numeric' };
    tglPinjam.textContent = today.toLocaleDateString('id-ID', opts);
    tglTempo.textContent  = tempo.toLocaleDateString('id-ID', opts);
}

slider?.addEventListener('input', updateDurasi);
updateDurasi();

// === Pinjam via AJAX ===
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '';

function doPinjam(bookId, bookTitle) {
    window.pendingBookId = bookId;
    window.pendingBookTitle = bookTitle;
    
    document.getElementById('confirmBookTitle').textContent = '"' + bookTitle + '"';
    const modal = document.getElementById('confirmPinjamModal');
    const box   = document.getElementById('confirmPinjamBox');
    modal.style.opacity = '1';
    modal.style.pointerEvents = 'all';
    box.style.transform = 'scale(1)';
    document.body.style.overflow = 'hidden';
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmPinjamModal');
    const box   = document.getElementById('confirmPinjamBox');
    modal.style.opacity = '0';
    modal.style.pointerEvents = 'none';
    box.style.transform = 'scale(0.95)';
    document.body.style.overflow = '';
}

document.getElementById('btnProceedPinjam').addEventListener('click', function() {
    closeConfirmModal();
    if (!window.pendingBookId) return;

    const durasi = document.getElementById('durasiSlider')?.value || 7;

    fetch(`/siswa/pinjam/${window.pendingBookId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ durasi: durasi })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showBookingModal(data.booking_code, data.book_title, false);
        } else {
            if (data.booking_code) {
                showBookingModal(data.booking_code, window.pendingBookTitle, true);
            } else {
                showErrorModal(data.message);
            }
        }
    })
    .catch(() => alert('Terjadi kesalahan. Silakan coba lagi.'));
});

function showBookingModal(code, title, isExisting = false) {
    document.getElementById('modalBookTitle').textContent = title;
    document.getElementById('modalBookCode').textContent  = code;
    document.getElementById('modalStatus').textContent    = isExisting
        ? 'Kamu sudah memiliki booking aktif untuk buku ini.'
        : 'Kode booking berhasil dibuat!';
    const modal = document.getElementById('bookingModal');
    const box   = document.getElementById('bookingBox');
    modal.style.opacity = '1';
    modal.style.pointerEvents = 'all';
    box.style.transform = 'scale(1)';
    document.body.style.overflow = 'hidden';
}

function closeBookingModal() {
    const modal = document.getElementById('bookingModal');
    const box   = document.getElementById('bookingBox');
    modal.style.opacity = '0';
    modal.style.pointerEvents = 'none';
    box.style.transform = 'scale(0.95)';
    document.body.style.overflow = '';
}

function copyCode() {
    const code = document.getElementById('modalBookCode').textContent;
    navigator.clipboard.writeText(code).then(() => {
        const btn = document.querySelector('#bookingModal button');
        const orig = btn.textContent;
        btn.textContent = '✓ Tersalin!';
        btn.style.background = '#22c55e';
        setTimeout(() => { btn.textContent = orig; btn.style.background = ''; }, 2000);
    });
}
function showErrorModal(message) {
    document.getElementById('errorModalMsg').textContent = message;
    const modal = document.getElementById('errorModal');
    const box   = document.getElementById('errorBox');
    modal.style.opacity = '1';
    modal.style.pointerEvents = 'all';
    box.style.transform = 'scale(1)';
    document.body.style.overflow = 'hidden';
}

function closeErrorModal() {
    const modal = document.getElementById('errorModal');
    const box   = document.getElementById('errorBox');
    modal.style.opacity = '0';
    modal.style.pointerEvents = 'none';
    box.style.transform = 'scale(0.95)';
    document.body.style.overflow = '';
}
</script>
@endpush
