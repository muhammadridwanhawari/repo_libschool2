<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // ─── Data Pengguna ───────────────────────────────────────────
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('username', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%");
        })->orderByRaw("CASE role WHEN 'admin' THEN 1 WHEN 'penjaga' THEN 2 ELSE 3 END")
          ->orderBy('created_at', 'desc')
          ->paginate(10);

        return view('admin.pengguna.index', compact('users', 'search'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username'     => 'required|string|max:255|unique:users',
            'email'        => 'required|string|email|max:255|unique:users',
            'role'         => 'required|in:admin,penjaga,siswa',
            'password'     => ['required', 'min:8'],
            'name'         => 'nullable|string|max:255',
            // [MEDIUM-F08] Fix: Validasi telepon diperketat (Hanya angka, maks 15)
            'telepon'      => ['nullable', 'string', 'max:15', 'regex:/^[0-9]+$/'],
            'gender'       => 'nullable|in:Laki-laki,Perempuan',
            'tanggal_lahir'=> 'nullable|date',
            'nik'          => 'nullable|string|max:20|unique:users',
        ]);

        User::create([
            'username'      => $request->username,
            'email'         => $request->email,
            'role'          => $request->role,
            'password'      => Hash::make($request->password),
            'name'          => $request->name ?? $request->username,
            'nik'           => $request->filled('nik') ? $request->nik : null,
            'telepon'       => $request->filled('telepon') ? $request->telepon : null,
            'gender'        => $request->gender ?? 'Laki-laki',
            'tanggal_lahir' => $request->tanggal_lahir ?: null,
        ]);

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, User $pengguna): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $pengguna->id,
            'email'    => 'required|string|email|max:255|unique:users,email,' . $pengguna->id,
            'role'     => 'required|in:admin,penjaga,siswa',
            'name'     => 'nullable|string|max:255',
            // [MEDIUM-F08] Fix: Validasi telepon diperketat (Hanya angka, maks 15)
            'telepon'  => ['nullable', 'string', 'max:15', 'regex:/^[0-9]+$/'],
            'gender'   => 'nullable|in:Laki-laki,Perempuan',
        ]);

        $data = [
            'username' => $request->username,
            'email'    => $request->email,
            'role'     => $request->role,
            'name'     => $request->name ?? $pengguna->name,
            'telepon'  => $request->telepon ?? $pengguna->telepon,
            'gender'   => $request->gender ?? $pengguna->gender,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => ['min:8']]);
            $data['password'] = Hash::make($request->password);
        }

        $pengguna->update($data);

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $pengguna): RedirectResponse
    {
        if ($pengguna->id === \Illuminate\Support\Facades\Auth::id()) {
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $hasActiveBorrowings = \App\Models\Borrowing::where('user_id', $pengguna->id)
            ->whereIn('status', ['booking', 'dipinjam'])
            ->exists();

        if ($hasActiveBorrowings) {
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Tidak dapat menghapus pengguna karena masih memiliki peminjaman aktif.');
        }

        $hasUnpaidFines = \App\Models\Fine::whereHas('borrowing', function ($query) use ($pengguna) {
            $query->where('user_id', $pengguna->id);
        })->where('paid', false)
          ->where(function ($q) {
              $q->where('payment_status', '!=', 'pending')->orWhereNull('payment_status');
          })->exists();

        if ($hasUnpaidFines) {
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Tidak dapat menghapus pengguna karena masih memiliki denda belum dibayar.');
        }

        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    // ─── Hak Akses ───────────────────────────────────────────────
    public function hakakses()
    {
        $petugas = User::where('role', 'penjaga')->get();
        return view('admin.pengguna.hak-akses', compact('petugas'));
    }

    public function hakaksesUpdate(Request $request, User $pengguna): RedirectResponse
    {
        $permissions = $request->input('permissions', []);

        $pengguna->update([
            'permissions' => json_encode($permissions),
        ]);

        return redirect()->route('admin.hakakses')
            ->with('success', 'Hak akses berhasil diperbarui.');
    }

    // ─── Verifikasi Anggota ───────────────────────────────────────
    public function verifikasi(Request $request)
    {
        $search    = $request->input('search');
        $tanggal   = $request->input('tanggal');
        $urutan    = $request->input('urutan', 'terbaru');

        $siswaQuery = User::where('role', 'siswa');

        // Statistik
        $totalPending = (clone $siswaQuery)->where('is_verified', false)->count();
        $totalAktif   = (clone $siswaQuery)->where('is_verified', true)->count();
        $totalDitolak = 0; // bisa dikembangkan di masa depan

        // Daftar pending dengan filter
        $pending = User::where('role', 'siswa')
            ->where('is_verified', false)
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%")
                       ->orWhere('username', 'like', "%$search%")
                       ->orWhere('email', 'like', "%$search%")
                       ->orWhere('telepon', 'like', "%$search%");
                });
            })
            ->when($tanggal, function ($q) use ($tanggal) {
                $q->whereDate('created_at', $tanggal);
            })
            ->when($urutan === 'terlama', function ($q) {
                $q->orderBy('created_at', 'asc');
            }, function ($q) {
                $q->orderBy('created_at', 'desc');
            })
            ->paginate(10)
            ->appends($request->all());

        return view('admin.verifikasi.index', compact(
            'pending', 'totalPending', 'totalAktif', 'totalDitolak',
            'search', 'tanggal', 'urutan'
        ));
    }

    public function verifikasiUpdate(User $pengguna): RedirectResponse
    {
        if ($pengguna->role !== 'siswa') {
            return redirect()->route('admin.verifikasi')
                ->with('error', 'Hanya akun siswa yang dapat diverifikasi.');
        }

        $pengguna->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        return redirect()->route('admin.verifikasi')
            ->with('success', "Akun @{$pengguna->username} berhasil diverifikasi.");
    }
}