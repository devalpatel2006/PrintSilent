@extends('layouts.frontend')

@section('content')
<section class="hero" id="start">
    <div class="hero-copy animate-on-scroll">
        <span class="eyebrow">Enterprise printing reimagined</span>
        <h1>Silent printing for modern businesses.</h1>
        <p>Connect your web applications directly to local printers using our secure desktop bridge technology — instant, silent, and fully automated.</p>
        <div class="hero-actions">
            <a class="button primary" href="{{ route('register') }}">Get Started</a>
            <a class="button secondary" href="{{ route('pages.api-docs') }}">Get API key</a>
        </div>
    </div>

    <div class="hero-panel animate-on-scroll delay-200">
        <div class="panel-card glass-card">
            <div class="panel-header">
                <span class="status-pill">Live queue</span>
                <span class="status-chip">99.98% success</span>
            </div>
            <div class="panel-body">
                <div class="panel-row">
                    <div>
                        <p class="panel-number">14.8k</p>
                        <span>Jobs processed</span>
                    </div>
                    <div>
                        <p class="panel-number">23</p>
                        <span>Connected printers</span>
                    </div>
                </div>
                <div class="queue-list">
                    <div class="queue-item success">
                        <span>Invoice #A234</span>
                        <span>Thermal label &bull; Zebra ZD421</span>
                    </div>
                    <div class="queue-item warning">
                        <span>Batch 03</span>
                        <span>Retrying &bull; Warehouse A</span>
                    </div>
                    <div class="queue-item success">
                        <span>Prescription slip</span>
                        <span>Silent print &bull; Pharmacy</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="floating-card">
            <p class="floating-title">Cloud app</p>
            <div class="floating-detail">Secure communication tunnel</div>
        </div>
    </div>
</section>

<section id="download" class="download-section animate-on-scroll delay-100" style="padding: 80px 40px; margin: 40px 0; position: relative; border-radius: 32px; background: linear-gradient(135deg, rgba(124, 92, 255, 0.05), rgba(0, 211, 255, 0.05)); border: 1px solid var(--border); overflow: hidden;">
    <div style="position: absolute; top: -50%; left: -10%; width: 50%; height: 200%; background: radial-gradient(circle, rgba(124, 92, 255, 0.15), transparent 70%); filter: blur(60px); z-index: 0; pointer-events: none;" aria-hidden="true"></div>
    <div style="position: absolute; bottom: -50%; right: -10%; width: 50%; height: 200%; background: radial-gradient(circle, rgba(0, 211, 255, 0.15), transparent 70%); filter: blur(60px); z-index: 0; pointer-events: none;" aria-hidden="true"></div>
    
    <div style="position: relative; z-index: 1; text-align: center; max-width: 740px; margin: 0 auto;">
        <span class="eyebrow" style="margin-bottom: 24px;">Get Started</span>
        <h2 style="font-size: clamp(2.2rem, 3vw, 2.8rem); margin: 0 0 20px; font-weight: 800; letter-spacing: -0.03em;">Download our App</h2>
        <p style="color: var(--text-muted); font-size: 1.15rem; line-height: 1.8; margin-bottom: 44px;">Install the secure desktop client to instantly connect your local printers to your cloud web applications.</p>
        
        <div style="display: flex; justify-content: center; gap: 24px; flex-wrap: wrap;">
            <a class="button primary" href="{{ route('pages.download') }}" style="display: flex; align-items: center; gap: 12px; padding: 18px 36px; font-size: 1.1rem; box-shadow: 0 20px 40px rgba(124, 92, 255, 0.3);">
                View Downloads
            </a>
        </div>
    </div>
</section>

<section class="feature-grid" id="why">
    <article class="feature-card animate-on-scroll delay-100">
        <h3>Silent background printing</h3>
        <p>Print documents instantly without modal dialogs, keyboard interaction, or browser prompts.</p>
    </article>
    <article class="feature-card animate-on-scroll delay-200">
        <h3>Secure local bridge</h3>
        <p>Encrypted device pairing, token-based authorization, and zero-trust print delivery.</p>
    </article>
    <article class="feature-card animate-on-scroll delay-300">
        <h3>Universal integrations</h3>
        <p>Embed into ERP, POS, logistics, healthcare, warehouse, and SaaS systems with a single API.</p>
    </article>
    <article class="feature-card animate-on-scroll delay-400">
        <h3>Enterprise-ready</h3>
        <p>Role controls, audit logs, SLA monitoring, regional deployments and priority failover.</p>
    </article>
</section>

<section class="story-block" id="about">
    <div class="story-copy animate-on-scroll">
        <span class="eyebrow">Platform vision</span>
        <h2>From cloud event to local printer in milliseconds.</h2>
        <p>Print Silently is the infrastructure layer for background printing — a secure bridge between SaaS applications and local print hardware with intelligent routing, retry orchestration, and full enterprise control.</p>
        <div class="story-list">
            <div>
                <strong>One-Click E-commerce Integration</strong>
                <p>Connect Shopify, WooCommerce, Amazon, Flipkart, and other platforms to automatically receive and process orders.</p>
            </div>
            <div>
                <strong>Silent Background Printing</strong>
                <p>Print invoices, shipping labels, packing slips, and receipts instantly without any print dialog or user intervention.</p>
            </div>
        </div>
        <div style="margin-top: 32px;">
            <a href="{{ route('pages.features') }}" style="color: var(--accent); font-weight: 600; text-decoration: none;">View all features &rarr;</a>
        </div>
    </div>
    <div class="story-visual glass-card animate-on-scroll delay-200">
        <div class="visual-header"><span>Device pairing</span><span>Secure tunnel</span></div>
        <div class="visual-stack">
            <div class="stack-chip">ERP / CRM / POS</div>
            <div class="stack-chip">REST API</div>
            <div class="stack-chip">Desktop bridge</div>
            <div class="stack-chip">Local printers</div>
        </div>
    </div>
</section>

<section class="testimonial-section">
    <div class="section-heading">
        <span class="eyebrow">Built for customers</span>
        <h2>Operational teams trust Print Silently for mission-critical printing.</h2>
    </div>
    <div class="testimonial-grid">
        <article class="testimonial-card animate-on-scroll delay-100">
            <p>“Print Silently replaced our manual label printing flow and eliminated every browser dialog. The integration was seamless and instantly reliable.”</p>
            <footer>— Sarah Jain, CTO at LogisticsOne</footer>
        </article>
        <article class="testimonial-card animate-on-scroll delay-200">
            <p>“Our hospitals now print prescriptions and wristbands silently across 18 clinics with full auditing and device policies.”</p>
            <footer>— Marco Lee, IT Director at MediChain</footer>
        </article>
        <article class="testimonial-card animate-on-scroll delay-300">
            <p>“The API-first developer experience and device heartbeat monitoring give us confidence to scale globally.”</p>
            <footer>— Elena Ruiz, Head of Operations at SmartPOS</footer>
        </article>
    </div>
</section>
@endsection
