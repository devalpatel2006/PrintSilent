@extends('admin.layouts.app')

@section('title', 'Tokens (API Keys)')

@section('content')
<div class="panel">
    <div class="panel-header">
        <h3 class="panel-title">All API Keys</h3>
        <a href="{{ route('admin.api-keys.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
            Generate Token
        </a>
    </div>

    @if(session('created_api_key'))
        <div class="alert alert-success animate-slide-in" style="flex-direction: column; align-items: flex-start; gap: 16px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3);">
            <div style="display: flex; align-items: center; gap: 12px; width: 100%;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #34d399;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <div style="font-weight: 600; font-size: 1.125rem;">Token Generated Successfully</div>
            </div>
            
            <div style="width: 100%; padding: 16px; background: rgba(0,0,0,0.3); border-radius: 8px;">
                <p style="margin-bottom: 12px; font-size: 0.875rem;">Please copy this secret key now. You will not be able to see it again!</p>
                <div class="secret-key-display">
                    {{ session('created_api_key')['secret'] }}
                </div>
            </div>
        </div>
    @endif

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Organization</th>
                    <th>Token Name</th>
                    <th>Public Key</th>
                    <th>Status</th>
                    <th>Last Used</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($apiKeys as $key)
                <tr>
                    <td>{{ $key->organization->name ?? 'N/A' }}</td>
                    <td style="font-weight: 500;">{{ $key->name }}</td>
                    <td style="font-family: monospace; color: var(--text-secondary);">{{ substr($key->public_key, 0, 16) }}...</td>
                    <td>
                        @if($key->revoked)
                            <span class="badge inactive">Revoked</span>
                        @elseif($key->expires_at && $key->expires_at->isPast())
                            <span class="badge inactive" style="background: rgba(245, 158, 11, 0.2); color: #fbbf24;">Expired</span>
                        @else
                            <span class="badge active">Active</span>
                        @endif
                    </td>
                    <td>{{ $key->last_used_at ? $key->last_used_at->diffForHumans() : 'Never' }}</td>
                    <td>
                        @if(!$key->revoked)
                        <form method="POST" action="{{ route('admin.api-keys.destroy', $key) }}" onsubmit="return confirm('Are you sure you want to revoke this token? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 4px 8px; font-size: 0.75rem;">Revoke</button>
                        </form>
                        @else
                        <span style="font-size: 0.75rem; color: var(--text-secondary);">No actions</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-secondary);">
                        No tokens generated yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
