@extends('layouts.frontend')

@section('content')
<section class="page-hero" style="padding-bottom: 40px;">
    <article class="glass-card animate-on-scroll reveal-scale" style="max-width: 800px; margin: 0 auto;" data-tilt>
        <span class="eyebrow">Legal</span>
        <h1 style="margin-top: 12px; font-size: 2.5rem; letter-spacing: -0.03em;">Privacy Policy</h1>
        <p style="color: var(--text-muted); font-size: 0.95rem;">Last updated: {{ date('F j, Y') }}</p>

        <div class="legal-content" style="margin-top: 40px; font-size: 1.05rem;">
            <p>At PrintSilently, we take your privacy seriously. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website, use our API, or install our desktop agent.</p>

            <h3>1. Information We Collect</h3>
            <p>We may collect information about you in a variety of ways, including:</p>
            <ul>
                <li><strong>Personal Data:</strong> Name, email address, and company details provided during registration.</li>
                <li><strong>Device Data:</strong> IP address, browser type, operating system, and printer metadata necessary for routing print jobs.</li>
                <li><strong>Print Job Data:</strong> We process print payloads (PDFs, ZPL, HTML) temporarily to route them to your local printers. All payloads are encrypted in transit and are not stored permanently.</li>
            </ul>

            <h3>2. How We Use Your Information</h3>
            <p>We use the information we collect to:</p>
            <ul>
                <li>Provide, operate, and maintain the PrintSilently platform.</li>
                <li>Process and route your print jobs securely.</li>
                <li>Improve our desktop agent and API performance.</li>
                <li>Communicate with you regarding account updates, security alerts, and support.</li>
            </ul>

            <h3>3. Data Security</h3>
            <p>We implement strict security measures to protect your data. All communication between the cloud API and the local desktop agent is secured using industry-standard TLS encryption. We do not permanently store your print payloads; they are transiently processed and deleted immediately upon successful delivery to the target printer.</p>

            <h3>4. Contact Us</h3>
            <p>If you have any questions about this Privacy Policy, please contact us at <a href="mailto:hello@printsilently.com" class="text-link">hello@printsilently.com</a>.</p>
        </div>
    </article>
</section>
@endsection
