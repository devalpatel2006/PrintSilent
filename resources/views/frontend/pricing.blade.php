@extends('layouts.frontend')

@section('content')
<section class="pricing" id="pricing" style="padding-top: 120px;">
    <div class="section-heading animate-on-scroll">
        <span class="eyebrow">Pricing Plans</span>
        <h1>Simple, transparent pricing.</h1>
        <p style="color: var(--text-muted); font-size: 1.15rem; max-width: 600px; margin: 0 auto 40px;">Choose the plan that fits your business. Start for free, upgrade when you need enterprise features.</p>
    </div>

    <div class="pricing-grid">
        <article class="price-card animate-on-scroll delay-100">
            <h3>Free</h3>
            <p>Perfect for startups and small businesses needing silent printing.</p>
            <p class="price">$0<span>/mo</span></p>
            <ul>
                <li>Unlimited print jobs</li>
                <li>Connect multiple stores</li>
                <li>Silent background printing</li>
                <li>PDF & Thermal labels</li>
                <li>Community support</li>
            </ul>
            <a class="button ghost" href="{{ route('register') }}">Get Started Free</a>
        </article>

        <article class="price-card recommended animate-on-scroll delay-200">
            <h3>White Label</h3>
            <p>Your own branded printing solution for your SaaS platform.</p>
            <p class="price">Custom</p>
            <ul>
                <li>Custom logo & branding</li>
                <li>Custom desktop installer</li>
                <li>Custom domain portal</li>
                <li>Dedicated API endpoints</li>
                <li>Priority email support</li>
                <li>Deployment assistance</li>
            </ul>
            <a class="button primary" href="{{ route('pages.contact') }}">Contact Sales</a>
        </article>

        <article class="price-card animate-on-scroll delay-300">
            <h3>Enterprise</h3>
            <p>Advanced security and infrastructure for large organizations.</p>
            <p class="price">Custom</p>
            <ul>
                <li>Unlimited organizations</li>
                <li>SSO & role management</li>
                <li>Dedicated infrastructure</li>
                <li>Advanced audit logs</li>
                <li>Custom SLA</li>
                <li>Dedicated account manager</li>
            </ul>
            <a class="button ghost" href="{{ route('pages.contact') }}">Request Quote</a>
        </article>
    </div>
</section>

<section class="faq" style="padding-bottom: 120px;">
    <div class="section-heading animate-on-scroll">
        <h2>Pricing FAQ</h2>
    </div>
    <div class="faq-grid">
        <div class="faq-item animate-on-scroll delay-100">
            <h4>Is the Free plan really free forever?</h4>
            <p>Yes, the Free plan has no time limit and allows unlimited print jobs for standard use cases. We only charge for premium features like White Labeling and Enterprise SLA.</p>
        </div>
        <div class="faq-item animate-on-scroll delay-200">
            <h4>Do I need a credit card to sign up?</h4>
            <p>No credit card is required to create an account and start using the Free plan.</p>
        </div>
        <div class="faq-item animate-on-scroll delay-300">
            <h4>How does White Labeling work?</h4>
            <p>We provide a custom version of the desktop agent compiled with your company's logo, name, and certificates, ensuring your customers never see the PrintSilently brand.</p>
        </div>
        <div class="faq-item animate-on-scroll delay-400">
            <h4>Can I upgrade later?</h4>
            <p>Absolutely. You can start on the Free plan and contact our sales team at any time to upgrade to White Label or Enterprise.</p>
        </div>
    </div>
</section>
@endsection
