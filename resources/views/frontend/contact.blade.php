@extends('layouts.frontend')

@section('content')
<section style="padding: 120px 0 80px;">
    <div class="section-heading animate-on-scroll text-center" style="display: flex; flex-direction: column; align-items: center;">
        <span class="eyebrow">Get in touch</span>
        <h1>Contact Us</h1>
        <p style="color: var(--text-muted); font-size: 1.15rem; max-width: 600px; margin: 0 auto 48px;">Whether you have a question about features, pricing, or need technical support, our team is ready to answer all your questions.</p>
    </div>

    <div class="story-block" style="padding-top: 0; align-items: start;">
        <div class="glass-card animate-on-scroll">
            <h3 style="margin-top: 0;">Send us a message</h3>
            <form action="#" method="POST" style="margin-top: 24px; display: grid; gap: 20px;">
                @csrf
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 0.9rem;">Name</label>
                    <input type="text" name="name" required style="width: 100%; padding: 12px 16px; border-radius: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: white; outline: none;" placeholder="Jane Doe">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 0.9rem;">Email Address</label>
                    <input type="email" name="email" required style="width: 100%; padding: 12px 16px; border-radius: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: white; outline: none;" placeholder="jane@company.com">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 0.9rem;">Message</label>
                    <textarea name="message" rows="5" required style="width: 100%; padding: 12px 16px; border-radius: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--border); color: white; outline: none; font-family: inherit; resize: vertical;" placeholder="How can we help?"></textarea>
                </div>
                <button type="submit" class="button primary" style="width: 100%;">Send Message</button>
            </form>
        </div>

        <div class="story-copy animate-on-scroll delay-200">
            <h3>Direct Contact</h3>
            <p>Prefer to reach out directly? You can contact us via email.</p>
            
            <div style="margin-top: 32px;">
                <h4 style="margin-bottom: 8px;">Sales & Partnerships</h4>
                <a href="mailto:hello@printsilently.com" style="color: var(--accent); text-decoration: none; font-size: 1.1rem;">hello@printsilently.com</a>
            </div>
            
            <div style="margin-top: 32px;">
                <h4 style="margin-bottom: 8px;">Technical Support</h4>
                <a href="mailto:support@printsilently.com" style="color: var(--accent); text-decoration: none; font-size: 1.1rem;">support@printsilently.com</a>
            </div>

            <div style="margin-top: 48px; padding: 24px; border-radius: 16px; background: rgba(124, 92, 255, 0.1); border: 1px solid rgba(124, 92, 255, 0.2);">
                <h4 style="margin-top: 0; color: var(--text);">Enterprise Ready</h4>
                <p style="color: var(--text-muted); margin-bottom: 0; font-size: 0.95rem;">Need a custom SLA, dedicated infrastructure, or white-label desktop agent? Contact our sales team to discuss enterprise options.</p>
            </div>
        </div>
    </div>
</section>
@endsection
