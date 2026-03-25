@extends('layouts.siswa')

@section('title', 'Katalog Buku')

@push('styles')
<style>
    /* ===== NEW KATALOG LAYOUT ===== */
    .katalog-container {
        background: #fff;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }

    .breadcrumb-title { font-size: 1.4rem; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
    .breadcrumb-subtitle { font-size: 0.85rem; color: #94a3b8; margin-bottom: 24px; }

    .search-filter-row {
        margin-bottom: 30px;
    }
    .filter-form-wrapper {
        display: flex; gap: 12px; align-items: center; flex-wrap: wrap;
    }

    .search-input-wrap {
        display: flex; align-items: center; gap: 10px;
        border: 1px solid #e2e8f0; border-radius: 8px;
        padding: 12px 16px; background: #fff; flex: 1; min-width: 300px;
        transition: border-color 0.2s;
    }
    .search-input-wrap:focus-within { border-color: #6366f1; }
    .search-input-wrap input {
        border: none; outline: none; width: 100%;
        font-size: 0.95rem; color: #334155; height: 100%;
    }
    .search-input-wrap input::placeholder { color: #cbd5e1; }

    .filter-dropdown {
        border: 1px solid #e2e8f0; border-radius: 8px;
        padding: 12px 36px 12px 16px; font-size: 0.95rem; color: #475569; font-weight: 500;
        background: #fff url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="%2394a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>') no-repeat right 12px center;
        appearance: none; cursor: pointer; min-width: 170px; outline: none; transition: border-color 0.2s;
    }
    .filter-dropdown:focus { border-color: #6366f1; }

    @media (max-width: 500px) {
        .search-input-wrap { min-width: 100%; }
        .filter-dropdown { min-width: 100%; }
    }

    /* ===== BOOK GRID ===== */
    .book-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    @media (max-width: 1300px) { .book-grid { grid-template-columns: repeat(4, 1fr); } }
    @media (max-width: 1024px) { .book-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px) { .book-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; } }
    @media (max-width: 500px) { .book-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; } }

    .book-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        display: flex; flex-direction: column;
        transition: box-shadow 0.25s, transform 0.25s;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .book-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 32px rgba(0,0,0,0.08);
    }

    .book-cover-area {
        background: #cfe5d5;
        width: 100%; aspect-ratio: 3/4;
        position: relative;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden;
    }
    .book-cover-img { width: 100%; height: 100%; object-fit: cover; }
    
    .badge-tersedia {
        position: absolute; top: 12px; left: 12px; z-index: 10;
        background: #22c55e; color: #fff; border-radius: 9999px;
        padding: 4px 10px; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.5px;
        display: flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(34,197,94,0.3);
    }
    .badge-tersedia .dot { width: 5px; height: 5px; background: #fff; border-radius: 50%; opacity: 0.9; }

    .badge-habis {
        position: absolute; top: 12px; left: 12px; z-index: 10;
        background: #ef4444; color: #fff; border-radius: 9999px;
        padding: 4px 10px; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.5px;
        display: flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(239,68,68,0.3);
    }
    .badge-habis .dot { width: 5px; height: 5px; background: #fff; border-radius: 50%; opacity: 0.9; }

    .fav-btn {
        position: absolute; top: 12px; right: 12px; z-index: 10;
        width: 32px; height: 32px; border-radius: 50%;
        background: rgba(255,255,255,0.9); border: none;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .fav-btn:hover { background: #fff; transform: scale(1.1); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }

    .hover-overlay {
        position: absolute; inset: 0; background: rgba(0,0,0,0.15);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.25s ease;
    }
    .book-card:hover .hover-overlay { opacity: 1; }
    
    .btn-lihat-detail {
        background: #fff; color: #1e293b; padding: 10px 18px; border-radius: 9999px; font-size: 0.8rem; font-weight: 700;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15); transform: translateY(15px); transition: transform 0.25s ease;
    }
    .book-card:hover .btn-lihat-detail { transform: translateY(0); }

    .book-info { padding: 16px; text-align: left; background: #fff; }
    .book-category { font-size: 0.68rem; font-weight: 800; color: #64748b; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
    .book-title { font-size: 1.05rem; font-weight: 800; color: #1e293b; line-height: 1.3; margin-bottom: 4px; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .book-author { font-size: 0.8rem; color: #94a3b8; font-weight: 500; }

    /* Empty state */
    .empty-panel { padding: 60px 16px; text-align: center; color: #94a3b8; grid-column: 1/-1; }
    .empty-panel svg { margin: 0 auto 10px; opacity: 0.5; }
    
    /* Alerts */
    .alert-success { background: #dcfce7; color: #166534; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 0.9rem; font-weight: 500; }
    .alert-danger { background: #fee2e2; color: #991b1b; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 0.9rem; font-weight: 500; }

    /* === MODAL POPUPS === */
    .modal-overlay {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(15,23,42,0.6); backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; pointer-events: none; transition: opacity 0.25s;
    }
    .modal-overlay.active { opacity: 1; pointer-events: all; }
    .modal-box {
        background: #fff; border-radius: 20px;
        padding: 32px; width: 440px; max-width: 92vw;
        position: relative; box-shadow: 0 25px 60px rgba(0,0,0,0.25);
        transform: scale(0.95) translateY(10px); transition: transform 0.25s cubic-bezier(.34,1.56,.64,1);
    }
    .modal-overlay.active .modal-box { transform: scale(1) translateY(0); }
    
    @media (max-width: 500px) {
        .modal-box { padding: 24px 20px; }
        .detail-modal-header { flex-direction: column; align-items: center; text-align: center; }
        .detail-stats-row { justify-content: center; flex-wrap: wrap; }
    }

    .modal-box.modal-center { text-align: center; width: 380px; }
    .modal-icon {
        width: 60px; height: 60px; border-radius: 50%;
        background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }
    
    .detail-modal-header { display: flex; align-items: flex-start; gap: 20px; margin-bottom: 24px; }
    .detail-modal-cover { width: 100px; height: 140px; border-radius: 8px; object-fit: cover; box-shadow: 0 4px 12px rgba(0,0,0,0.1); background: #cfe5d5; flex-shrink: 0; }
    .detail-modal-info h3 { font-size: 1.25rem; font-weight: 800; color: #1e293b; margin-bottom: 4px; line-height: 1.3;}
    .detail-modal-info p { font-size: 0.9rem; color: #64748b; margin-bottom: 8px;}
    .detail-stats-row { display: flex; gap: 12px; margin-bottom: 12px; }
    .detail-stat-badge { background: #f1f5f9; padding: 4px 10px; border-radius: 6px; font-size: 0.75rem; font-weight: 600; color: #475569; }
    .detail-modal-desc { font-size: 0.85rem; color: #475569; line-height: 1.6; margin-bottom: 24px; padding-top: 20px; border-top: 1px solid #f1f5f9; }
    
    .modal-actions { display: flex; gap: 12px; justify-content: flex-end; }
    .btn-batal { background: #f1f5f9; color: #475569; border: none; border-radius: 10px; padding: 10px 20px; font-weight: 700; cursor: pointer; transition: background 0.2s; }
    .btn-batal:hover { background: #e2e8f0; }
    .btn-pinjam-modal { background: #4361ee; color: #fff; border: none; border-radius: 10px; padding: 10px 24px; font-weight: 700; cursor: pointer; transition: background 0.2s; flex: 1;}
    .btn-pinjam-modal:hover { background: #3a56d4; }
    .btn-pinjam-modal:disabled { background: #94a3b8; cursor: not-allowed; }

    /* Modal Booking */
    .modal-title { font-size: 1.25rem; font-weight: 800; color: #1e293b; margin-bottom: 6px; }
    .modal-sub { font-size: 0.9rem; color: #64748b; margin-bottom: 24px; }
    .modal-book { font-size: 0.95rem; color: #334155; font-weight: 700; margin-bottom: 16px; background: #f8fafc; border-radius: 10px; padding: 12px; border: 1px solid #e2e8f0;}
    .modal-code-wrap { background: linear-gradient(135deg, #4361ee, #3a56d4); border-radius: 14px; padding: 24px; margin-bottom: 24px; box-shadow: 0 8px 16px rgba(67,97,238,0.25);}
    .modal-code-label { font-size: 0.75rem; font-weight: 700; color: rgba(255,255,255,0.8); margin-bottom: 8px; letter-spacing: 1px; }
    .modal-code { font-family: 'Courier New', monospace; font-size: 2rem; font-weight: 800; color: #fff; letter-spacing: 4px; }
    .modal-copy-btn { background: #4361ee; color: #fff; border: none; border-radius: 10px; padding: 12px 24px; font-size: 0.9rem; font-weight: 700; cursor: pointer; transition: background 0.2s; margin-right: 8px; }
    .modal-copy-btn:hover { background: #3a56d4; }

    /* Pagination */
    .pagination-wrap {
        padding: 16px; border-top: 1px solid #f0f0f0;
        display: flex; align-items: center; gap: 4px;
        justify-content: center; /* Kept center alignment for catalog grid */
    }
    .pagination-wrap a, .pagination-wrap span {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: 6px;
        font-size: 0.8rem; text-decoration: none;
        color: #666; border: 1px solid #e5e7eb;
    }
    .pagination-wrap .active { background: #4361ee; color: #fff; border-color: #4361ee; }
    .pagination-wrap nav p.text-sm.text-gray-700 { display: none !important; }
    nav[aria-label="pagination"] { margin-top: 0; }
</style>
@endpush

@section('content')

<div class="mb-6">
    <h1 class="text-[1.35rem] font-bold text-indigo-950">Katalog Buku</h1>
    <p class="text-slate-500 text-[0.875rem] mt-1">Klik pada buku untuk melihat detail dan meminjam</p>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-danger">✗ {{ session('error') }}</div>
@endif

<div class="katalog-container">
    {{-- Search & Filter Header --}}
    <div class="search-filter-row">
        <form method="GET" action="{{ route('siswa.katalog') }}" id="searchFilterForm" class="filter-form-wrapper">
            {{-- Search Bar --}}
            <div class="search-input-wrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Judul, Penulis, Sinopsis, atau ISBN...">
            </div>

            {{-- Filter Kategori --}}
            <select name="category" onchange="document.getElementById('searchFilterForm').submit()" class="filter-dropdown">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            {{-- Filter Series --}}
            <select name="series" onchange="document.getElementById('searchFilterForm').submit()" class="filter-dropdown">
                <option value="">Semua Series</option>
                @foreach($series as $s)
                    <option value="{{ $s->id }}" {{ request('series') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>

            <select name="sort" onchange="document.getElementById('searchFilterForm').submit()" class="filter-dropdown">
                <option value="terbaru">Terbaru</option>
                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Judul (A-Z)</option>
            </select>
        </form>
    </div>

    {{-- Grid Buku --}}
    <div class="book-grid">
        @forelse ($books as $book)
        <div class="book-card" data-url="{{ route('siswa.katalog.show', $book->id) }}" onclick="window.location.href=this.dataset.url;">
            {{-- Cover Area --}}
            <div class="book-cover-area">
                @if($book->stock > 0)
                    <div class="badge-tersedia"><div class="dot"></div> TERSEDIA</div>
                @else
                    <div class="badge-habis"><div class="dot"></div> HABIS</div>
                @endif


                @if($book->cover)
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" class="book-cover-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="book-icon-wrapper" style="display:none; color:#84a98c;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/>
                        </svg>
                    </div>
                @else
                    <div class="book-icon-wrapper" style="color:#84a98c;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                        </svg>
                    </div>
                @endif

                <div class="hover-overlay">
                    <span class="btn-lihat-detail">Lihat detail: {{ Str::limit($book->title, 20) }}</span>
                </div>
            </div>

            {{-- Info Area --}}
            <div class="book-info">
                <p class="book-category">{{ $book->categories->isNotEmpty() ? $book->categories->pluck('name')->join(', ') : ($book->category->name ?? 'UMUM') }}</p>
                <p class="book-title" title="{{ $book->title }}">{{ $book->title }}</p>
                <p class="book-author">{{ $book->author ?? 'Tidak diketahui' }}</p>
            </div>
        </div>
        @empty
            <div class="empty-panel">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
                <p>Tidak ada data buku yang ditemukan.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($books->hasPages())
        <div class="pagination-wrap">
            {{ $books->withQueryString()->links() }}
        </div>
    @endif
</div>

{{-- MODAL DETAIL BUKU --}}
@if($selected)
<div class="modal-overlay" id="detailModal">
    <div class="modal-box">
        <div class="detail-modal-header">
            @if($selected->cover)
                <img src="{{ asset('storage/' . $selected->cover) }}" class="detail-modal-cover" alt="Cover">
            @else
                <div class="detail-modal-cover" style="display:flex;align-items:center;justify-content:center;color:#84a98c;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
            @endif
            <div class="detail-modal-info">
                <h3>{{ $selected->title }}</h3>
                <p>{{ $selected->author }}</p>
                <div class="detail-stats-row">
                    <span class="detail-stat-badge">Kategori: {{ $selected->categories->isNotEmpty() ? $selected->categories->pluck('name')->join(', ') : ($selected->category->name ?? 'Umum') }}</span>
                    <span class="detail-stat-badge">Stok: {{ $selected->stock }}</span>
                </div>
            </div>
        </div>
        
        <div class="detail-modal-desc">
            <strong>Penerbit:</strong> {{ $selected->publisher ?? '-' }}<br>
            <strong>ISBN:</strong> {{ $selected->isbn ?? '-' }}<br>
            <strong>Rak Lokasi:</strong> {{ $selected->location ?? 'Belum ditentukan' }}<br><br>
            <strong>Sinopsis:</strong><br>
            {{ $selected->sinopsis ?? 'Tidak ada sinopsis tersedia untuk buku ini.' }}
        </div>

        <div class="modal-actions">
            <button class="btn-batal" onclick="closeDetailModal()">Batal</button>
            @if($selected->stock > 0)
                <button class="btn-pinjam-modal" onclick="doPinjam('{{ $selected->id }}', '{{ addslashes($selected->title) }}')">Pinjam Buku</button>
            @else
                <button class="btn-pinjam-modal" disabled>Stok Habis</button>
            @endif
        </div>
    </div>
</div>
@endif

{{-- MODAL KODE BOOKING --}}
<div class="modal-overlay" id="bookingModal">
    <div class="modal-box modal-center">
        <div class="modal-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#4361ee" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M5 12l5 5L20 7"/></svg>
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
            <button class="btn-batal" onclick="closeBookingModal()">Tutup</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function selectBook(bookId) {
    const url = new URL(window.location.href);
    url.searchParams.set('selected', bookId);
    window.location.href = url.toString();
}

// Buka Modal Detail Secara Otomatis Jika Ada parameter ?selected
document.addEventListener("DOMContentLoaded", function() {
    const isSelected = "{{ $selected ? '1' : '' }}" === "1";
    if (isSelected) {
        document.getElementById('detailModal').classList.add('active');
        document.body.style.overflow = 'hidden';
    }
});

function closeDetailModal() {
    document.getElementById('detailModal').classList.remove('active');
    document.body.style.overflow = '';
    // Hapus parameter ?selected dari URL
    const url = new URL(window.location.href);
    url.searchParams.delete('selected');
    window.history.pushState({}, '', url);
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
            btn.style.transform = 'scale(1.2)';
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
    // Tutup detail modal
    if(document.getElementById('detailModal')) {
        document.getElementById('detailModal').classList.remove('active');
    }

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
    document.body.style.overflow = 'hidden';
}

function closeBookingModal() {
    document.getElementById('bookingModal').classList.remove('active');
    document.body.style.overflow = '';
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
</script>
@endpush
