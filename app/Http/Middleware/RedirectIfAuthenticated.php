<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            $slug = Auth::user()?->role?->slug;

            if (in_array($slug, ['admin','superadmin'], true)) {
                return redirect('/admin/dashboard');
            }

            return redirect('/');
        }

        return $next($request);
    }
}
