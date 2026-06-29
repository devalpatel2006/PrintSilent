@extends('layouts.frontend')

@section('content')

@if(session('success'))
<script>
window.addEventListener('DOMContentLoaded', () => {
    alert({
        {
            json_encode(session('success'))
        }
    });
});
</script>
@endif

@if(session('error'))
<script>
window.addEventListener('DOMContentLoaded', () => {
    alert({
        {
            json_encode(session('error'))
        }
    });
});
</script>
@endif

<section class="page-hero">
    <div class="section-heading animate-on-scroll">
        <span class="eyebrow">Get in touch</span>
        <h1>Contact Us</h1>
        <p style="color: var(--text-muted); font-size: 1.15rem; max-width: 600px; margin: 0 auto;">Whether you have a
            question about features, pricing, or need technical support, our team is ready to answer all your questions.
        </p>
    </div>
</section>

<section style="padding-bottom: 80px;">
    <div class="story-block" style="padding-top: 0; align-items: start;">
        <div class="glass-card reveal-left" data-tilt>
            <h3 style="margin-top: 0;">Send us a message</h3>
            <form action="{{ route('pages.contact.submit') }}" method="POST" class="contact-form"
                style="margin-top: 24px;">
                @csrf
                <div class="form-group">
                    <label for="contact-name">Name</label>
                    <input id="contact-name" type="text" name="name" required placeholder="Jane Doe">
                </div>
                <div class="form-group">
                    <label for="contact-email">Email Address</label>
                    <input id="contact-email" type="email" name="email" required placeholder="jane@company.com">
                </div>
                <div class="form-group">
                    <label for="contact-message">Message</label>
                    <textarea id="contact-message" name="message" rows="5" required
                        placeholder="How can we help?"></textarea>
                </div>
                <button type="submit" class="btn-submit">Send Message</button>
            </form>
        </div>

        <div class="story-copy reveal-right">
            <h3>Direct Contact</h3>
            <p>Prefer to reach out directly? You can contact us via email.</p>

            <div style="margin-top: 32px;">
                <h4 style="margin-bottom: 8px;">Sales & Partnerships</h4>
                <a href="mailto:hello@printsilently.com" class="text-link">hello@printsilently.com</a>
            </div>

            <div style="margin-top: 32px;">
                <h4 style="margin-bottom: 8px;">Technical Support</h4>
                <a href="mailto:support@printsilently.com" class="text-link">support@printsilently.com</a>
            </div>

            <div class="contact-info-card" style="margin-top: 48px;">
                <h4 style="margin-top: 0; color: var(--text);">Enterprise Ready</h4>
                <p style="color: var(--text-muted); margin-bottom: 0; font-size: 0.95rem;">Need a custom SLA, dedicated
                    infrastructure, or white-label desktop agent? Contact our sales team to discuss enterprise options.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection