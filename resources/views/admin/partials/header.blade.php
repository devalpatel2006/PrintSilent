<header class="top-header">
    <div class="header-left">
        <div class="page-title">@yield('title', 'Overview')</div>
    </div>
    <div class="header-right">
        <div class="user-profile">
            <div class="avatar">
                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>
            <span style="font-size: 0.875rem; font-weight: 500;">{{ Auth::user()->name ?? 'Admin' }}</span>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.75rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Logout
            </button>
        </form>
    </div>
</header>
