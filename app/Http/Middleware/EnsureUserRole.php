<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! $user->role) {
            abort(403, 'Akses ditolak. Role pengguna tidak ditemukan.');
        }

        if (! in_array($user->role->slug, $roles, true)) {
            abort(403, 'Akses ditolak untuk role ini.');
        }

        return $next($request);
    }
}
