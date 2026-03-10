<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     * Jika user sudah login dan mencoba akses halaman guest (misal /login),
     * redirect ke dashboard sesuai role-nya.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $role = Auth::guard($guard)->user()->role;

                return match($role) {
                    'admin'   => redirect()->route('admin.dashboard'),
                    'penjaga' => redirect()->route('penjaga.dashboard'),
                    'siswa'   => redirect()->route('siswa.dashboard'),
                    default   => redirect('/'),
                };
            }
        }

        return $next($request);
    }
}
