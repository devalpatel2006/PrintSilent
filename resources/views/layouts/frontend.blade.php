<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  {{-- SEO Meta Tags --}}
  @include('components.seo.meta-tags')

  {{-- Preconnect for Performance --}}
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  {{-- Font Loading with display=swap for CWV --}}
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

  {{-- Preload Critical CSS --}}
  <link rel="preload" href="{{ asset('css/frontend.css') }}" as="style" />
  <link rel="stylesheet" href="{{ asset('css/frontend.css') }}" />

  {{-- Favicon --}}
  <link rel="icon" href="{{ asset('favicon.ico') }}" />
  <link rel="apple-touch-icon" href="{{ asset('images/logo.jpg') }}" />

  {{-- JSON-LD Structured Data --}}
  @include('components.seo.json-ld')

  @stack('head')
</head>
<body>
  {{-- Skip to main content — Accessibility --}}
  <a href="#main-content" class="skip-link">Skip to main content</a>

  <div class="bg-orb orb-1" aria-hidden="true"></div>
  <div class="bg-orb orb-2" aria-hidden="true"></div>

  <div class="page-shell">
    {{-- ─── Site Header ─────────────────────────────────────────── --}}
    <header class="topbar" role="banner">
      <a href="{{ route('home') }}" class="brand" aria-label="PrintSilently — Home">
        <img src="{{ asset('images/logo.jpg') }}" alt="PrintSilently Logo" width="48" height="48" style="border-radius: 8px;" fetchpriority="high" />
        <div>
          <p class="brand-label">Print Silently</p>
          <span class="brand-tag">Seamless eCommerce</span>
        </div>
      </a>

      <nav class="nav-links" role="navigation" aria-label="Main navigation">
        <a href="{{ route('pages.features') }}" @if(request()->routeIs('pages.features')) aria-current="page" @endif>FEATURES</a>
        <a href="{{ route('pages.pricing') }}" @if(request()->routeIs('pages.pricing')) aria-current="page" @endif>PRICING</a>
        <a href="{{ route('pages.download') }}" @if(request()->routeIs('pages.download')) aria-current="page" @endif>DOWNLOAD</a>
        <a href="{{ route('pages.api-docs') }}" @if(request()->routeIs('pages.api-docs')) aria-current="page" @endif>API</a>
        <a href="{{ route('pages.faq') }}" @if(request()->routeIs('pages.faq')) aria-current="page" @endif>FAQ</a>
      </nav>

      <div class="nav-actions">
        <a href="{{ route('login') }}" style="color: var(--text); text-decoration: none; font-weight: 500; margin-right: 12px;">Sign in</a>
        <a class="button primary" href="{{ route('register') }}">Get Started</a>
        <button class="ghost-btn" id="themeToggle" aria-label="Toggle dark/light theme">Dark</button>
      </div>
    </header>

    {{-- ─── Main Content ────────────────────────────────────────── --}}
    <main id="main-content" role="main">
      {{-- Breadcrumbs --}}
      @if(!empty($seo['breadcrumbs']) && count($seo['breadcrumbs']) > 1)
        <nav class="breadcrumbs" aria-label="Breadcrumb">
          <ol itemscope itemtype="https://schema.org/BreadcrumbList">
            @foreach($seo['breadcrumbs'] as $index => $crumb)
              <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                @if(!empty($crumb['url']) && !$loop->last)
                  <a itemprop="item" href="{{ url($crumb['url']) }}">
                    <span itemprop="name">{{ $crumb['label'] }}</span>
                  </a>
                @else
                  <span itemprop="name" aria-current="page">{{ $crumb['label'] }}</span>
                @endif
                <meta itemprop="position" content="{{ $index + 1 }}" />
              </li>
            @endforeach
          </ol>
        </nav>
      @endif

      @yield('content')
    </main>

    {{-- ─── Site Footer ─────────────────────────────────────────── --}}
    <footer class="footer" role="contentinfo">
      <div>
        <p class="footer-title">Print Silently</p>
        <p>Seamless eCommerce. Effortless Shipping. Background printing for Cloud, ERP, POS, and logistics.</p>
      </div>
      <nav class="footer-links" aria-label="Footer navigation">
        <a href="{{ route('pages.features') }}">Features</a>
        <a href="{{ route('pages.pricing') }}">Pricing</a>
        <a href="{{ route('pages.download') }}">Download</a>
        <a href="{{ route('pages.api-docs') }}">API</a>
        <a href="{{ route('pages.faq') }}">FAQ</a>
        <a href="{{ route('pages.contact') }}">Contact</a>
        <a href="{{ route('pages.about') }}">About</a>
      </nav>
      <nav class="footer-links footer-legal" aria-label="Legal links">
        <a href="{{ route('pages.privacy') }}">Privacy Policy</a>
        <a href="{{ route('pages.terms') }}">Terms of Service</a>
      </nav>
      <p class="footer-copyright">&copy; {{ date('Y') }} PrintSilently. All rights reserved.</p>
    </footer>
  </div>

  <script>
    // Theme toggle
    const toggle = document.getElementById('themeToggle');
    if (toggle) {
      toggle.addEventListener('click', () => {
        document.documentElement.classList.toggle('light');
        toggle.textContent = document.documentElement.classList.contains('light') ? 'Dark' : 'Light';
      });
    }

    // Topbar scroll effect
    const topbar = document.querySelector('.topbar');
    if (topbar) {
      window.addEventListener('scroll', () => {
        topbar.classList.toggle('scrolled', window.scrollY > 20);
      }, { passive: true });
    }

    // Intersection Observer for scroll animations
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { root: null, rootMargin: '0px', threshold: 0.15 });

    document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));
  </script>

  @stack('scripts')
</body>
</html>
