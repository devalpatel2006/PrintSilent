@extends('admin.layouts.app')

@section('title', 'Profile Settings')

@section('content')
<div class="panel" style="max-width: 600px; margin: 0 auto;">
    <div class="panel-header">
        <h3 class="panel-title">Profile Details</h3>
    </div>

    <form method="POST" action="{{ route('admin.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="name">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div style="color: var(--danger-color); font-size: 0.75rem; margin-top: 6px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div style="color: var(--danger-color); font-size: 0.75rem; margin-top: 6px;">{{ $message }}</div>
            @enderror
        </div>

        <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 32px 0;">

        <div style="margin-bottom: 24px;">
            <h4 style="margin: 0 0 4px; font-size: 1rem; color: var(--text-primary);">Change Password</h4>
            <div style="font-size: 0.8rem; color: var(--text-secondary);">Leave these fields blank if you do not wish to change your password.</div>
        </div>

        <div class="form-group">
            <label class="form-label" for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" class="form-control">
            @error('current_password')
                <div style="color: var(--danger-color); font-size: 0.75rem; margin-top: 6px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">New Password</label>
            <input type="password" id="password" name="password" class="form-control">
            @error('password')
                <div style="color: var(--danger-color); font-size: 0.75rem; margin-top: 6px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Confirm New Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
        </div>

        <div style="margin-top: 32px; display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>
@endsection
