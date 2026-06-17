@extends('admin.layouts.app')

@section('title', 'Register Organization')

@section('content')
<div class="panel" style="max-width: 600px; margin: 0 auto;">
    <div class="panel-header">
        <h3 class="panel-title">Organization Details</h3>
    </div>

    <form method="POST" action="{{ route('admin.organizations.store') }}">
        @csrf
        
        <div class="form-group">
            <label class="form-label" for="name">Organization Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required placeholder="e.g. Acme Corp">
            @error('name')
                <div style="color: var(--danger-color); font-size: 0.75rem; margin-top: 6px;">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="domain">Allowed Domain (Optional)</label>
            <input type="text" id="domain" name="domain" class="form-control" value="{{ old('domain') }}" placeholder="e.g. acme.com">
            <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 6px;">
                Restricts user registration and API requests to this domain if specified.
            </div>
            @error('domain')
                <div style="color: var(--danger-color); font-size: 0.75rem; margin-top: 6px;">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top: 32px; display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('admin.organizations.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Register Organization</button>
        </div>
    </form>
</div>
@endsection
