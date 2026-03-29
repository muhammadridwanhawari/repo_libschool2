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
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 30px;
    }
    .module-card {
        background: #fff; border: 1px solid #e8e8e8;
        border-left: 3px solid #4361ee;
        border-radius: 4px; padding: 14px 16px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .module-card-header {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 8px;
    }
    .module-card-icon {
        width: 24px; height: 24px;
        display: flex; align-items: center; justify-content: center;
        color: #222;
    }
    .module-card-icon svg { width: 18px; height: 18px; }
    .module-card h4 {
        font-size: 0.82rem; font-weight: 700; color: #222;
        margin: 0;
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
        background: #fff; border: 1px solid #e8e8e8;
        border-top: 3px solid #4361ee;
        border-radius: 4px; padding: 20px 22px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    }

    /* Form inside Petugas card */
    .form-hakakses-grid {
        display: grid; 
        grid-template-columns: 1fr 1fr;
        gap: 16px 24px;
        align-items: center;
    }

    .petugas-header-pill {
        display: flex; align-items: center; gap: 12px;
        background: #e2e8f0; border-radius: 50px;
        padding: 6px 16px 6px 6px;
        width: fit-content;
    }

    .petugas-avatar {
        width: 44px; height: 44px; border-radius: 50%;
        background: #fff; display: flex;
        align-items: center; justify-content: center;
        overflow: hidden; flex-shrink: 0;
    }
    .petugas-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .petugas-avatar svg { color: #888; width: 20px; height: 20px;}
    .petugas-info h3 { font-size: 0.88rem; font-weight: 700; color: #222; margin: 0 0 2px; }
    .petugas-info p  { font-size: 0.72rem; color: #666; margin: 0; }

    /* Perm row */
    .perm-row {
        display: flex; align-items: center; justify-content: space-between;
    }
    .perm-label {
        display: flex; align-items: center; gap: 10px;
        font-size: 0.85rem; color: #222; font-weight: 700;
    }
    .perm-label-icon {
        width: 32px; height: 32px; border-radius: 4px;
        border: 1.5px solid #4361ee; display: flex;
        align-items: center; justify-content: center;
        flex-shrink: 0; color: #222;
    }
    .perm-label-icon svg { width: 16px; height: 16px; }

    /* Status text */
    .perm-status { display: flex; align-items: center; gap: 10px; }
    .perm-status span {
        font-size: 0.72rem; color: #888; min-width: 42px; text-align: right;
    }

    /* Toggle switch */
    .toggle-switch {
        position: relative; display: inline-block;
        width: 40px; height: 22px;
    }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .toggle-slider {
        position: absolute; inset: 0;
        background: #e2e8f0; border-radius: 22px;
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
        grid-column: span 2; width: 100%; margin-top: 20px;
        background: #4361ee; color: #fff; border: none; border-radius: 6px;
        padding: 10px; font-size: 0.85rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all 0.2s;
    }
    .btn-save-perm:hover { background: #3a56d4; }

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
            <div class="module-card-header">
                <div class="module-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                    </svg>
                </div>
                <h4>Kelola Kategori</h4>
            </div>
            <p>Menambah, Mengubah dan Menghapus data buku.</p>
        </div>
        <div class="module-card">
            <div class="module-card-header">
                <div class="module-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h4>Data Buku</h4>
            </div>
            <p>Mengelola data buku.</p>
        </div>
        <div class="module-card">
            <div class="module-card-header">
                <div class="module-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h4>Peminjaman</h4>
            </div>
            <p>Melakukan transaksi peminjaman dan pengembalian buku.</p>
        </div>
        <div class="module-card">
            <div class="module-card-header">
                <div class="module-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                    </svg>
                </div>
                <h4>Denda</h4>
            </div>
            <p>Mengelola data denda dan keterlambatan pengembalian buku.</p>
        </div>
        <div class="module-card">
            <div class="module-card-header">
                <div class="module-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </div>
                <h4>Series Buku</h4>
            </div>
            <p>Mengelola data series atau koleksi buku.</p>
        </div>

        <div class="module-card">
            <div class="module-card-header">
                <div class="module-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 20V10M12 20V4M6 20v-6"/>
                    </svg>
                </div>
                <h4>Laporan</h4>
            </div>
            <p>Melihat dan membuat laporan berbasis data.</p>
        </div>
    </div>

    {{-- Petugas Grid --}}
    <div class="petugas-grid">
        @forelse ($petugas as $p)
        @php
            $perms = json_decode($p->permissions ?? '[]', true) ?? [];
            $modulesUI = [
                'peminjaman' => ['label' => 'Peminjaman', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'],
                'kategori'   => ['label' => 'Kelola Kategori', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>'],
                'series'     => ['label' => 'Series Buku', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"/>'],
                'buku'       => ['label' => 'Data Buku', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>'],

                'denda'      => ['label' => 'Denda', 'icon' => '<circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>'],
                'laporan'    => ['label' => 'Laporan', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M18 20V10M12 20V4M6 20v-6"/>'],
            ];
            
            // Reordering based on UI matrix: 
            // Col 1: Header -> Kelola Kategori -> Data Buku -> Pengajuan Buku
            // Col 2: Peminjaman -> Denda -> Series Buku -> Laporan
        @endphp
        <div class="petugas-card">
            <form action="{{ route('admin.hakakses.update', $p->id) }}" method="POST">
                @csrf
                <div class="form-hakakses-grid">
                    
                    {{-- Cell 1: Petugas Header --}}
                    <div class="petugas-header-pill">
                        <div class="petugas-avatar">
                            @if(isset($p->avatar))
                                <img src="{{ asset($p->avatar) }}" alt="Avatar">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="petugas-info">
                            <h3>{{ $p->username }}</h3>
                            <p>{{ $p->email }}</p>
                        </div>
                    </div>

                    {{-- Cell 2: Peminjaman --}}
                    @php $key = 'peminjaman'; $mod = $modulesUI[$key]; $checked = in_array($key, $perms); @endphp
                    <div class="perm-row">
                        <div class="perm-label">
                            <div class="perm-label-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $mod['icon'] !!}</svg></div>
                            {{ $mod['label'] }}
                        </div>
                        <div class="perm-status">
                            <span class="status-text-{{ $p->id }}-{{ $key }}">{{ $checked ? 'Aktif' : 'Nonaktif' }}</span>
                            <label class="toggle-switch">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}" {{ $checked ? 'checked' : '' }} onchange="updateStatus(this, '{{ $p->id }}', '{{ $key }}')">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    {{-- Cell 3: Kelola Kategori --}}
                    @php $key = 'kategori'; $mod = $modulesUI[$key]; $checked = in_array($key, $perms); @endphp
                    <div class="perm-row">
                        <div class="perm-label">
                            <div class="perm-label-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $mod['icon'] !!}</svg></div>
                            {{ $mod['label'] }}
                        </div>
                        <div class="perm-status">
                            <span class="status-text-{{ $p->id }}-{{ $key }}">{{ $checked ? 'Aktif' : 'Nonaktif' }}</span>
                            <label class="toggle-switch">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}" {{ $checked ? 'checked' : '' }} onchange="updateStatus(this, '{{ $p->id }}', '{{ $key }}')">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                    
                    {{-- Cell 4: Denda --}}
                    @php $key = 'denda'; $mod = $modulesUI[$key]; $checked = in_array($key, $perms); @endphp
                    <div class="perm-row">
                        <div class="perm-label">
                            <div class="perm-label-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $mod['icon'] !!}</svg></div>
                            {{ $mod['label'] }}
                        </div>
                        <div class="perm-status">
                            <span class="status-text-{{ $p->id }}-{{ $key }}">{{ $checked ? 'Aktif' : 'Nonaktif' }}</span>
                            <label class="toggle-switch">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}" {{ $checked ? 'checked' : '' }} onchange="updateStatus(this, '{{ $p->id }}', '{{ $key }}')">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    {{-- Cell 5: Data Buku --}}
                    @php $key = 'buku'; $mod = $modulesUI[$key]; $checked = in_array($key, $perms); @endphp
                    <div class="perm-row">
                        <div class="perm-label">
                            <div class="perm-label-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $mod['icon'] !!}</svg></div>
                            {{ $mod['label'] }}
                        </div>
                        <div class="perm-status">
                            <span class="status-text-{{ $p->id }}-{{ $key }}">{{ $checked ? 'Aktif' : 'Nonaktif' }}</span>
                            <label class="toggle-switch">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}" {{ $checked ? 'checked' : '' }} onchange="updateStatus(this, '{{ $p->id }}', '{{ $key }}')">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    {{-- Cell 6: Laporan --}}
                    @php $key = 'laporan'; $mod = $modulesUI[$key]; $checked = in_array($key, $perms); @endphp
                    <div class="perm-row">
                        <div class="perm-label">
                            <div class="perm-label-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $mod['icon'] !!}</svg></div>
                            {{ $mod['label'] }}
                        </div>
                        <div class="perm-status">
                            <span class="status-text-{{ $p->id }}-{{ $key }}">{{ $checked ? 'Aktif' : 'Nonaktif' }}</span>
                            <label class="toggle-switch">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}" {{ $checked ? 'checked' : '' }} onchange="updateStatus(this, '{{ $p->id }}', '{{ $key }}')">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    {{-- Cell 7: Series Buku --}}
                    @php $key = 'series'; $mod = $modulesUI[$key]; $checked = in_array($key, $perms); @endphp
                    <div class="perm-row">
                        <div class="perm-label">
                            <div class="perm-label-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">{!! $mod['icon'] !!}</svg></div>
                            {{ $mod['label'] }}
                        </div>
                        <div class="perm-status">
                            <span class="status-text-{{ $p->id }}-{{ $key }}">{{ $checked ? 'Aktif' : 'Nonaktif' }}</span>
                            <label class="toggle-switch">
                                <input type="checkbox" name="permissions[]" value="{{ $key }}" {{ $checked ? 'checked' : '' }} onchange="updateStatus(this, '{{ $p->id }}', '{{ $key }}')">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>


                </div>

                {{-- Simpan di bawah full width --}}
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
