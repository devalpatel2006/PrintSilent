@extends('layouts.frontend')

@section('content')
<section class="faq" style="padding: 120px 0 80px;">
    <div class="section-heading animate-on-scroll">
        <span class="eyebrow">Support & Help</span>
        <h1>Frequently Asked Questions</h1>
        <p style="color: var(--text-muted); font-size: 1.15rem; max-width: 600px; margin: 0 auto;">Find answers to common questions about PrintSilently, setup, and integrations.</p>
    </div>

    <div class="faq-grid" style="margin-top: 48px;">
        @foreach($faqs as $index => $faq)
            <div class="faq-item animate-on-scroll delay-{{ ($index % 4) * 100 }}">
                <h4>{{ $faq['question'] }}</h4>
                <p>{{ $faq['answer'] }}</p>
            </div>
        @endforeach
    </div>
</section>

<section style="text-align: center; padding-bottom: 120px;">
    <div class="glass-card animate-on-scroll" style="display: inline-block; padding: 48px; max-width: 600px;">
        <h3 style="margin-top: 0;">Still have questions?</h3>
        <p style="color: var(--text-muted); margin-bottom: 24px;">Our support team is here to help you integrate silent printing into your workflow.</p>
        <a class="button primary" href="{{ route('pages.contact') }}">Contact Support</a>
    </div>
</section>
@endsection
