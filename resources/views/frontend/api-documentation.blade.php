@extends('layouts.frontend')

@section('content')
<section style="padding: 120px 0 80px;">
    <div class="section-heading animate-on-scroll">
        <span class="eyebrow">Developer Hub</span>
        <h1>API Documentation</h1>
        <p style="color: var(--text-muted); font-size: 1.15rem; max-width: 600px; margin: 0 auto;">Integrate PrintSilently into your tech stack with our REST API.</p>
    </div>

    <div class="story-block" style="padding-top: 40px; align-items: start;">
        <div class="story-copy animate-on-scroll">
            <h3>Authentication</h3>
            <p>All API requests must be authenticated using a Bearer token. You can generate an API key from the <a href="{{ route('login') }}" style="color: var(--accent);">Admin Dashboard</a>.</p>
            
            <div style="background: rgba(0,0,0,0.5); padding: 16px; border-radius: 12px; margin-top: 16px; border: 1px solid var(--border); font-family: monospace; font-size: 0.9rem; color: var(--success);">
                Authorization: Bearer YOUR_API_KEY
            </div>

            <h3 style="margin-top: 40px;">Endpoints</h3>
            
            <div class="story-list" style="margin-top: 24px;">
                <div>
                    <strong>GET /api/v1/printers</strong>
                    <p>Retrieve a list of all connected printers across your organization.</p>
                </div>
                <div>
                    <strong>POST /api/v1/print</strong>
                    <p>Send a print job to a specific printer.</p>
                    <pre style="background: rgba(0,0,0,0.5); padding: 16px; border-radius: 8px; margin-top: 12px; border: 1px solid rgba(255,255,255,0.05); overflow-x: auto; color: var(--text-muted);">
{
  "printer_id": "prn_123456",
  "document_type": "pdf",
  "document_url": "https://example.com/invoice.pdf",
  "options": {
    "copies": 1,
    "silent": true
  }
}</pre>
                </div>
                <div>
                    <strong>GET /api/v1/jobs/{job_id}</strong>
                    <p>Check the status of a specific print job (e.g. queued, printed, failed).</p>
                </div>
            </div>
        </div>
        
        <div class="glass-card animate-on-scroll delay-200">
            <h3 style="margin-top: 0;">Supported Formats</h3>
            <ul style="color: var(--text-muted); line-height: 1.8; margin-top: 16px;">
                <li><strong>PDF</strong>: Standard documents, invoices, and reports.</li>
                <li><strong>HTML</strong>: Render HTML directly to printers.</li>
                <li><strong>ZPL</strong>: Raw Zebra Programming Language for thermal labels.</li>
                <li><strong>ESC/POS</strong>: Raw receipt printer commands.</li>
                <li><strong>Image</strong>: PNG, JPEG rendering.</li>
            </ul>

            <h3 style="margin-top: 32px;">Webhooks</h3>
            <p style="color: var(--text-muted); line-height: 1.6; font-size: 0.95rem;">Configure webhooks in the dashboard to receive real-time HTTP POST notifications when a print job succeeds or fails.</p>
        </div>
    </div>
</section>
@endsection
