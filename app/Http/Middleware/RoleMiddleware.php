<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        // kalau belum login, biarkan auth middleware yang handle
        // if (!$user) {
        //     return redirect()->route('login');
        // }

        if (!$user) {
            abort(401);
        }


        $slug = optional($user->role)->slug;

        // kalau user tidak punya role atau role tidak sesuai
        // if (!$slug || !in_array($slug, $roles, true)) {
        //     // Jangan redirect ke /dashboard, lebih jelas 403
        //     abort(403, 'Kamu tidak punya akses ke halaman admin.');
        // }

        if (!$slug || !in_array($slug, $roles, true)) {
            abort(403, 'Unauthorized');
        }


        return $next($request);
    }
}
