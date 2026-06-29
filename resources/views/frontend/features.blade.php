@extends('layouts.frontend')

@section('content')
<section class="hero" style="min-height: 50vh; padding: 120px 0 60px;">
    <div class="hero-copy animate-on-scroll">
        <span class="eyebrow">Platform Features</span>
        <h1>Everything you need for enterprise printing.</h1>
        <p>A complete suite of tools to bridge your cloud applications with local thermal label, ESC/POS, and ZPL printers seamlessly.</p>
    </div>
</section>

<section class="feature-grid" style="padding-top: 0;">
    <article class="feature-card animate-on-scroll delay-100">
        <h3>Silent Background Printing</h3>
        <p>Bypass the browser print dialog entirely. Send jobs directly to the local OS print spooler in milliseconds for a truly seamless user experience.</p>
    </article>
    <article class="feature-card animate-on-scroll delay-200">
        <h3>Thermal Label Support</h3>
        <p>Native support for 4x6 shipping labels, barcode labels, and thermal receipt printers without complicated driver setups or PDF conversions.</p>
    </article>
    <article class="feature-card animate-on-scroll delay-300">
        <h3>Zebra ZPL & ESC/POS</h3>
        <p>Send raw ZPL commands to Zebra printers or ESC/POS commands to receipt printers via our simple REST API bridge.</p>
    </article>
    <article class="feature-card animate-on-scroll delay-400">
        <h3>Cross-Platform Agent</h3>
        <p>Our secure, lightweight desktop agent runs natively on both macOS and Windows, automatically detecting local and network printers.</p>
    </article>
    <article class="feature-card animate-on-scroll delay-100">
        <h3>Enterprise Security</h3>
        <p>End-to-end encrypted print payloads, device authentication, and zero-trust architecture ensure your data remains secure.</p>
    </article>
    <article class="feature-card animate-on-scroll delay-200">
        <h3>Real-time Status</h3>
        <p>Monitor printer status, queue depth, and job completion events in real-time via WebSockets or Webhooks.</p>
    </article>
    <article class="feature-card animate-on-scroll delay-300">
        <h3>Universal Integration</h3>
        <p>Integrate with any tech stack (PHP, Node.js, Python) or platform (Shopify, WooCommerce, custom ERPs) using our REST API.</p>
    </article>
    <article class="feature-card animate-on-scroll delay-400">
        <h3>Multi-Store Management</h3>
        <p>Manage multiple organizations, locations, and printer groups from a single centralized admin dashboard.</p>
    </article>
</section>

<section class="pricing" style="text-align: center; padding-bottom: 120px;">
    <div class="section-heading animate-on-scroll">
        <h2>Ready to eliminate print dialogs?</h2>
        <p style="color: var(--text-muted); font-size: 1.15rem; margin-bottom: 32px;">Join thousands of businesses streamlining their logistics with PrintSilently.</p>
        <div style="display: flex; justify-content: center; gap: 16px;">
            <a class="button primary" href="{{ route('register') }}">Create Free Account</a>
            <a class="button secondary" href="{{ route('pages.api-docs') }}">Read the Docs</a>
        </div>
    </div>
</section>
@endsection
