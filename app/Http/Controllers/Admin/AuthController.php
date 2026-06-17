<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && (bool) Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials, (bool) $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid login credentials.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        if (! (bool) Auth::user()->is_admin) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Account is not authorized for admin access.',
            ])->onlyInput('email');
        }

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
