@extends('layouts.siswa')

@section('title', 'Katalog Buku')

@push('styles')
<style>
    /* ===== LAYOUT KATALOG ===== */
    .katalog-layout {
        display: grid;
        grid-template-columns: 1fr 230px;
        gap: 20px;
        align-items: start;
    }

    /* Breadcrumb */
    .breadcrumb {
        font-size: 0.8rem; color: #4361ee;
        margin-bottom: 14px;
    }
    .breadcrumb span { color: #888; }

    /* ===== SEARCH BAR ===== */
    .search-section {
        background: #fff; border-radius: 12px;
        padding: 14px 16px; margin-bottom: 14px;
        border: 1px solid #eee;
    }
    .search-title {
        font-size: 1.1rem; font-weight: 700;
        color: #1a1a2e; margin: 0 0 10px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .search-nav-btns { display: flex; gap: 4px; }
    .search-nav-btns button {
        width: 26px; height: 26px; border: 1px solid #ddd;
        border-radius: 50%; background: #fff; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem; color: #666; transition: all 0.15s;
    }
    .search-nav-btns button:hover { background: #f0f3ff; border-color: #4361ee; color: #4361ee; }

    .search-input-wrap {
        display: flex; align-items: center; gap: 10px;
        border: 1px solid #e0e0e0; border-radius: 8px;
        padding: 9px 14px;
    }
    .search-input-wrap svg { color: #bbb; flex-shrink: 0; }
    .search-input-wrap input {
        flex: 1; border: none; outline: none;
        font-size: 0.88rem; color: #444; font-family: inherit;
        background: transparent;
    }

    /* ===== FILTER BAR ===== */
    .filter-bar {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 14px; flex-wrap: wrap;
    }
    .filter-btn {
        display: flex; align-items: center; gap: 5px;
        padding: 6px 12px; border: 1px solid #ddd;
        border-radius: 6px; background: #fff;
        font-size: 0.78rem; font-weight: 500; color: #555;
        cursor: pointer; font-family: inherit; transition: all 0.15s;
        text-decoration: none;
    }
    .filter-btn:hover { background: #f0f3ff; border-color: #4361ee; color: #4361ee; }
    .filter-btn.primary { background: #4361ee; color: #fff; border-color: #4361ee; }
    .filter-btn.primary:hover { background: #3a56d4; }
    .filter-sort { display: flex; gap: 4px; margin-left: auto; }

    /* ===== BOOK GRID ===== */
    .book-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
    }

    .book-card {
        cursor: pointer;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.15s, box-shadow 0.15s;
        position: relative;
        background: #f8f8f8;
    }
    .book-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.12); }
    .book-card.selected { box-shadow: 0 0 0 2px #4361ee, 0 4px 16px rgba(67,97,238,0.2); }

    /* Cover */
    .book-cover {
        width: 100%; aspect-ratio: 2/3;
        object-fit: cover; display: block;
    }
    .book-cover-placeholder {
        width: 100%; aspect-ratio: 2/3;
        background: linear-gradient(135deg, #e8ecff 0%, #c7d2fe 100%);
        display: flex; align-items: center; justify-content: center;
        flex-direction: column; gap: 4px;
    }
    .book-cover-placeholder span {
        font-size: 0.6rem; color: #8b9cf4; font-weight: 500;
        text-align: center; padding: 0 4px;
    }

    /* Favorite icon */
    .fav-btn {
        position: absolute; top: 5px; right: 5px;
        width: 22px; height: 22px; border-radius: 50%;
        background: rgba(255,255,255,0.9); border: none;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.15s;
        padding: 0;
    }
    .fav-btn:hover { background: #fff; transform: scale(1.1); }

    /* Book info */
    .book-info {
        padding: 6px 6px 8px;
        background: #fff;
    }
    .book-name {
        font-size: 0.72rem; font-weight: 600; color: #1a1a2e;
        line-height: 1.3; margin-bottom: 2px;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .book-author { font-size: 0.63rem; color: #999; }

    /* Stars */
    .stars { display: flex; gap: 1px; margin-top: 4px; }
    .star { color: #f59e0b; font-size: 0.7rem; }
    .star.empty { color: #ddd; }

    /* ===== DETAIL PANEL (kanan) ===== */
    .detail-panel {
        background: #fff; border-radius: 12px;
        border: 1px solid #eee; overflow: hidden;
        position: sticky; top: 20px;
    }
    .detail-cover-wrap {
        background: #f8f9ff;
        display: flex; align-items: center; justify-content: center;
        padding: 20px;
        border-bottom: 1px solid #f0f0f0;
    }
    .detail-cover {
        width: 110px; height: 160px; object-fit: cover;
        border-radius: 6px; box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    .detail-cover-placeholder {
        width: 110px; height: 160px;
        background: linear-gradient(135deg, #e8ecff, #c7d2fe);
        border-radius: 6px; display: flex; align-items: center;
        justify-content: center; flex-direction: column; gap: 6px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    }
    .detail-cover-placeholder span { font-size: 0.7rem; color: #8b9cf4; font-weight: 500; }

    .detail-info { padding: 16px; }
    .detail-title {
        font-size: 0.95rem; font-weight: 700; color: #1a1a2e;
        margin: 0 0 4px; line-height: 1.3;
    }
    .detail-author { font-size: 0.78rem; color: #888; margin-bottom: 12px; }

    .detail-stars { display: flex; align-items: center; gap: 4px; margin-bottom: 12px; }
    .detail-star { font-size: 1rem; color: #f59e0b; }
    .detail-star.empty { color: #e5e7eb; }
    .detail-rating-num { font-size: 0.82rem; font-weight: 700; color: #333; margin-left: 4px; }

    .detail-stats {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: 8px; margin-bottom: 14px;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        padding: 12px 0;
    }
    .detail-stat { text-align: center; }
    .detail-stat-val { font-size: 0.85rem; font-weight: 700; color: #1a1a2e; }
    .detail-stat-label { font-size: 0.65rem; color: #aaa; margin-top: 1px; }

    .detail-desc {
        font-size: 0.75rem; color: #666; line-height: 1.6;
        margin-bottom: 14px; max-height: 90px; overflow: hidden;
    }

    .detail-actions { display: flex; gap: 8px; }
    .btn-detail-view {
        flex: 1; text-align: center;
        border: 1px solid #ddd; background: #fff; color: #444;
        border-radius: 7px; padding: 8px 0;
        font-size: 0.78rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        text-decoration: none; transition: background 0.15s;
    }
    .btn-detail-view:hover { background: #f5f5f5; }
    .btn-pinjam {
        flex: 1; text-align: center;
        background: #4361ee; color: #fff;
        border: none; border-radius: 7px; padding: 8px 0;
        font-size: 0.78rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        transition: background 0.15s;
    }
    .btn-pinjam:hover { background: #3a56d4; }

    /* Empty state */
    .empty-panel {
        padding: 30px 16px; text-align: center; color: #ccc;
    }
    .empty-panel svg { margin-bottom: 10px; opacity: 0.4; }
    .empty-panel p { font-size: 0.78rem; color: #aaa; margin: 0; }

    /* Alert */
    .alert-success {
        background: #d1fae5; color: #065f46;
        border: 1px solid #a7f3d0; border-radius: 8px;
        padding: 9px 14px; margin-bottom: 12px; font-size: 0.82rem;
    }
    .alert-danger {
        background: #fee2e2; color: #991b1b;
        border: 1px solid #fecaca; border-radius: 8px;
        padding: 9px 14px; margin-bottom: 12px; font-size: 0.82rem;
    }

    /* === MODAL KODE BOOKING === */
    .modal-overlay {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; pointer-events: none; transition: opacity 0.2s;
    }
    .modal-overlay.active { opacity: 1; pointer-events: all; }
    .modal-box {
        background: #fff; border-radius: 20px;
        padding: 32px 28px; width: 360px; max-width: 92vw;
        text-align: center; position: relative;
        box-shadow: 0 20px 60px rgba(0,0,0,0.25);
        transform: scale(0.85); transition: transform 0.25s cubic-bezier(.34,1.56,.64,1);
    }
    .modal-overlay.active .modal-box { transform: scale(1); }
    .modal-icon {
        width: 60px; height: 60px; border-radius: 50%;
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }
    .modal-title { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
    .modal-sub { font-size: 0.8rem; color: #888; margin-bottom: 20px; }
    .modal-book { font-size: 0.82rem; color: #555; font-weight: 600; margin-bottom: 18px;
        background: #f8f9ff; border-radius: 8px; padding: 8px 14px; }
    .modal-code-wrap {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        border-radius: 12px; padding: 18px 20px; margin-bottom: 18px;
    }
    .modal-code-label { font-size: 0.7rem; color: rgba(255,255,255,0.7); margin-bottom: 6px; letter-spacing: 0.08em; }
    .modal-code {
        font-family: 'Courier New', monospace;
        font-size: 1.5rem; font-weight: 800; color: #fff;
        letter-spacing: 0.12em;
    }
    .modal-copy-btn {
        background: #4361ee; color: #fff; border: none;
        border-radius: 8px; padding: 9px 18px;
        font-size: 0.82rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        transition: background 0.15s; margin-right: 8px;
    }
    .modal-copy-btn:hover { background: #3a56d4; }
    .modal-close-btn {
        background: #f5f5f5; color: #555; border: none;
        border-radius: 8px; padding: 9px 18px;
        font-size: 0.82rem; font-weight: 600;
        cursor: pointer; font-family: inherit;
        transition: background 0.15s;
    }
    .modal-close-btn:hover { background: #e8e8e8; }
    .modal-note {
        font-size: 0.73rem; color: #aaa; margin-top: 14px; line-height: 1.5;
    }

    /* Pagination override */
    .pagination-wrap { margin-top: 14px; }
    nav[aria-label="pagination"] { display: flex; justify-content: flex-start; }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb">
    Beranda / <span>Katalog</span>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-danger">✗ {{ session('error') }}</div>
@endif

<div class="katalog-layout">
    {{-- KIRI: Utama --}}
    <div>
        {{-- Search --}}
        <div class="search-section">
            <div class="search-title">
                <span>Cari Buku / Koleksi</span>
                <div class="search-nav-btns">
                    <button>‹</button>
                    <button>›</button>
                </div>
            </div>
            <form method="GET" action="{{ route('siswa.katalog') }}">
                <div class="search-input-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Buku..">
                    {{-- Preserve other filters --}}
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                </div>
            </form>
        </div>

        {{-- Filter bar --}}
        <form method="GET" action="{{ route('siswa.katalog') }}" id="filterForm">
            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
            <div class="filter-bar">
                {{-- Filter Kategori --}}
                <select name="category" onchange="document.getElementById('filterForm').submit()"
                    style="border:1px solid #ddd; border-radius:6px; padding:6px 10px; font-size:0.78rem; font-family:inherit; background:#fff; color:#555; cursor:pointer; outline:none;">
                    <option value="">≡ Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>

                {{-- Sort Judul --}}
                <select name="sort" onchange="document.getElementById('filterForm').submit()"
                    style="border:1px solid #ddd; border-radius:6px; padding:6px 10px; font-size:0.78rem; font-family:inherit; background:#fff; color:#555; cursor:pointer; outline:none;">
                    <option value="title" {{ request('sort','title')=='title' ? 'selected':'' }}>≡ Judul</option>
                    <option value="author" {{ request('sort')=='author' ? 'selected':'' }}>≡ Penulis</option>
                </select>

                {{-- Sort Direction --}}
                <button type="submit" class="filter-btn" title="Urutkan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 6h18M6 12h12M10 18h4"/>
                    </svg>
                </button>

                {{-- Filter button --}}
                <button type="submit" class="filter-btn primary" style="margin-left:auto;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z"/>
                    </svg>
                    Filter
                </button>
            </div>
        </form>

        {{-- Book Grid --}}
        <div class="book-grid">
            @forelse($books as $book)
            <div class="book-card {{ (request('selected') == $book->id) ? 'selected' : '' }}"
                 onclick="selectBook({{ $book->id }})">

                {{-- Favorite button (AJAX toggle) --}}
                @php $isFav = in_array($book->id, $favoritedIds); @endphp
                <button
                    class="fav-btn"
                    id="fav-btn-{{ $book->id }}"
                    onclick="event.stopPropagation(); toggleFav({{ $book->id }}, this)"
                    title="{{ $isFav ? 'Hapus dari favorit' : 'Tambah ke favorit' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                        fill="{{ $isFav ? '#ef4444' : 'none' }}"
                        stroke="{{ $isFav ? '#ef4444' : '#4361ee' }}"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>

                {{-- Cover --}}
                @if($book->cover)
                    <img src="{{ asset('storage/' . $book->cover) }}"
                         alt="{{ $book->title }}"
                         class="book-cover"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="book-cover-placeholder" style="display:none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="#8b9cf4" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                @else
                    <div class="book-cover-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="#8b9cf4" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                        <span>{{ Str::limit($book->title, 20) }}</span>
                    </div>
                @endif

                {{-- Info --}}
                <div class="book-info">
                    <p class="book-name">{{ $book->title }}</p>
                    <p class="book-author">{{ $book->author }}</p>
                    <div class="stars">
                        <span class="star">★</span><span class="star">★</span><span class="star">★</span>
                        <span class="star">★</span><span class="star empty">★</span>
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align:center; padding: 40px; color:#999;">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="#ccc" stroke-width="1.5" viewBox="0 0 24 24" style="margin-bottom:10px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
                <p style="font-size:0.88rem;">Tidak ada buku ditemukan.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrap">
            {{ $books->withQueryString()->links() }}
        </div>
    </div>

    {{-- KANAN: Detail Panel --}}
    <div class="detail-panel" id="detailPanel">
        @if($selected)
        {{-- Cover --}}
        <div class="detail-cover-wrap">
            @if($selected->cover)
                <img src="{{ asset('storage/' . $selected->cover) }}"
                     alt="{{ $selected->title }}" class="detail-cover"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="detail-cover-placeholder" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#8b9cf4" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
            @else
                <div class="detail-cover-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#8b9cf4" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                    <span>No Cover</span>
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div class="detail-info">
            <h3 class="detail-title">{{ $selected->title }}</h3>
            <p class="detail-author">{{ $selected->author }}</p>

            {{-- Stars --}}
            <div class="detail-stars">
                <span class="detail-star">★</span><span class="detail-star">★</span><span class="detail-star">★</span>
                <span class="detail-star">★</span><span class="detail-star empty">★</span>
                <span class="detail-rating-num">4.8</span>
            </div>

            {{-- Stats --}}
            <div class="detail-stats">
                <div class="detail-stat">
                    <div class="detail-stat-val">{{ $selected->stock }}</div>
                    <div class="detail-stat-label">Stok</div>
                </div>
                <div class="detail-stat">
                    <div class="detail-stat-val">{{ $selected->borrowings()->count() }}</div>
                    <div class="detail-stat-label">Dipinjam</div>
                </div>
                <div class="detail-stat">
                    <div class="detail-stat-val">{{ $selected->category->name ?? '-' }}</div>
                    <div class="detail-stat-label">Kategori</div>
                </div>
            </div>

            {{-- Desc --}}
            <p class="detail-desc">
                {{ $selected->publisher ? 'Penerbit: ' . $selected->publisher . '. ' : '' }}
                {{ $selected->isbn ? 'ISBN: ' . $selected->isbn . '. ' : '' }}
                Buku ini tersedia di rak {{ $selected->location ?? 'perpustakaan' }}.
                Stok tersedia: {{ $selected->stock }} buku.
            </p>

            {{-- Actions --}}
            <div class="detail-actions">
                <a href="{{ route('siswa.katalog') }}?selected={{ $selected->id }}" class="btn-detail-view">Tampilkan Detail</a>
                @if($selected->stock > 0)
                <button type="button" class="btn-pinjam" style="flex:1;"
                    onclick="doPinjam({{ $selected->id }}, '{{ addslashes($selected->title) }}')">Pinjam</button>
                @else
                <button class="btn-pinjam" disabled style="opacity:0.5; cursor:not-allowed; flex:1;">Habis</button>
                @endif
            </div>
        </div>

        @else
        {{-- Default state: belum ada yang dipilih --}}
        <div class="empty-panel">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
            </svg>
            <p>Pilih buku untuk<br>melihat detail</p>
        </div>

        {{-- Tampilkan buku pertama secara default jika ada --}}
        @if($books->count() > 0)
        @php $first = $books->first(); @endphp
        {{-- Cover --}}
        <div class="detail-cover-wrap">
            @if($first->cover)
                <img src="{{ asset('storage/' . $first->cover) }}" alt="{{ $first->title }}" class="detail-cover"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="detail-cover-placeholder" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#8b9cf4" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
            @else
                <div class="detail-cover-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#8b9cf4" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                    <span>No Cover</span>
                </div>
            @endif
        </div>
        <div class="detail-info">
            <h3 class="detail-title">{{ $first->title }}</h3>
            <p class="detail-author">{{ $first->author }}</p>
            <div class="detail-stars">
                <span class="detail-star">★</span><span class="detail-star">★</span><span class="detail-star">★</span>
                <span class="detail-star">★</span><span class="detail-star empty">★</span>
                <span class="detail-rating-num">4.8</span>
            </div>
            <div class="detail-stats">
                <div class="detail-stat">
                    <div class="detail-stat-val">{{ $first->stock }}</div>
                    <div class="detail-stat-label">Stok</div>
                </div>
                <div class="detail-stat">
                    <div class="detail-stat-val">{{ $first->borrowings()->count() }}</div>
                    <div class="detail-stat-label">Dipinjam</div>
                </div>
                <div class="detail-stat">
                    <div class="detail-stat-val">{{ $first->category->name ?? '-' }}</div>
                    <div class="detail-stat-label">Kategori</div>
                </div>
            </div>
            <p class="detail-desc">
                {{ $first->publisher ? 'Penerbit: ' . $first->publisher . '. ' : '' }}
                {{ $first->isbn ? 'ISBN: ' . $first->isbn . '. ' : '' }}
                Tersedia di rak {{ $first->location ?? 'perpustakaan' }}. Stok: {{ $first->stock }}.
            </p>
            <div class="detail-actions">
                <a href="#" class="btn-detail-view">Tampilkan Detail</a>
                @if($first->stock > 0)
                <button type="button" class="btn-pinjam" style="flex:1;"
                    onclick="doPinjam({{ $first->id }}, '{{ addslashes($first->title) }}')">Pinjam</button>
                @else
                <button class="btn-pinjam" disabled style="opacity:0.5; flex:1;">Habis</button>
                @endif
            </div>
        </div>
        @endif
    </div>
    @endif
</div>

@push('scripts')
<script>
function selectBook(bookId) {
    const url = new URL(window.location.href);
    url.searchParams.set('selected', bookId);
    window.location.href = url.toString();
}

// Toggle favorit via AJAX (tanpa reload halaman)
function toggleFav(bookId, btn) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
        || '{{ csrf_token() }}';

    fetch(`/siswa/favorite/toggle/${bookId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(res => res.json())
    .then(data => {
        const svg = btn.querySelector('svg');
        if (data.favorited) {
            svg.setAttribute('fill', '#ef4444');
            svg.setAttribute('stroke', '#ef4444');
            btn.title = 'Hapus dari favorit';
            btn.style.transform = 'scale(1.3)';
            setTimeout(() => { btn.style.transform = ''; }, 200);
        } else {
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', '#4361ee');
            btn.title = 'Tambah ke favorit';
        }
    })
    .catch(err => console.error('Gagal toggle favorit:', err));
}

// === PINJAM BUKU via AJAX ===
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

function doPinjam(bookId, bookTitle) {
    fetch(`/siswa/pinjam/${bookId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showBookingModal(data.booking_code, data.book_title);
        } else {
            // Sudah punya booking aktif?
            if (data.booking_code) {
                showBookingModal(data.booking_code, bookTitle, true);
            } else {
                alert('Gagal: ' + data.message);
            }
        }
    })
    .catch(() => alert('Terjadi kesalahan. Silakan coba lagi.'));
}

function showBookingModal(code, title, isExisting = false) {
    document.getElementById('modalBookTitle').textContent = title;
    document.getElementById('modalBookCode').textContent  = code;
    document.getElementById('modalStatus').textContent    = isExisting
        ? 'Kamu sudah memiliki booking aktif untuk buku ini.'
        : 'Kode booking berhasil dibuat!';
    document.getElementById('bookingModal').classList.add('active');
}

function closeBookingModal() {
    document.getElementById('bookingModal').classList.remove('active');
}

function copyCode() {
    const code = document.getElementById('modalBookCode').textContent;
    navigator.clipboard.writeText(code).then(() => {
        const btn = document.querySelector('.modal-copy-btn');
        const orig = btn.textContent;
        btn.textContent = '✓ Tersalin!';
        btn.style.background = '#10b981';
        setTimeout(() => { btn.textContent = orig; btn.style.background = ''; }, 2000);
    });
}

// Tutup modal jika klik backdrop
document.getElementById('bookingModal').addEventListener('click', function(e) {
    if (e.target === this) closeBookingModal();
});
</script>
@endpush

{{-- MODAL POPUP KODE BOOKING --}}
<div class="modal-overlay" id="bookingModal">
    <div class="modal-box">
        <div class="modal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="#4361ee" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
        </div>
        <p class="modal-title">Booking Berhasil! 🎉</p>
        <p class="modal-sub" id="modalStatus">Kode booking berhasil dibuat!</p>
        <div class="modal-book" id="modalBookTitle">—</div>
        <div class="modal-code-wrap">
            <div class="modal-code-label">KODE BOOKING ANDA</div>
            <div class="modal-code" id="modalBookCode">—</div>
        </div>
        <div>
            <button class="modal-copy-btn" onclick="copyCode()">📋 Salin Kode</button>
            <button class="modal-close-btn" onclick="closeBookingModal()">Tutup</button>
        </div>
        <p class="modal-note">Tunjukkan kode ini kepada penjaga perpustakaan<br>untuk mengambil buku Anda.</p>
    </div>
</div>

@endsection
