<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check() || ! (bool) Auth::user()->is_admin) {
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Please login with an admin account.',
            ]);
        }

        return $next($request);
    }
}
