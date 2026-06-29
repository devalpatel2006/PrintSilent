@extends('layouts.frontend')

@section('content')
<section class="faq page-hero">
    <div class="section-heading animate-on-scroll">
        <span class="eyebrow">Support & Help</span>
        <h1>Frequently Asked Questions</h1>
        <p style="color: var(--text-muted); font-size: 1.15rem; max-width: 600px; margin: 0 auto;">Find answers to common questions about PrintSilently, setup, and integrations.</p>
    </div>

    <div class="faq-accordion animate-on-scroll" style="margin-top: 48px;">
        @foreach($faqs as $index => $faq)
        <div class="faq-accordion-item{{ $index === 0 ? ' is-open' : '' }}">
            <button class="faq-trigger" type="button" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                {{ $faq['question'] }}
                <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="faq-panel" style="{{ $index === 0 ? 'max-height: 200px;' : '' }}">
                <div class="faq-panel-inner">{{ $faq['answer'] }}</div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<section style="text-align: center; padding-bottom: 80px;">
    <div class="glass-card animate-on-scroll reveal-scale" style="display: inline-block; padding: 48px; max-width: 600px;" data-tilt>
        <h3 style="margin-top: 0;">Still have questions?</h3>
        <p style="color: var(--text-muted); margin-bottom: 24px;">Our support team is here to help you integrate silent printing into your workflow.</p>
        <a class="button primary" href="{{ route('pages.contact') }}">Contact Support</a>
    </div>
</section>
@endsection
