@extends('layouts.admin')

@section('title', 'Data Pengguna')

@push('styles')
<style>
    .breadcrumb { font-size: 0.85rem; margin-bottom: 20px; }
    .breadcrumb a { color: #4361ee; text-decoration: none; }
    .breadcrumb span { color: #666; }

    /* Top Bar */
    .page-topbar {
        display: flex; align-items: center;
        justify-content: flex-end; margin-bottom: 18px;
    }
    .btn-primary {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        color: #fff; border: none; border-radius: 10px;
        padding: 10px 20px; font-size: 0.85rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all 0.2s;
        text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #3a56d4, #2f49c0);
        transform: translateY(-1px); box-shadow: 0 4px 12px rgba(67,97,238,0.3);
    }

    /* Search */
    .search-wrap {
        display: flex; align-items: center; gap: 10px;
        background: #fff; border-radius: 10px;
        border: 1px solid #ddd; padding: 10px 16px;
        margin-bottom: 20px;
    }
    .search-wrap svg { color: #bbb; flex-shrink: 0; }
    .search-wrap input {
        flex: 1; border: none; outline: none;
        font-size: 0.88rem; color: #555;
        background: transparent; font-family: inherit;
    }

    /* Table */
    .table-card {
        background: #fff; border-radius: 14px;
        border: 1px solid #e8e8e8; overflow: hidden;
    }
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th {
        text-align: left; font-size: 0.72rem;
        font-weight: 700; color: #888;
        text-transform: uppercase; padding: 14px 18px;
        border-bottom: 2px solid #f0f0f0; background: #fafafa;
    }
    .data-table td {
        padding: 14px 18px; font-size: 0.85rem;
        color: #444; border-bottom: 1px solid #f5f5f5;
        vertical-align: middle;
    }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tr:hover td { background: #f8f9ff; }
    .data-table .td-name { font-weight: 600; color: #222; }

    /* Role Badge */
    .role-badge {
        display: inline-block; padding: 4px 14px;
        border-radius: 20px; font-size: 0.75rem; font-weight: 600;
    }
    .role-admin  { background: #fee2e2; color: #dc2626; }
    .role-penjaga { background: #fef9c3; color: #b45309; }
    .role-siswa  { background: #dcfce7; color: #16a34a; }

    /* Action buttons */
    .action-btns { display: flex; gap: 8px; align-items: center; }
    .btn-edit, .btn-delete {
        width: 32px; height: 32px;
        display: inline-flex; align-items: center; justify-content: center;
        border: none; border-radius: 8px; cursor: pointer; transition: all 0.15s;
    }
    .btn-edit { background: #eef0ff; color: #4361ee; }
    .btn-edit:hover { background: #dde1ff; }
    .btn-delete { background: #fee2e2; color: #dc2626; }
    .btn-delete:hover { background: #fecaca; }

    /* Empty & Pagination */
    .empty-state { text-align: center; padding: 40px; color: #999; font-size: 0.85rem; }
    .pagination-wrap {
        display: flex; align-items: center; gap: 4px;
        padding: 16px 18px;
    }
    .pagination-wrap a, .pagination-wrap span {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: 6px;
        font-size: 0.8rem; text-decoration: none; color: #666;
        border: 1px solid #e5e7eb;
    }
    .pagination-wrap .active { background: #4361ee; color: #fff; border-color: #4361ee; }
    .pagination-wrap nav p.text-sm.text-gray-700 { display: none !important; }

    /* ─── MODAL ─────────────────────────────── */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.4); z-index: 1000;
        align-items: center; justify-content: center;
        padding: 20px;
    }
    .modal-overlay.show { display: flex; }

    .modal-box {
        background: #fff; border-radius: 16px;
        width: 100%; max-width: 560px;
        max-height: 90vh; overflow-y: auto;
        padding: 28px 32px; box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        animation: modalPop 0.2s ease;
    }
    @keyframes modalPop {
        from { transform: scale(0.95); opacity: 0; }
        to   { transform: scale(1);    opacity: 1; }
    }
    .modal-box h2 {
        font-size: 1.05rem; font-weight: 700;
        color: #222; margin: 0 0 24px; padding-bottom: 14px;
        border-bottom: 1px solid #f0f0f0;
    }

    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-grid.full { grid-template-columns: 1fr; }
    .form-group { display: flex; flex-direction: column; gap: 5px; }
    .form-group label { font-size: 0.8rem; font-weight: 600; color: #333; }
    .form-group input, .form-group select {
        padding: 9px 13px; border: 1px solid #ddd; border-radius: 8px;
        font-size: 0.85rem; font-family: inherit; outline: none;
        transition: border 0.2s; background: #fff;
    }
    .form-group input:focus, .form-group select:focus { border-color: #4361ee; }
    .form-group input.is-invalid, .form-group select.is-invalid { border-color: #ef4444; }
    .error-msg { font-size: 0.72rem; color: #ef4444; }

    .section-label {
        font-size: 0.88rem; font-weight: 700; color: #222;
        margin: 18px 0 12px; padding-top: 12px;
        border-top: 1px solid #f0f0f0;
    }

    .modal-footer {
        display: flex; justify-content: flex-end; gap: 10px;
        margin-top: 22px; padding-top: 18px; border-top: 1px solid #f0f0f0;
    }
    .btn-cancel-modal {
        padding: 9px 22px; border-radius: 8px; border: 1px solid #ddd;
        background: #fff; color: #555; font-size: 0.85rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all 0.15s;
    }
    .btn-cancel-modal:hover { background: #f5f5f5; }
    .btn-save {
        padding: 9px 22px; border-radius: 8px; border: none;
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        color: #fff; font-size: 0.85rem; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all 0.2s;
    }
    .btn-save:hover { opacity: 0.9; }

    /* Password wrapper with show/hide toggle */
    .password-wrap {
        position: relative;
    }
    .password-wrap input {
        width: 100%; padding-right: 40px; box-sizing: border-box;
    }
    .btn-toggle-pass {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        background: none; border: none; cursor: pointer;
        color: #999; padding: 4px; display: flex; align-items: center;
        transition: color 0.15s;
    }
    .btn-toggle-pass:hover { color: #4361ee; }

    /* Sembunyikan icon mata bawaan browser (Chrome, Edge, IE) */
    #inputPassword::-ms-reveal,
    #inputPassword::-ms-clear {
        display: none !important;
    }
    #inputPassword::-webkit-credentials-auto-fill-button,
    #inputPassword::-webkit-textfield-decoration-container {
        display: none !important;
        visibility: hidden;
        pointer-events: none;
    }
</style>
@endpush

@section('content')
    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Kelola Pengguna</a>
        <span> / Data Pengguna</span>
    </div>

    {{-- Top bar --}}
    <div class="page-topbar">
        <button class="btn-primary" id="btnTambahPengguna">+ Tambah Pengguna</button>
    </div>

    {{-- Search --}}
    <form action="{{ route('admin.pengguna.index') }}" method="GET">
        <div class="search-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari Nama Peminjam atau Judul Buku..">
        </div>
    </form>

    {{-- Table --}}
    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Nama Lengkap</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td class="td-name">{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @php $r = strtolower($user->role); @endphp
                        <span class="role-badge role-{{ $r }}">
                            {{ ucfirst($user->role === 'penjaga' ? 'Petugas' : $user->role) }}
                        </span>
                    </td>
                    <td>{{ $user->name && $user->name !== $user->username ? $user->name : '-' }}</td>
                    <td>
                        <div class="action-btns">
                            {{-- Edit --}}
                            <button type="button" class="btn-edit btn-edit-pengguna"
                                data-id="{{ $user->id }}"
                                data-username="{{ $user->username }}"
                                data-email="{{ $user->email }}"
                                data-role="{{ $user->role }}"
                                data-name="{{ $user->name }}"
                                data-telepon="{{ $user->telepon }}"
                                data-gender="{{ $user->gender }}"
                                title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>

                            {{-- Hapus (Admin tidak boleh hapus dirinya sendiri) --}}
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST"
                                  onsubmit="confirmAction(event, 'Yakin ingin menghapus pengguna {{ $user->username }}?', 'Ya, Hapus', 'Konfirmasi Hapus'); return false;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-state">Belum ada pengguna terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if($users->hasPages())
        <div class="pagination-wrap">
            {{ $users->appends(['search' => $search])->links() }}
        </div>
        @endif
    </div>

    {{-- ═══ MODAL TAMBAH PENGGUNA ═══ --}}
    <div class="modal-overlay" id="modalTambah">
        <div class="modal-box">
            <h2 id="modalTitle">Tambah Pengguna baru</h2>
            <form id="formPengguna" method="POST" action="{{ route('admin.pengguna.store') }}"
                  autocomplete="off">
                @csrf
                {{-- Trik anti-autofill: field dummy tersembunyi --}}
                <input type="text" name="_dummy_user" style="display:none" aria-hidden="true" tabindex="-1">
                <input type="password" name="_dummy_pass" style="display:none" aria-hidden="true" tabindex="-1">
                <span id="methodField"></span>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Pengguna</label>
                        <input type="text" name="username" id="inputUsername" placeholder="username"
                               autocomplete="off"
                               class="{{ $errors->has('username') ? 'is-invalid' : '' }}">
                        @error('username')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="inputEmail" placeholder="email@example.com"
                               autocomplete="off"
                               class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @error('email')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" id="inputRole">
                            <option value="siswa">Siswa (Anggota)</option>
                            <option value="penjaga">Petugas</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>
                            Kata Sandi
                            <span id="passHint" style="font-weight:400;color:#888;font-size:0.75rem;"></span>
                        </label>
                        <div class="password-wrap">
                            <input type="password" name="password" id="inputPassword"
                                   placeholder="Min. 8 karakter"
                                   autocomplete="new-password">
                            <button type="button" class="btn-toggle-pass" id="btnTogglePass"
                                    title="Tampilkan/Sembunyikan kata sandi">
                                {{-- Eye icon (tampil by default) --}}
                                <svg id="iconEye" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{-- Eye-off icon (tersembunyi by default) --}}
                                <svg id="iconEyeOff" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                     style="display:none;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="section-label">Data Profil Anggota</div>

                <div class="form-grid full">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" id="inputName" placeholder="Nama lengkap">
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input type="text" name="telepon" id="inputTelepon" placeholder="08xx">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="gender" id="inputGender">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel-modal" id="btnBatalModal">Batal</button>
                    <button type="submit" class="btn-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
const modal       = document.getElementById('modalTambah');
const form        = document.getElementById('formPengguna');
const modalTitle  = document.getElementById('modalTitle');
const methodField = document.getElementById('methodField');
const passHint    = document.getElementById('passHint');
const passInput   = document.getElementById('inputPassword');
const iconEye     = document.getElementById('iconEye');
const iconEyeOff  = document.getElementById('iconEyeOff');

const storeUrl = "{{ route('admin.pengguna.store') }}";

// ─── Fungsi clear semua field (anti-autofill) ───────────────
function clearAllFields() {
    document.getElementById('inputUsername').value = '';
    document.getElementById('inputEmail').value    = '';
    document.getElementById('inputRole').value     = 'siswa';
    document.getElementById('inputName').value     = '';
    document.getElementById('inputTelepon').value  = '';
    document.getElementById('inputGender').value   = 'Laki-laki';
    passInput.value = '';
    // Reset password field ke tipe 'password' & icon
    passInput.type       = 'password';
    iconEye.style.display    = '';
    iconEyeOff.style.display = 'none';
}

function openModal() { modal.classList.add('show'); }
function closeModal() {
    modal.classList.remove('show');
    clearAllFields();
    methodField.innerHTML = '';
}

// ─── Buka modal Tambah ───────────────────────────────────────
document.getElementById('btnTambahPengguna').addEventListener('click', function () {
    modalTitle.textContent  = 'Tambah Pengguna baru';
    form.action             = storeUrl;
    methodField.innerHTML   = '';
    passHint.textContent    = '';
    passInput.required      = true;
    openModal();
    // Delay clear untuk mengatasi browser autofill yang lambat
    setTimeout(clearAllFields, 50);
    setTimeout(clearAllFields, 200);
});

// ─── Buka modal Edit ─────────────────────────────────────────
document.querySelectorAll('.btn-edit-pengguna').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;

        modalTitle.textContent  = 'Edit Pengguna';
        form.action             = `/admin/pengguna/${id}`;
        methodField.innerHTML   = '<input type="hidden" name="_method" value="PUT">';
        passHint.textContent    = '(kosongkan jika tidak diubah)';
        passInput.required      = false;

        document.getElementById('inputUsername').value = this.dataset.username;
        document.getElementById('inputEmail').value    = this.dataset.email;
        document.getElementById('inputRole').value     = this.dataset.role;
        document.getElementById('inputName').value     = this.dataset.name;
        document.getElementById('inputTelepon').value  = this.dataset.telepon;
        document.getElementById('inputGender').value   = this.dataset.gender;
        passInput.value = '';
        passInput.type  = 'password';
        iconEye.style.display    = '';
        iconEyeOff.style.display = 'none';

        openModal();
    });
});

// ─── Toggle Show/Hide Password ───────────────────────────────
document.getElementById('btnTogglePass').addEventListener('click', function () {
    if (passInput.type === 'password') {
        passInput.type           = 'text';
        iconEye.style.display    = 'none';
        iconEyeOff.style.display = '';
    } else {
        passInput.type           = 'password';
        iconEye.style.display    = '';
        iconEyeOff.style.display = 'none';
    }
    passInput.focus();
});

// ─── Tutup modal ─────────────────────────────────────────────
document.getElementById('btnBatalModal').addEventListener('click', closeModal);
modal.addEventListener('click', function (e) {
    if (e.target === modal) closeModal();
});
</script>

@if($errors->any())
<script>
// ─── Buka otomatis jika ada error validasi ───────────────────
    openModal();
</script>
@endif
@endpush
