<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Membatasi akses route berdasarkan role pengguna.
 *
 * Contoh pemakaian di route:
 *   ->middleware('role:admin')
 *   ->middleware('role:admin,pemilik')   // salah satu role cukup
 */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Belum login -> arahkan ke halaman login.
        if (! $user) {
            return redirect()->route('login');
        }

        // Sudah login, tetapi role tidak sesuai -> tolak (403).
        if (! $user->hasRole(...$roles)) {
            abort(403, 'Kamu tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}