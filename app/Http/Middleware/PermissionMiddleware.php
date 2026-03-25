<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (!Auth::check()) {
            abort(403);
        }

        $user = Auth::user();

        // Admin selalu punya semua akses
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Untuk Penjaga, cek permissions JSON array
        $perms = json_decode($user->permissions ?? '[]', true) ?? [];
        if (!in_array($permission, $perms)) {
            abort(403, 'Anda tidak memiliki hak akses untuk fitur ini.');
        }

        return $next($request);
    }
}
