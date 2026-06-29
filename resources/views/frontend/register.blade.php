@extends('layouts.frontend')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card reveal-scale">
        <span class="eyebrow" style="margin-bottom: 16px;">Get started</span>
        <h1>Create your account</h1>
        <p class="subtitle">Set up your user and organization in one step — start printing in minutes.</p>

        @if($errors->any())
            <div class="error-message">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="7" stroke="currentColor" stroke-width="1.5"/><path d="M8 4.5v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="8" cy="11" r="0.75" fill="currentColor"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <div class="form-group">
                <label for="name">Full name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Jane Smith" required autofocus>
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="jane@company.com" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="Min 8 characters" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Re-enter password" required>
                </div>
            </div>

            <div class="form-divider"><span>Organization</span></div>

            <div class="form-group">
                <label for="organization_name">Organization name</label>
                <input id="organization_name" type="text" name="organization_name" value="{{ old('organization_name') }}" placeholder="Acme Logistics Inc." required>
            </div>

            <button type="submit" class="btn-submit">Create account</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
</div>
@endsection
