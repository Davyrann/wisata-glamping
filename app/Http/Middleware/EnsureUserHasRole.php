<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk memastikan pengguna yang terautentikasi memiliki peran yang diizinkan.
 */
class EnsureUserHasRole
{
    /**
     * Tangani permintaan HTTP dan pastikan role pengguna cocok.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if ($user === null || ! in_array($user->role, $roles, true)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses area ini.');
        }

        return $next($request);
    }
}
