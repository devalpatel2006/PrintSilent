<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectAuthenticated();
        }

        return view('frontend.register');
    }

    /**
     * Handle user + organization registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255|unique:users,email',
            'password'          => 'required|string|min:8|confirmed',
            'organization_name' => 'required|string|max:255',
        ]);

        $user = null;

        DB::transaction(function () use ($request, &$user) {
            // Create the user
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'is_admin' => false,
            ]);

            // Create the organization
            $org = Organization::create([
                'name'   => $request->organization_name,
                'slug'   => Str::slug($request->organization_name) . '-' . Str::random(4),
                'domain' => null,
            ]);

            // Attach user as owner
            $org->users()->attach($user->id, ['role' => 'owner']);
        });

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the sign-in form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectAuthenticated();
        }

        return view('frontend.login');
    }

    /**
     * Handle sign-in.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return $this->redirectAuthenticated();
    }

    /**
     * Log out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Redirect based on role.
     */
    private function redirectAuthenticated()
    {
        return redirect()->route('admin.dashboard');
    }
}
