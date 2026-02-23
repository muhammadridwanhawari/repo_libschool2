@extends('layouts.siswa')

@section('title', 'Katalog Buku')

@section('content')
<div class="katalog-wrapper">

    {{-- TENGAH: Cari Buku --}}
    <div class="main-content">

        {{-- Search Header --}}
        <div class="search-card">
            <div class="search-header">
                <h2 class="search-title">Cari Buku / Koleksi</h2>
                <div class="pagination-info">
                    <span class="page-badge">{{ $books->currentPage() }}</span>
                    <a href="{{ $books->nextPageUrl() }}" class="page-arrow">&#8250;</a>
                </div>
            </div>
            <div class="search-box">
                <form method="GET" action="{{ route('siswa.katalog') }}">
                    <div class="search-input-wrap">
                        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 0 5 11a6 6 0 0 0 12 0z"/>
                        </svg>
                        <input type="text" name="search" class="search-input" placeholder="Cari Buku.."
                            value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>

        {{-- Grid Buku --}}
        <div class="books-grid">
            @forelse($books as $book)
                <div class="book-card {{ isset($selected) && $selected->id == $book->id ? 'active' : '' }}"
                     onclick="selectBook({{ $book->id }})">
                    <div class="book-cover">
                        @if($book->cover)
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}">
                        @else
                            <div class="book-cover-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" viewBox="0 0 24 24" stroke="#d1d5db">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="book-info">
                        <p class="book-title-small">{{ Str::limit($book->title, 20) }}</p>
                        <p class="book-author-small">{{ $book->author }}</p>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <p>Tidak ada buku ditemukan.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div style="margin-top:1rem;">
            {{ $books->withQueryString()->links() }}
        </div>

    </div>

    {{-- KANAN: Detail Buku --}}
    <div class="detail-panel" id="detail-panel">

        {{-- Filter Bar --}}
        <div class="filter-bar">
            <form method="GET" action="{{ route('siswa.katalog') }}" class="filter-form">
                <select name="category" class="filter-select">
                    <option value="">&#9783; Genre</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <select name="sort" class="filter-select">
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>&#9776; Title</option>
                    <option value="author" {{ request('sort') == 'author' ? 'selected' : '' }}>&#9776; Author</option>
                    <option value="year" {{ request('sort') == 'year' ? 'selected' : '' }}>&#9776; Year</option>
                </select>
                <button type="submit" class="filter-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin-right:4px">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>
                    Filter
                </button>
            </form>
        </div>

        {{-- Detail Card --}}
        @if(isset($selected))
        <div class="detail-card">
            <div class="detail-cover">
                @if($selected->cover)
                    <img src="{{ asset('storage/' . $selected->cover) }}" alt="{{ $selected->title }}">
                @else
                    <div class="detail-cover-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="none" viewBox="0 0 24 24" stroke="#d1d5db">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="detail-info">
                <p class="detail-book-title">{{ $selected->title }}</p>
                <p class="detail-book-author">{{ $selected->author }}</p>
                <div class="detail-stars">
                    <span>&#9733;&#9733;&#9733;&#9733;&#9734;</span>
                    <span class="detail-rating">4.8</span>
                </div>
                <div class="detail-meta">
                    <span class="meta-badge">{{ $selected->category->name ?? '-' }}</span>
                    <span class="meta-badge">{{ $selected->year ?? '-' }}</span>
                    <span class="meta-badge stock {{ $selected->stock > 0 ? 'available' : 'empty' }}">
                        Stok: {{ $selected->stock }}
                    </span>
                </div>
            </div>
            <div class="detail-actions">
                <a href="{{ route('siswa.katalog.show', $selected->id) }}" class="btn-detail">Tampilkan Detail</a>
                @if($selected->stock > 0)
                    <form method="POST" action="{{ route('siswa.pinjam', $selected->id) }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-pinjam">Pinjam</button>
                    </form>
                @else
                    <button class="btn-pinjam disabled" disabled>Stok Habis</button>
                @endif
            </div>
        </div>
        @else
        <div class="detail-empty">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#d1d5db">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
            </svg>
            <p>Pilih buku untuk melihat detail</p>
        </div>
        @endif
    </div>

</div>

<script>
function selectBook(id) {
    window.location.href = '{{ route("siswa.katalog") }}?selected=' + id + '&search={{ request("search") }}&category={{ request("category") }}&sort={{ request("sort") }}';
}
</script>
@endsection