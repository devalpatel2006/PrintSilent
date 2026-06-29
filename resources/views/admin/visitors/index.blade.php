@extends('admin.layouts.app')

@section('title', 'Visitor Tracking')

@section('content')
<div class="page-header">
    <div class="page-title-group">
        <h1 class="page-title">Visitor Analytics</h1>
        <p class="page-subtitle">View and manage all visitor records and geographical data.</p>
    </div>
    
    <div class="page-actions">
        @if($visitors->count() > 0)
            <form action="{{ route('admin.visitors.delete_all') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete all visitor records? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    Delete All Records
                </button>
            </form>
        @endif
    </div>
</div>

<div class="dashboard-stats" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 24px;">
    <div class="card" style="padding: 24px;">
        <h3 style="font-size: 0.9rem; color: var(--text-muted); margin-top: 0; margin-bottom: 16px;">Visitors Today</h3>
        <p style="font-size: 2rem; font-weight: 700; margin: 0; color: var(--text);">{{ number_format($visitorsToday) }}</p>
        <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 8px;">
            Yesterday: {{ number_format($visitorsYesterday) }}
        </p>
    </div>

    <div class="card" style="padding: 24px;">
        <h3 style="font-size: 0.9rem; color: var(--text-muted); margin-top: 0; margin-bottom: 16px;">Top Countries</h3>
        <ul style="list-style: none; padding: 0; margin: 0; font-size: 0.95rem;">
            @forelse($topCountries as $countryData)
                <li style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span>{{ $countryData->country ?: 'Unknown' }}</span>
                    <span style="font-weight: 600;">{{ number_format($countryData->total) }}</span>
                </li>
            @empty
                <li style="color: var(--text-muted);">No data available</li>
            @endforelse
        </ul>
    </div>
</div>

<div class="card">
    <div class="card-header" style="padding: 20px 24px; border-bottom: 1px solid var(--border);">
        <h2 style="font-size: 1.1rem; margin: 0;">Recent Log</h2>
    </div>
    <div class="card-body p-0">
        @if($visitors->isEmpty())
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                <h3>No visitors recorded</h3>
                <p>Visitor records will appear here once traffic arrives.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date / Time</th>
                            <th>IP Address</th>
                            <th>Country</th>
                            <th>Method</th>
                            <th>URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visitors as $visitor)
                        <tr>
                            <td>
                                <div style="white-space: nowrap;">{{ $visitor->created_at->format('M d, Y') }}</div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $visitor->created_at->format('H:i:s') }}</div>
                            </td>
                            <td>
                                <span style="font-family: monospace; font-size: 0.9rem;">{{ $visitor->ip_address ?? 'Unknown' }}</span>
                            </td>
                            <td>
                                <span>{{ $visitor->country ?? 'Unknown' }}</span>
                            </td>
                            <td>
                                <span class="badge badge-success">{{ $visitor->method }}</span>
                            </td>
                            <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $visitor->url }}">
                                {{ $visitor->url }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    
    @if($visitors->hasPages())
    <div class="card-footer">
        {{ $visitors->links() }}
    </div>
    @endif
</div>
@endsection
