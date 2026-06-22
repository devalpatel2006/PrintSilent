@extends('admin.layouts.app')

@section('title', 'Organizations')

@section('content')
<div class="panel">
    <div class="panel-header">
        <h3 class="panel-title">All Organizations</h3>
        @if(auth()->user()->is_admin)
        <a href="{{ route('admin.organizations.create') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Register Organization
        </a>
        @endif
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name / Domain</th>
                    <th>Slug</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($organizations as $org)
                <tr>
                    <td>{{ $org->id }}</td>
                    <td>
                        <div style="font-weight: 500;">{{ $org->name }}</div>
                        @if($org->domain)
                            <div style="font-size: 0.75rem; color: var(--text-secondary);">{{ $org->domain }}</div>
                        @endif
                    </td>
                    <td><span class="badge" style="background: rgba(255,255,255,0.1); color: var(--text-primary);">{{ $org->slug }}</span></td>
                    <td>{{ $org->created_at->format('M d, Y H:i') }}</td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            @if(auth()->user()->is_admin)
                            <form method="POST" action="{{ route('admin.organizations.destroy', $org) }}" onsubmit="return confirm('Are you sure you want to delete this organization?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 4px 8px; font-size: 0.75rem;">Delete</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-secondary);">
                        No organizations found. Register one to get started.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
