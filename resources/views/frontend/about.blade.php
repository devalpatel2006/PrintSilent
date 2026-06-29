@extends('layouts.frontend')

@section('content')
<section class="hero page-hero">
    <div class="hero-copy animate-on-scroll">
        <span class="eyebrow">Our Mission</span>
        <h1>We build the bridge between the cloud and the physical world.</h1>
        <p>PrintSilently was born out of frustration with browser print dialogs, Java applets, and unreliable local printer bridges. We believe enterprise printing should be invisible, instantaneous, and secure.</p>
    </div>
</section>

<section class="story-block" style="padding-bottom: 80px;">
    <div class="story-copy reveal-left">
        <h2>Why we built PrintSilently</h2>
        <p>For years, web applications have struggled to interact with local hardware. E-commerce platforms, POS systems, and hospital management software all require reliable, silent printing. But browsers strictly sandbox this capability.</p>
        <p style="margin-top: 16px;">The industry standard involved clunky Java applets, complex network configurations, or outdated tools like QZ Tray. We decided to build a modern, API-first alternative. A lightweight native agent written in memory-safe languages, paired with a globally distributed cloud API.</p>
        <p style="margin-top: 16px;">Today, PrintSilently processes thousands of print jobs silently in the background, powering logistics, retail, and healthcare businesses worldwide.</p>
    </div>

    <div class="glass-card reveal-right" data-tilt style="display: flex; flex-direction: column; justify-content: center; padding: 48px;">
        <h3 style="margin-top: 0; color: var(--accent-2);">Our Core Values</h3>
        <ul style="color: var(--text-muted); line-height: 1.8; margin-top: 24px; padding-left: 20px; font-size: 1.05rem;">
            <li style="margin-bottom: 12px;"><strong>Developer Experience:</strong> APIs should be intuitive, well-documented, and quick to integrate.</li>
            <li style="margin-bottom: 12px;"><strong>Zero-Trust Security:</strong> Local network access requires strict authentication and encryption.</li>
            <li style="margin-bottom: 12px;"><strong>Invisibility:</strong> The best software gets out of the user's way. No dialogs, no popups.</li>
            <li><strong>Reliability:</strong> Print jobs are mission-critical. We architect for redundancy and automatic retries.</li>
        </ul>
    </div>
</section>
@endsection
