@extends('layouts.admin')

@section('title', 'Hak Akses')

@push('styles')
<style>
    .breadcrumb { font-size: 0.85rem; margin-bottom: 4px; }
    .breadcrumb a { color: #4361ee; text-decoration: none; }
    .breadcrumb span { color: #666; }

    .page-title {
        font-size: 1.4rem; font-weight: 700; color: #1a1a1a;
        margin: 0 0 24px;
    }

    /* Module description cards */
    .module-cards {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 14px;
        margin-bottom: 30px;
    }
    .module-card {
        background: #fff; border: 1px solid #e8e8e8;
        border-radius: 12px; padding: 14px 16px;
    }
    .module-card-icon {
        width: 36px; height: 36px; border-radius: 8px;
        background: #eef0ff; display: flex; align-items: center;
        justify-content: center; margin-bottom: 8px;
    }
    .module-card-icon svg { color: #4361ee; }
    .module-card h4 {
        font-size: 0.82rem; font-weight: 700; color: #222;
        margin: 0 0 4px;
    }
    .module-card p {
        font-size: 0.73rem; color: #888; margin: 0; line-height: 1.4;
    }

    /* Petugas grid */
    .petugas-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .petugas-card {
        background: #fff; border: 2px solid #4361ee;
        border-radius: 16px; padding: 20px 22px;
    }

    .petugas-header {
        display: flex; align-items: center; gap: 14px;
        margin-bottom: 16px;
    }
    .petugas-avatar {
        width: 52px; height: 52px; border-radius: 50%;
        background: #e0e0e0; display: flex;
        align-items: center; justify-content: center;
        overflow: hidden; flex-shrink: 0;
    }
    .petugas-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .petugas-avatar svg { color: #888; }
    .petugas-info h3 { font-size: 0.92rem; font-weight: 700; color: #222; margin: 0 0 2px; }
    .petugas-info p  { font-size: 0.78rem; color: #888; margin: 0; }

    /* Permissions grid */
    .perm-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
    }
    .perm-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 8px 10px; border-radius: 8px; background: #fafafa;
        border: 1px solid #f0f0f0;
    }
    .perm-label {
        display: flex; align-items: center; gap: 8px;
        font-size: 0.8rem; color: #444; font-weight: 500;
    }
    .perm-label-icon {
        width: 28px; height: 28px; border-radius: 6px;
        background: #eef0ff; display: flex;
        align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .perm-label-icon svg { color: #4361ee; }

    /* Status text */
    .perm-status { display: flex; align-items: center; gap: 8px; }
    .perm-status span {
        font-size: 0.72rem; color: #888; min-width: 42px;
    }

    /* Toggle switch */
    .toggle-switch {
        position: relative; display: inline-block;
        width: 40px; height: 22px;
    }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; inset: 0;
        background: #ccc; border-radius: 22px;
        cursor: pointer; transition: background 0.2s;
    }
    .toggle-slider::before {
        content: ''; position: absolute;
        width: 16px; height: 16px; border-radius: 50%;
        background: #fff; left: 3px; top: 3px;
        transition: transform 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .toggle-switch input:checked + .toggle-slider { background: #4361ee; }
    .toggle-switch input:checked + .toggle-slider::before { transform: translateX(18px); }

    /* Save button per card */
    .btn-save-perm {
        display: block; width: 100%; margin-top: 14px;
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        color: #fff; border: none; border-radius: 8px;
        padding: 9px; font-size: 0.82rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all 0.2s;
    }
    .btn-save-perm:hover { opacity: 0.9; }

    /* Empty state */
    .empty-petugas {
        grid-column: span 2; text-align: center;
        padding: 60px 20px; color: #999; font-size: 0.9rem;
        border: 2px dashed #e0e0e0; border-radius: 16px;
    }
</style>
@endpush

@section('content')
    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.pengguna.index') }}">Kelola Pengguna</a>
        <span> / Hak Akses</span>
    </div>
    <h1 class="page-title">Pengaturan hak akses pengguna.</h1>

    {{-- Module Info Cards --}}
    <div class="module-cards">
        <div class="module-card">
            <div class="module-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10M7 11h10M7 15h6"/>
                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                </svg>
            </div>
            <h4>Kelola Kategori</h4>
            <p>Menambah, Mengubah dan Menghapus data buku.</p>
        </div>
        <div class="module-card">
            <div class="module-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h4>Data Buku</h4>
            <p>Mengelola data buku.</p>
        </div>
        <div class="module-card">
            <div class="module-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
            </div>
            <h4>Peminjaman</h4>
            <p>Melakukan transaksi peminjaman dan pengembalian buku.</p>
        </div>
        <div class="module-card">
            <div class="module-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                </svg>
            </div>
            <h4>Denda</h4>
            <p>Mengelola data denda dan keterlambatan pengembalian buku.</p>
        </div>
        <div class="module-card">
            <div class="module-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h4>Laporan</h4>
            <p>Melihat dan membuat laporan berbasis data.</p>
        </div>
    </div>

    {{-- Petugas Grid --}}
    <div class="petugas-grid">
        @forelse($petugas as $p)
        @php
            $perms = json_decode($p->permissions ?? '[]', true) ?? [];
            $modules = [
                'peminjaman' => ['label' => 'Peminjaman', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>'],
                'kategori'   => ['label' => 'Kelola Kategori', 'icon' => '<rect x="3" y="3" width="18" height="18" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10M7 11h10M7 15h6"/>'],
                'denda'      => ['label' => 'Denda', 'icon' => '<circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>'],
                'buku'       => ['label' => 'Data Buku', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],
                'laporan'    => ['label' => 'Laporan', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
            ];
        @endphp
        <div class="petugas-card">
            <div class="petugas-header">
                <div class="petugas-avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="petugas-info">
                    <h3>{{ $p->username }}</h3>
                    <p>{{ $p->email }}</p>
                </div>
            </div>

            <form action="{{ route('admin.hakakses.update', $p->id) }}" method="POST" class="form-hakakses">
                @csrf
                <div class="perm-grid">
                    @foreach($modules as $key => $mod)
                    @php $checked = in_array($key, $perms); @endphp
                    <div class="perm-row">
                        <div class="perm-label">
                            <div class="perm-label-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    {!! $mod['icon'] !!}
                                </svg>
                            </div>
                            {{ $mod['label'] }}
                        </div>
                        <div class="perm-status">
                            <span class="status-text-{{ $p->id }}-{{ $key }}">{{ $checked ? 'Aktif' : 'Nonaktif' }}</span>
                            <label class="toggle-switch">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}"
                                    {{ $checked ? 'checked' : '' }}
                                    onchange="updateStatus(this, '{{ $p->id }}', '{{ $key }}')">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>

                <button type="submit" class="btn-save-perm">Simpan Hak Akses</button>
            </form>
        </div>
        @empty
        <div class="empty-petugas">
            <p>Belum ada petugas terdaftar.</p>
            <p style="font-size:0.8rem; margin-top:6px;">Tambah pengguna dengan role <strong>Petugas</strong> terlebih dahulu.</p>
        </div>
        @endforelse
    </div>
@endsection

@push('scripts')
<script>
function updateStatus(checkbox, userId, module) {
    const label = document.querySelector(`.status-text-${userId}-${module}`);
    if (label) label.textContent = checkbox.checked ? 'Aktif' : 'Nonaktif';
}
</script>
@endpush
