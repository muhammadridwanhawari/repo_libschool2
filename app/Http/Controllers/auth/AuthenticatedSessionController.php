<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
        } catch (ValidationException $exception) {
            return back()
                ->withErrors($exception->errors())
                ->withInput($request->only('username'))
                ->with('login_popup', $request->lockoutPayload());
        }

        $request->session()->regenerate();

        $role = Auth::user()->role;

        return match($role) {
            'admin'   => redirect()->route('admin.dashboard'),
            'penjaga' => redirect()->route('penjaga.dashboard'),
            'siswa'   => redirect()->route('siswa.halaman'),
            default   => redirect('/'),
        };
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
