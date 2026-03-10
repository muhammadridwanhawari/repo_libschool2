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

    /* Grid buku favorit */
    .fav-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 14px;
    }

    .fav-card {
        background: #fff; border-radius: 10px;
        border: 1px solid #eee; overflow: hidden;
        position: relative;
        transition: transform 0.15s, box-shadow 0.15s;
    }
    .fav-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.1); }

    .fav-cover {
        width: 100%; aspect-ratio: 2/3; object-fit: cover; display: block;
    }
    .fav-cover-placeholder {
        width: 100%; aspect-ratio: 2/3;
        background: linear-gradient(135deg, #e8ecff, #c7d2fe);
        display: flex; align-items: center; justify-content: center;
        flex-direction: column; gap: 4px;
    }
    .fav-cover-placeholder span { font-size: 0.6rem; color: #8b9cf4; font-weight: 500; text-align: center; padding: 0 6px; }

    .fav-info { padding: 8px; background: #fff; }
    .fav-title { font-size: 0.75rem; font-weight: 600; color: #1a1a2e; line-height: 1.3; margin-bottom: 2px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .fav-author { font-size: 0.65rem; color: #aaa; margin-bottom: 8px; }

    .fav-actions { display: flex; gap: 6px; }
    .btn-pinjam-sm {
        flex: 1; background: #4361ee; color: #fff; border: none;
        border-radius: 5px; padding: 5px 0; font-size: 0.68rem;
        font-weight: 600; cursor: pointer; font-family: inherit;
    }
    .btn-pinjam-sm:hover { background: #3a56d4; }

    /* Tombol hapus favorit (ikon hati merah) */
    .btn-unfav {
        position: absolute; top: 5px; right: 5px;
        width: 24px; height: 24px; border-radius: 50%;
        background: rgba(255,255,255,0.95); border: none;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all 0.15s; padding: 0;
        box-shadow: 0 1px 4px rgba(0,0,0,0.15);
    }
    .btn-unfav:hover { transform: scale(1.1); background: #fff1f2; }

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

<div class="breadcrumb">Beranda / <span>Favorit</span></div>

<div class="page-header">
    <h1>Buku Favorit</h1>
    <p>Koleksi buku yang kamu tandai sebagai favorit</p>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif

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
    <div class="fav-grid">
        @foreach($favorites as $fav)
        @php $book = $fav->book; @endphp
        <div class="fav-card">
            {{-- Tombol hapus favorit --}}
            <form method="POST" action="{{ route('siswa.favorite.destroy', $book->id) }}" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-unfav" title="Hapus dari favorit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="#ef4444" stroke="#ef4444" stroke-width="1" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            </form>

            {{-- Cover --}}
            @if($book->cover)
                <img src="{{ asset('storage/' . $book->cover) }}"
                     alt="{{ $book->title }}" class="fav-cover"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="fav-cover-placeholder" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="#8b9cf4" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                </div>
            @else
                <div class="fav-cover-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="#8b9cf4" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                    </svg>
                    <span>{{ Str::limit($book->title, 20) }}</span>
                </div>
            @endif

            {{-- Info --}}
            <div class="fav-info">
                <p class="fav-title">{{ $book->title }}</p>
                <p class="fav-author">{{ $book->author }}</p>
                <div class="fav-actions">
                    @if($book->stock > 0)
                    <form method="POST" action="{{ route('siswa.pinjam', $book->id) }}" style="flex:1;">
                        @csrf
                        <button type="submit" class="btn-pinjam-sm" style="width:100%;">Pinjam</button>
                    </form>
                    @else
                    <button class="btn-pinjam-sm" disabled style="opacity:0.5; cursor:not-allowed; flex:1;">Habis</button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection
