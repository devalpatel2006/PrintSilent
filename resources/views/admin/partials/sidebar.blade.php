<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-icon">SP</div>
        <div style="display: flex; flex-direction: column;">
            <span>Dashboard</span>
            <span
                style="font-size: 0.7rem; padding: 2px 6px; border-radius: 4px; background: rgba(255,255,255,0.1); margin-top: 4px; display: inline-block; width: fit-content; color: var(--text-muted);">
                {{ auth()->user()->is_admin ? 'Super Admin' : 'User' }}
            </span>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}"
            class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            Dashboard
        </a>
        @if(auth()->user()->is_admin)
        <a href="{{ route('admin.organizations.index') }}"
            class="nav-item {{ request()->routeIs('admin.organizations.*') ? 'active' : '' }}">

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            Organizations
        </a>
        <a href="{{ route('admin.visitors.index') }}"
            class="nav-item {{ request()->routeIs('admin.visitors.*') ? 'active' : '' }}">

            <svg stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            Visitors
        </a>
        @endif

        @if(auth()->user()->is_admin)
        <a href="{{ route('admin.contacts.index') }}"
            class="nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a4 4 0 0 1-4 4H7l-4 4V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"></path>
            </svg>
            Contact Messages
        </a>
        @endif

        <a href="{{ route('admin.profile.edit') }}"
            class="nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            Profile
        </a>
        <a href="{{ route('admin.api-keys.index') }}"
            class="nav-item {{ request()->routeIs('admin.api-keys.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4">
                </path>
            </svg>
            Tokens (API Keys)
        </a>
        <a href="{{ route('admin.playground.index') }}"
            class="nav-item {{ request()->routeIs('admin.playground.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 20v-6m0 0V4m0 6h8m-8 0H4"></path>
            </svg>
            Playground
        </a>
        <a href="{{ route('admin.api-docs.index') }}"
            class="nav-item {{ request()->routeIs('admin.api-docs.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
                <polyline points="10 9 9 9 8 9"></polyline>
            </svg>
            API Docs
        </a>
    </nav>
</aside>