@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="margin: 0; font-size: 1.5rem; font-weight: 700;">Welcome, {{ auth()->user()->name }}</h2>
    <p style="margin: 4px 0 0; color: var(--text-secondary); font-size: 0.9rem;">
        @if(auth()->user()->is_admin)
            Here is the global overview of the entire platform.
        @else
            Here is the overview of your organizations and resources.
        @endif
    </p>
</div>

<div class="stats-grid">
    @foreach($stats as $key => $value)
        <div class="stat-card">
            <div class="stat-title">{{ str_replace('_', ' ', $key) }}</div>
            <div class="stat-value">{{ number_format($value) }}</div>
            <div style="position: absolute; right: -10px; bottom: -20px; opacity: 0.1;">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
            </div>
        </div>
    @endforeach
</div>

<div class="form-grid">
    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title">Recent Organizations</h3>
            <a href="{{ route('admin.organizations.index') }}" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.75rem;">View All</a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($organizations as $org)
                    <tr>
                        <td>
                            <div style="font-weight: 500;">{{ $org->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $org->slug }}</div>
                        </td>
                        <td>{{ $org->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title">Recent API Keys</h3>
            <a href="{{ route('admin.api-keys.index') }}" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.75rem;">View All</a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Last Used</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($apiKeys as $key)
                    <tr>
                        <td>
                            <div style="font-weight: 500;">{{ $key->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary); font-family: monospace;">{{ substr($key->public_key, 0, 12) }}...</div>
                        </td>
                        <td>
                            @if($key->revoked)
                                <span class="badge inactive">Revoked</span>
                            @else
                                <span class="badge active">Active</span>
                            @endif
                        </td>
                        <td>{{ $key->last_used_at ? $key->last_used_at->diffForHumans() : 'Never' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
