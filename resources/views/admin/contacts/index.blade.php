@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')
<div class="page-header">
    <div class="page-title-group">
        <h1 class="page-title">Contact Messages</h1>
        <p class="page-subtitle">List of messages submitted from the Contact Us page.</p>
    </div>
</div>

<div class="card">
    <div class="card-header" style="padding: 20px 24px; border-bottom: 1px solid var(--border);">
        <h2 style="font-size: 1.1rem; margin: 0;">Recent Contacts</h2>
    </div>

    <div class="card-body p-0">
        @if($contacts->isEmpty())
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            <h3>No contact messages</h3>
            <p>Messages will appear here once users submit the Contact Us form.</p>
        </div>
        @else
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date / Time</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                    <tr>
                        <td>
                            <div style="white-space: nowrap;">{{ $contact->created_at->format('M d, Y') }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">
                                {{ $contact->created_at->format('H:i:s') }}</div>
                        </td>
                        <td>{{ $contact->name }}</td>
                        <td>
                            <a href="mailto:{{ $contact->email }}" class="text-link">{{ $contact->email }}</a>
                        </td>
                        <td style="max-width: 520px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                            title="{{ $contact->message }}">
                            {{ $contact->message }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    @if($contacts->hasPages())
    <div class="card-footer">
        {{ $contacts->links() }}
    </div>
    @endif
</div>
@endsection