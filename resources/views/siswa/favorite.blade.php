@extends('layouts.siswa')

@section('title', 'Buku Favorit')

@push('styles')
<style>
    .breadcrumb { font-size: 0.8rem; color: #4361ee; margin-bottom: 14px; }
    .breadcrumb span { color: #888; }

    .page-header { margin-bottom: 16px; }
    .page-header h1 { font-size: 1.1rem; font-weight: 700; color: #1a1a2e; margin: 0 0 4px; }
    .page-header p { font-size: 0.82rem; color: #888; margin: 0; }

    .alert-success {
        background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;
        border-radius: 8px; padding: 9px 14px; margin-bottom: 14px; font-size: 0.82rem;
    }

    /* ===== BOOK GRID (from Katalog) ===== */
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
        position: relative;
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

    /* Badge buku yang sedang dipinjam oleh siswa ini */
    .badge-my-borrowed {
        position: absolute; top: 12px; left: 12px; z-index: 10;
        background: #7c3aed; color: #fff; border-radius: 9999px;
        padding: 4px 10px; font-size: 0.65rem; font-weight: 800; letter-spacing: 0.5px;
        display: flex; align-items: center; gap: 4px; box-shadow: 0 2px 6px rgba(124,58,237,0.4);
    }
    .badge-my-borrowed .dot { width: 5px; height: 5px; background: #fff; border-radius: 50%; opacity: 0.9; animation: pulse-dot 1.5s infinite; }
    @keyframes pulse-dot { 0%, 100% { opacity: 0.9; } 50% { opacity: 0.3; } }

    .fav-btn {
        position: absolute; top: 12px; right: 12px; z-index: 11;
        width: 32px; height: 32px; border-radius: 50%;
        background: rgba(255,255,255,0.9); border: none;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 0;
    }
    .fav-btn:hover { background: #fff; transform: scale(1.1); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }

    .hover-overlay {
        position: absolute; inset: 0; background: rgba(0,0,0,0.15);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.25s ease;
        z-index: 5;
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
    .empty-state {
        background: #fff; border-radius: 12px; border: 1px solid #eee;
        padding: 60px 20px; text-align: center; color: #ccc;
    }
    .empty-state svg { margin-bottom: 12px; opacity: 0.4; }
    .empty-state h3 { font-size: 0.95rem; color: #555; font-weight: 600; margin: 0 0 6px; }
    .empty-state p { font-size: 0.82rem; color: #aaa; margin: 0 0 16px; }
    .btn-goto-katalog {
        display: inline-block; background: #4361ee; color: #fff;
        border-radius: 8px; padding: 9px 20px; font-size: 0.82rem;
        font-weight: 600; text-decoration: none; transition: background 0.15s;
    }
    .btn-goto-katalog:hover { background: #3a56d4; color: #fff; }
</style>
@endpush

@section('content')

<div class="mb-6">
    <h1 class="text-[1.35rem] font-bold text-indigo-950">Ruang Rahasia Penuh Keajaiban</h1>
    <p class="text-slate-500 text-[0.875rem] mt-1">Kisah-kisah yang menolak untuk kamu lupakan. Simpan keajaibannya di sini</p>
</div>

@if($favorites->isEmpty())
    <div class="empty-state">
        <svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        <h3>Belum ada buku favorit</h3>
        <p>Tekan ikon ♥ di katalog untuk menyimpan buku favoritmu</p>
        <a href="{{ route('siswa.katalog') }}" class="btn-goto-katalog">Jelajahi Katalog</a>
    </div>
@else
    <div class="book-grid">
        @foreach($favorites as $fav)
        @php $book = $fav->book; @endphp
        <div class="book-card" data-url="{{ route('siswa.katalog.show', $book->id) }}" onclick="window.location.href=this.dataset.url;">
            
            {{-- Tombol hapus favorit --}}
            <form method="POST" action="{{ route('siswa.favorite.destroy', $book->id) }}" style="position: absolute; top: 12px; right: 12px; z-index: 11;">
                @csrf @method('DELETE')
                <button type="submit" class="fav-btn" title="Hapus dari favorit" onclick="event.stopPropagation();">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ef4444" stroke="#ef4444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            </form>

            {{-- Cover Area --}}
            <div class="book-cover-area">
                @php $isMyBorrowed = in_array($book->id, $activeBorrowedBookIds ?? []); @endphp
                @if($isMyBorrowed)
                    <div class="badge-my-borrowed"><div class="dot"></div> DIPINJAM</div>
                @elseif($book->stock > 0)
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
        @endforeach
    </div>
@endif

@endsection
