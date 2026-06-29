@extends('layouts.frontend')

@section('content')
<section class="hero page-hero">
    <div class="hero-copy animate-on-scroll">
        <span class="eyebrow">Platform Features</span>
        <h1>Everything you need for enterprise printing.</h1>
        <p>A complete suite of tools to bridge your cloud applications with local thermal label, ESC/POS, and ZPL printers seamlessly.</p>
    </div>
</section>

<section class="feature-grid" style="padding-top: 0;" data-stagger="80">
    @php
    $features = [
        ['icon' => 'M6 9V2h12v7 M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2 M6 14h12v8', 'title' => 'Silent Background Printing', 'desc' => 'Bypass the browser print dialog entirely. Send jobs directly to the local OS print spooler in milliseconds for a truly seamless user experience.'],
        ['icon' => 'M4 7V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v3 M4 7h16v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7z', 'title' => 'Thermal Label Support', 'desc' => 'Native support for 4x6 shipping labels, barcode labels, and thermal receipt printers without complicated driver setups or PDF conversions.'],
        ['icon' => 'M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z M14 2v6h6', 'title' => 'Zebra ZPL & ESC/POS', 'desc' => 'Send raw ZPL commands to Zebra printers or ESC/POS commands to receipt printers via our simple REST API bridge.'],
        ['icon' => 'M4 4h16v16H4z M9 9h6v6H9z', 'title' => 'Cross-Platform Agent', 'desc' => 'Our secure, lightweight desktop agent runs natively on both macOS and Windows, automatically detecting local and network printers.'],
        ['icon' => 'M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z', 'title' => 'Enterprise Security', 'desc' => 'End-to-end encrypted print payloads, device authentication, and zero-trust architecture ensure your data remains secure.'],
        ['icon' => 'M22 12h-4l-3 9L9 3l-3 9H2', 'title' => 'Real-time Status', 'desc' => 'Monitor printer status, queue depth, and job completion events in real-time via WebSockets or Webhooks.'],
        ['icon' => 'M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71 M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71', 'title' => 'Universal Integration', 'desc' => 'Integrate with any tech stack (PHP, Node.js, Python) or platform (Shopify, WooCommerce, custom ERPs) using our REST API.'],
        ['icon' => 'M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z', 'title' => 'Multi-Store Management', 'desc' => 'Manage multiple organizations, locations, and printer groups from a single centralized admin dashboard.'],
    ];
    @endphp

    @foreach($features as $feature)
    <article class="feature-card">
        <div class="feature-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="{{ $feature['icon'] }}"/></svg>
        </div>
        <h3>{{ $feature['title'] }}</h3>
        <p>{{ $feature['desc'] }}</p>
    </article>
    @endforeach
</section>

<section class="cta-banner animate-on-scroll" style="margin-bottom: 80px;">
    <div class="cta-banner-glow" aria-hidden="true"></div>
    <div class="cta-banner-inner">
        <h2 style="margin: 0 0 16px; font-weight: 800;">Ready to eliminate print dialogs?</h2>
        <p style="color: var(--text-muted); font-size: 1.15rem; margin-bottom: 32px;">Join thousands of businesses streamlining their logistics with PrintSilently.</p>
        <div style="display: flex; justify-content: center; gap: 16px; flex-wrap: wrap;">
            <a class="button primary" href="{{ route('register') }}">Create Free Account</a>
            <a class="button secondary" href="{{ route('pages.api-docs') }}">Read the Docs</a>
        </div>
    </div>
</section>
@endsection
