<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan halaman register
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses register user baru
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'name'           => 'required|string|max:255',
            'nik'            => 'nullable|string|max:20|unique:users',
            'username'       => 'required|string|max:255|unique:users',
            'email'          => 'required|string|email|max:255|unique:users',
            'telepon'        => 'required|string|regex:/^[0-9]+$/|max:20',
            'tanggal_lahir'  => 'required|date|before_or_equal:today|after:1900-01-01',
            'gender'         => 'required|in:Laki-laki,Perempuan',
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'required' => 'Kolom ini wajib di isi',
            'tanggal_lahir.before_or_equal' => 'Format atau tanggal lahir tidak sesuai batasan kalender',
            'tanggal_lahir.after'           => 'Format atau tanggal lahir tidak sesuai batasan kalender',
            'tanggal_lahir.date'            => 'Format atau tanggal lahir tidak sesuai batasan kalender',
            'password.confirmed'            => 'Konfirmasi kata sandi tidak cocok',
        ]);

        // Buat user baru
        $user = User::create([
            'name'           => $request->name,
            'nik'            => $request->nik,
            'username'       => $request->username,
            'email'          => $request->email,
            'telepon'        => $request->telepon,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'gender'         => $request->gender,
            'password'       => Hash::make($request->password),
            // default role bisa ditambahkan di sini kalau mau, misal: 'role' => 'siswa',
        ]);

        // Trigger event Registered (untuk listener/email verification)
        event(new Registered($user));

        // Login otomatis setelah register
        Auth::login($user);

        // Redirect berdasarkan role
        $role = Auth::user()->role;
        return match($role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'penjaga' => redirect()->route('penjaga.dashboard'),
            default   => redirect()->route('siswa.halaman'),
        };
    }
}