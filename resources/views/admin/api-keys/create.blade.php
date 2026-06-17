@extends('admin.layouts.app')

@section('title', 'Generate Token')

@section('content')
<div class="panel" style="max-width: 800px; margin: 0 auto;">
    <div class="panel-header">
        <h3 class="panel-title">Token Configuration</h3>
    </div>

    <form method="POST" action="{{ route('admin.api-keys.store') }}">
        @csrf
        
        <div class="form-grid">
            <div class="form-group form-grid-full">
                <label class="form-label" for="organization_id">Organization</label>
                <select id="organization_id" name="organization_id" class="form-control" required style="background: rgba(0,0,0,0.4);">
                    <option value="" disabled selected>Select an Organization</option>
                    @foreach($organizations as $org)
                        <option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>
                            {{ $org->name }} ({{ $org->slug }})
                        </option>
                    @endforeach
                </select>
                @error('organization_id')
                    <div style="color: var(--danger-color); font-size: 0.75rem; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="name">Token Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required placeholder="e.g. Production API Key">
                @error('name')
                    <div style="color: var(--danger-color); font-size: 0.75rem; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="expires_at">Expiration Date (Optional)</label>
                <input type="datetime-local" id="expires_at" name="expires_at" class="form-control" value="{{ old('expires_at') }}" style="color-scheme: dark;">
                @error('expires_at')
                    <div style="color: var(--danger-color); font-size: 0.75rem; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="rate_limit_per_minute">Rate Limit (req/min)</label>
                <input type="number" id="rate_limit_per_minute" name="rate_limit_per_minute" class="form-control" value="{{ old('rate_limit_per_minute', 120) }}" min="1" max="10000" required>
                @error('rate_limit_per_minute')
                    <div style="color: var(--danger-color); font-size: 0.75rem; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="abilities">Abilities (Comma Separated)</label>
                <input type="text" id="abilities" name="abilities" class="form-control" value="{{ old('abilities', 'read, write') }}" placeholder="read, write">
                <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 6px;">
                    Specific scopes or permissions granted to this token.
                </div>
                @error('abilities')
                    <div style="color: var(--danger-color); font-size: 0.75rem; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group form-grid-full">
                <label class="form-label" for="allowed_ips">Allowed IP Addresses (Optional)</label>
                <input type="text" id="allowed_ips" name="allowed_ips" class="form-control" value="{{ old('allowed_ips') }}" placeholder="e.g. 192.168.1.1, 10.0.0.0/24">
                <div style="font-size: 0.75rem; color: var(--text-secondary); margin-top: 6px;">
                    Comma separated list of IP addresses or CIDR blocks allowed to use this token. Leave blank to allow all IPs.
                </div>
                @error('allowed_ips')
                    <div style="color: var(--danger-color); font-size: 0.75rem; margin-top: 6px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div style="margin-top: 32px; display: flex; gap: 12px; justify-content: flex-end;">
            <a href="{{ route('admin.api-keys.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Generate Token</button>
        </div>
    </form>
</div>
@endsection
