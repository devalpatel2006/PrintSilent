@extends('layouts.frontend')

@section('content')
<section style="padding: 120px 0 80px; max-width: 800px; margin: 0 auto;">
    <article class="glass-card animate-on-scroll">
        <h1 style="margin-top: 0; font-size: 2.5rem; letter-spacing: -0.03em;">Terms of Service</h1>
        <p style="color: var(--text-muted); font-size: 0.95rem;">Last updated: {{ date('F j, Y') }}</p>
        
        <div style="color: var(--text-muted); line-height: 1.8; margin-top: 40px; font-size: 1.05rem;">
            <p>Welcome to PrintSilently. By accessing our website, using our API, or installing our desktop agent, you agree to be bound by these Terms of Service.</p>
            
            <h3 style="color: var(--text); margin: 32px 0 16px;">1. License & Acceptable Use</h3>
            <p>We grant you a non-exclusive, non-transferable, revocable license to use the PrintSilently desktop agent and API for your business operations. You agree not to use the service for any unlawful purpose, or in any way that interrupts, damages, or impairs the service.</p>

            <h3 style="color: var(--text); margin: 32px 0 16px;">2. Account Responsibilities</h3>
            <p>You are responsible for maintaining the confidentiality of your account credentials and API keys. You are fully responsible for all activities that occur under your account. Notify us immediately of any unauthorized use of your account.</p>

            <h3 style="color: var(--text); margin: 32px 0 16px;">3. Service Availability</h3>
            <p>While we strive for 99.99% uptime, we do not guarantee that the service will be uninterrupted or error-free. We reserve the right to modify, suspend, or discontinue the service (or any part thereof) at any time with or without notice.</p>

            <h3 style="color: var(--text); margin: 32px 0 16px;">4. Limitation of Liability</h3>
            <p>In no event shall PrintSilently be liable for any indirect, incidental, special, consequential or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from your access to or use of or inability to access or use the service.</p>
        </div>
    </article>
</section>
@endsection
