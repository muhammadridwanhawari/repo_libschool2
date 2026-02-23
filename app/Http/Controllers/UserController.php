<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'username' => $request->username,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        $role = Auth::user()->role;
        return match($role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'penjaga' => redirect()->route('penjaga.dashboard'),
            default   => redirect()->route('siswa.dashboard'),
        };
    }
}