@extends('layouts.frontend')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card narrow reveal-scale">
        <span class="eyebrow" style="margin-bottom: 16px;">Welcome back</span>
        <h1>Sign in to your account</h1>
        <p class="subtitle">Access your dashboard, printers, and API keys.</p>

        @if($errors->any())
            <div class="error-message">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/><path d="M8 4.5v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="8" cy="11" r="0.75" fill="currentColor"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="error-message" style="background: rgba(52,211,153,0.1); border-color: rgba(52,211,153,0.25); color: var(--success);">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/><path d="M5.5 8.5l2 2 3.5-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="jane@company.com" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Enter your password" required>
            </div>

            <div class="form-options">
                <label>
                    <input type="checkbox" name="remember" value="1"> Remember me
                </label>
            </div>

            <button type="submit" class="btn-submit">Sign in</button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}">Create one</a>
        </div>
    </div>
</div>
@endsection
