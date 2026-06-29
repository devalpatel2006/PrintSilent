@extends('layouts.frontend')

@section('content')
<section class="download-section" style="padding: 120px 0 80px; text-align: center;">
    <div class="section-heading animate-on-scroll">
        <span class="eyebrow">Download Agent</span>
        <h1>Get the PrintSilently Agent</h1>
        <p style="color: var(--text-muted); font-size: 1.15rem; max-width: 600px; margin: 0 auto 40px;">Install the secure desktop client to connect your local printers to your cloud applications.</p>
        
        <div style="display: flex; justify-content: center; gap: 24px; flex-wrap: wrap;">
            <a class="button primary" href="{{ asset('mac/PrintSilently.dmg') }}" download style="display: flex; align-items: center; gap: 12px; padding: 18px 36px; font-size: 1.1rem; box-shadow: 0 20px 40px rgba(124, 92, 255, 0.3);">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download for Mac OS
            </a>
            <a class="button secondary" href="{{ asset('windows/PrintSilently.exe') }}" download style="display: flex; align-items: center; gap: 12px; padding: 18px 36px; font-size: 1.1rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download for Windows
            </a>
        </div>
    </div>
</section>

<section class="story-block" style="padding-bottom: 120px;">
    <div class="story-copy animate-on-scroll">
        <h2>Installation Guide</h2>
        <div class="story-list">
            <div>
                <strong>1. Download the Agent</strong>
                <p>Click the download link above for your operating system.</p>
            </div>
            <div>
                <strong>2. Install & Launch</strong>
                <p>Run the installer. Once installed, the PrintSilently agent will appear in your system tray or menu bar.</p>
            </div>
            <div>
                <strong>3. Sign In</strong>
                <p>Click on the tray icon and sign in with your PrintSilently account. Your local printers will automatically be synced to the cloud.</p>
            </div>
            <div>
                <strong>4. Start Printing</strong>
                <p>You can now send print jobs via our REST API. They will print instantly on your local machines.</p>
            </div>
        </div>
    </div>
    <div class="story-visual glass-card animate-on-scroll delay-200" style="display: flex; align-items: center; justify-content: center; min-height: 400px;">
        <div style="text-align: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 24px;"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
            <h3>Secure Desktop Bridge</h3>
            <p style="color: var(--text-muted);">Runs silently in the background.</p>
        </div>
    </div>
</section>
@endsection
