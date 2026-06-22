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

    @if(session('success'))
        <div class="alert alert-success animate-slide-in">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Organization</th>
                    <th>Token Name</th>
                    <th>Token Key</th>
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
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-family: monospace; color: var(--text-secondary); background: rgba(255,255,255,0.05); padding: 4px 8px; border-radius: 4px; letter-spacing: 2px;" id="token-display-{{ $key->id }}">
                                ••••••••••••••••••••••••••••••••
                            </span>
                            <!-- Hidden input holding actual token value -->
                            <input type="hidden" id="token-val-{{ $key->id }}" value="{{ $key->token ?? $key->public_key }}">
                            
                            <button type="button" class="btn btn-outline" style="padding: 4px 8px; font-size: 0.75rem;" onclick="copyToken('token-val-{{ $key->id }}', this)">
                                Copy
                            </button>
                        </div>
                    </td>
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

@push('scripts')
<script>
function copyToken(elementId, btn) {
    const el = document.getElementById(elementId);
    const textToCopy = el.value !== undefined ? el.value : el.innerText.trim();
    
    navigator.clipboard.writeText(textToCopy).then(() => {
        const originalText = btn.innerText;
        btn.innerText = 'Copied!';
        btn.style.borderColor = 'var(--success)';
        btn.style.color = 'var(--success)';
        
        setTimeout(() => {
            btn.innerText = originalText;
            btn.style.borderColor = '';
            btn.style.color = '';
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
}
</script>
@endpush

@endsection
