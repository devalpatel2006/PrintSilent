<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('components.seo.meta-tags')

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <link rel="preload" href="{{ asset('css/frontend.css') }}" as="style" />
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}" />

    <link rel="icon" href="{{ asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" href="{{ asset('images/logo.jpg') }}" />

    @include('components.seo.json-ld')

    @stack('head')
</head>

<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <div class="bg-mesh" aria-hidden="true"></div>
    <div class="bg-grid" aria-hidden="true"></div>
    <div class="bg-orb orb-1" aria-hidden="true"></div>
    <div class="bg-orb orb-2" aria-hidden="true"></div>
    <div class="bg-orb orb-3" aria-hidden="true"></div>

    <div class="page-shell">
        <header class="topbar" role="banner">
            <a href="{{ route('home') }}" class="brand" aria-label="Print Silently for Modern Businesses — Home">
                <span class="brand-logo-wrap">
                    <img src="{{ asset('images/logo.jpg') }}" alt="PrintSilently Logo" width="48" height="48"
                        fetchpriority="high" />
                    <span class="brand-logo-glow" aria-hidden="true"></span>
                </span>
                <div>
                    <p class="brand-label">Print Silently</p>
                    <span class="brand-tag">Seamless eCommerce</span>
                </div>
            </a>

            <nav class="nav-links" role="navigation" aria-label="Main navigation">
                <a href="{{ route('pages.features') }}" @if(request()->routeIs('pages.features')) aria-current="page"
                    @endif>Features</a>
                <a href="{{ route('pages.pricing') }}" @if(request()->routeIs('pages.pricing')) aria-current="page"
                    @endif>Pricing</a>
                <a href="{{ route('pages.download') }}" @if(request()->routeIs('pages.download')) aria-current="page"
                    @endif>Download</a>
                <a href="{{ route('pages.api-docs') }}" @if(request()->routeIs('pages.api-docs')) aria-current="page"
                    @endif>API</a>
                <a href="{{ route('pages.faq') }}" @if(request()->routeIs('pages.faq')) aria-current="page"
                    @endif>FAQ</a>
            </nav>

            <div class="nav-actions">
                <a href="{{ route('login') }}" class="nav-signin">Sign in</a>
                <a class="button primary nav-cta" href="{{ route('register') }}">
                    <span>Get Started</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        aria-hidden="true">
                        <path d="M5 12h14M13 6l6 6-6 6" />
                    </svg>
                </a>
                <button class="ghost-btn icon-btn" id="themeToggle" type="button" aria-label="Toggle dark/light theme"
                    aria-pressed="false"></button>
                <button class="menu-toggle" id="menuToggle" type="button" aria-label="Open menu" aria-expanded="false"
                    aria-controls="mobileNav">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </header>

        <div class="mobile-overlay" id="mobileOverlay" aria-hidden="true"></div>
        <nav class="mobile-nav" id="mobileNav" aria-label="Mobile navigation">
            <div class="mobile-nav-header">
                <span class="mobile-nav-title">Menu</span>
            </div>
            <a href="{{ route('pages.features') }}">Features</a>
            <a href="{{ route('pages.pricing') }}">Pricing</a>
            <a href="{{ route('pages.download') }}">Download</a>
            <a href="{{ route('pages.api-docs') }}">API Docs</a>
            <a href="{{ route('pages.faq') }}">FAQ</a>
            <a href="{{ route('pages.contact') }}">Contact</a>
            <div class="mobile-nav-actions">
                <a href="{{ route('login') }}" class="button secondary">Sign in</a>
                <a href="{{ route('register') }}" class="button primary">Get Started</a>
            </div>
        </nav>

        <main id="main-content" role="main">
            @yield('content')
        </main>

        <footer class="footer" role="contentinfo">
            <div class="footer-glow" aria-hidden="true"></div>

            <div class="footer-cta animate-on-scroll">
                <div class="footer-cta-copy">
                    <span class="eyebrow">Ready to print silently?</span>
                    <h2>Start free — upgrade when you scale.</h2>
                    <p>Connect your cloud apps to local printers in minutes. No credit card required.</p>
                </div>
                <div class="footer-cta-actions">
                    <a class="button primary" href="{{ route('register') }}">Create Free Account</a>
                    <a class="button secondary" href="{{ route('pages.download') }}">Download Agent</a>
                </div>
            </div>

            <div class="footer-grid">
                <div class="footer-brand-col animate-on-scroll">
                    <p class="footer-title">Print Silently</p>
                    <p class="footer-desc">Seamless eCommerce. Effortless shipping. Background printing for Cloud, ERP,
                        POS, and logistics.</p>
                    <div class="footer-social">
                        <a href="mailto:hello@printsilently.com" aria-label="Email us">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </a>
                    </div>
                </div>

                <nav class="footer-col animate-on-scroll delay-100" aria-label="Product links">
                    <p class="footer-col-title">Product</p>
                    <a href="{{ route('pages.features') }}">Features</a>
                    <a href="{{ route('pages.pricing') }}">Pricing</a>
                    <a href="{{ route('pages.download') }}">Download</a>
                    <a href="{{ route('pages.api-docs') }}">API Docs</a>
                </nav>

                <nav class="footer-col animate-on-scroll delay-200" aria-label="Company links">
                    <p class="footer-col-title">Company</p>
                    <a href="{{ route('pages.about') }}">About</a>
                    <a href="{{ route('pages.faq') }}">FAQ</a>
                    <a href="{{ route('pages.contact') }}">Contact</a>
                </nav>

                <nav class="footer-col animate-on-scroll delay-300" aria-label="Legal links">
                    <p class="footer-col-title">Legal</p>
                    <a href="{{ route('pages.privacy') }}">Privacy Policy</a>
                    <a href="{{ route('pages.terms') }}">Terms of Service</a>
                </nav>
            </div>

            <div class="footer-bottom">
                <p class="footer-copyright">&copy; {{ date('Y') }} PrintSilently. All rights reserved.</p>
                <p class="footer-tagline">Built for teams who never want to see a print dialog again.</p>
            </div>
        </footer>
    </div>

    <button class="back-to-top" id="backToTop" type="button" aria-label="Back to top">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="18 15 12 9 6 15" />
        </svg>
    </button>

    <script src="{{ asset('js/frontend.js') }}" defer></script>
    @stack('scripts')
</body>

</html>