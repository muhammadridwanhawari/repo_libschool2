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
        $search = $request->get('search');

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
            'telepon'      => 'nullable|string|max:20',
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
            'nik'           => $request->nik ?? '',
            'telepon'       => $request->telepon ?? '',
            'gender'        => $request->gender ?? 'Laki-laki',
            'tanggal_lahir' => $request->tanggal_lahir ?? now()->toDateString(),
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
            'telepon'  => 'nullable|string|max:20',
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
        if ($pengguna->id === auth()->id()) {
            return redirect()->route('admin.pengguna.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
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
}