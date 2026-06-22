<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Please login to access the dashboard.',
            ]);
        }

        return $next($request);
    }
}
