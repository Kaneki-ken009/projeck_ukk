<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // 1️⃣ Belum login → balik ke landing
        if (!auth()->check()) {
            return redirect('/')->with('showLogin', true);
        }

        // 2️⃣ Login tapi role salah
        if (auth()->user()->role !== $role) {
            return match (auth()->user()->role) {
                'admin' => redirect('/admin'),
                'siswa' => redirect('/'),
                default => abort(403),
            };
        }

        // 3️⃣ Role sesuai → lanjut
        return $next($request);
    }
}