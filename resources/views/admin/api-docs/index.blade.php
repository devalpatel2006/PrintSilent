@extends('admin.layouts.app')

@section('title', 'API Documentation')

@section('content')

{{-- Hero Section --}}
<div class="panel" style="background: linear-gradient(135deg, rgba(59,130,246,0.12) 0%, rgba(139,92,246,0.08) 100%); border: 1px solid rgba(59,130,246,0.2);">
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--primary-color), #8b5cf6); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        </div>
        <div>
            <h2 style="margin: 0; font-size: 1.5rem; font-weight: 700;">PrintSilent API Documentation</h2>
            <p style="margin: 4px 0 0; color: var(--text-secondary); font-size: 0.9rem;">Browser-to-localhost integration &bull; All requests stay on the user's machine</p>
        </div>
    </div>
    <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 16px;">
        <span class="api-badge api-badge-info">Base URL: <code>http://127.0.0.1:{port}</code></span>
        <span class="api-badge api-badge-success">Default Port: 4545</span>
        <span class="api-badge api-badge-purple">Auth: x-api-key header</span>
    </div>
</div>

{{-- Quick Start --}}
<div class="panel">
    <div class="panel-header">
        <h3 class="panel-title">⚡ Quick Start</h3>
    </div>
    <div class="panel-body">
        <p style="color: var(--text-secondary); margin-bottom: 16px;">Include the client library and start making calls:</p>
        <div class="api-code-block">
            <div class="api-code-header">
                <span>HTML</span>
                <button class="btn-copy" onclick="copyCode(this)">Copy</button>
            </div>
            <pre><code>&lt;script src="{{ url('/js/sp-client.js') }}"&gt;&lt;/script&gt;
&lt;script&gt;
    // Initialize the client with your Encrypted Token
    const sp = new SPClient(4545, "{{ $encryptedToken }}");

    // Check if agent is running
    const status = await sp.status();

    // Get printer list
    const printers = await sp.printers();

    // Send print job
    const result = await sp.print({
        url: 'https://example.com/label.pdf',
        printer: 'EPSON L3260 Series',
        width: 101.6,
        height: 152.4,
        copies: 1
    });
&lt;/script&gt;</code></pre>
        </div>
    </div>
</div>

{{-- Security Note --}}
<div class="panel" style="border-left: 3px solid var(--secondary-color);">
    <div class="panel-header">
        <h3 class="panel-title">🔒 Security Model</h3>
    </div>
    <div class="panel-body">
        <div class="api-security-grid">
            <div class="api-security-card">
                <div class="api-security-icon" style="background: rgba(16,185,129,0.15); color: #34d399;">✓</div>
                <div>
                    <strong>Localhost Only</strong>
                    <p>All requests go to <code>127.0.0.1</code> — they never leave the user's machine or traverse any network.</p>
                </div>
            </div>
            <div class="api-security-card">
                <div class="api-security-icon" style="background: rgba(16,185,129,0.15); color: #34d399;">✓</div>
                <div>
                    <strong>API Key Protected</strong>
                    <p>Every request includes an <code>x-api-key</code> header. The local agent rejects requests without a valid key.</p>
                </div>
            </div>
            <div class="api-security-card">
                <div class="api-security-icon" style="background: rgba(16,185,129,0.15); color: #34d399;">✓</div>
                <div>
                    <strong>No Server Proxy</strong>
                    <p>The browser communicates directly with the local agent — your server never sees print data or credentials.</p>
                </div>
            </div>
            <div class="api-security-card">
                <div class="api-security-icon" style="background: rgba(16,185,129,0.15); color: #34d399;">✓</div>
                <div>
                    <strong>CORS Restricted</strong>
                    <p>The local agent should only accept requests from your domain via CORS <code>Access-Control-Allow-Origin</code>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Endpoint: Generate Token --}}
<div class="panel api-endpoint-panel" id="endpoint-token">
    <div class="panel-header">
        <h3 class="panel-title" style="display: flex; align-items: center; gap: 12px;">
            <span class="api-method api-method-post" style="background: #e0e7ff; color: #4f46e5; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 0.85rem;">POST</span>
            <code>/v1/auth/third-party-token</code>
        </h3>
    </div>
    <div class="panel-body">
        <p style="color: var(--text-secondary); margin-bottom: 20px;">Generate a short-lived encrypted token for secure communication with the local agent. Our <code>sp-client.js</code> SDK handles this automatically, but you can also call it directly if building your own client.</p>

        <h4 class="api-section-title">Body Parameters (JSON)</h4>
        <table class="api-param-table">
            <thead><tr><th>Param</th><th>Type</th><th>Description</th></tr></thead>
            <tbody>
                <tr><td><code>api_key</code></td><td>string</td><td>Your raw API Key <span class="api-badge api-badge-danger">Required</span></td></tr>
            </tbody>
        </table>

        <h4 class="api-section-title">cURL Example</h4>
        <div class="api-code-block">
            <div class="api-code-header">
                <span>cURL</span>
                <button class="btn-copy" onclick="copyCode(this)">Copy</button>
            </div>
            <pre><code>curl -X POST {{ url('/api/v1/auth/third-party-token') }} \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"api_key": "{{ $apiKey }}"}'</code></pre>
        </div>

        <div class="api-response-tabs">
            <h4 class="api-section-title">Responses</h4>
            <div class="api-response-group">
                <div class="api-response-label api-response-success">200 — Token Generated</div>
                <div class="api-code-block api-code-block-sm">
                    <pre><code>{
    "status": true,
    "encryptedToken": "eyJpdiI6...",
    "expires_in": 3600
}</code></pre>
                </div>
            </div>
            <div class="api-response-group">
                <div class="api-response-label api-response-error">401 — Invalid API Key</div>
                <div class="api-code-block api-code-block-sm">
                    <pre><code>{
    "status": false,
    "message": "Invalid API Key."
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Endpoint: Status --}}
<div class="panel api-endpoint-panel" id="endpoint-status">
    <div class="panel-header">
        <h3 class="panel-title" style="display: flex; align-items: center; gap: 12px;">
            <span class="api-method api-method-get">GET</span>
            <code>/status</code>
        </h3>
    </div>
    <div class="panel-body">
        <p style="color: var(--text-secondary); margin-bottom: 20px;">Check if the local PrintSilent agent is running and responsive.</p>

        <h4 class="api-section-title">Headers</h4>
        <table class="api-param-table">
            <thead><tr><th>Name</th><th>Value</th><th>Required</th></tr></thead>
            <tbody>
                <tr><td><code>Accept</code></td><td><code>application/json</code></td><td><span class="api-badge api-badge-subtle">Optional</span></td></tr>
            </tbody>
        </table>

        <h4 class="api-section-title">JavaScript Example</h4>
        <div class="api-code-block">
            <div class="api-code-header">
                <span>JavaScript</span>
                <button class="btn-copy" onclick="copyCode(this)">Copy</button>
            </div>
            <pre><code>const sp = new SPClient(4545, "{{ $encryptedToken }}");
const status = await sp.status();
console.log(status);
// { "status": "active", "version": "1.0.0" }</code></pre>
        </div>

        <div class="api-response-tabs">
            <h4 class="api-section-title">Responses</h4>
            <div class="api-response-group">
                <div class="api-response-label api-response-success">200 — Agent is running</div>
                <div class="api-code-block api-code-block-sm">
                    <pre><code>{
    "status": "active",
    "version": "1.0.0"
}</code></pre>
                </div>
            </div>
            <div class="api-response-group">
                <div class="api-response-label api-response-error">Error — Agent not reachable</div>
                <div class="api-code-block api-code-block-sm">
                    <pre><code>{
    "status": "inactive",
    "error": "failed"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Endpoint: Printers --}}
<div class="panel api-endpoint-panel" id="endpoint-printers">
    <div class="panel-header">
        <h3 class="panel-title" style="display: flex; align-items: center; gap: 12px;">
            <span class="api-method api-method-get">GET</span>
            <code>/v1/printers</code>
        </h3>
    </div>
    <div class="panel-body">
        <p style="color: var(--text-secondary); margin-bottom: 20px;">Retrieve a list of all printers available on the user's machine.</p>

        <h4 class="api-section-title">Headers</h4>
        <table class="api-param-table">
            <thead><tr><th>Name</th><th>Value</th><th>Required</th></tr></thead>
            <tbody>
                <tr><td><code>x-api-key</code></td><td><code>[Auto-generated via SPClient]</code></td><td><span class="api-badge api-badge-danger">Required</span></td></tr>
                <tr><td><code>Accept</code></td><td><code>application/json</code></td><td><span class="api-badge api-badge-subtle">Optional</span></td></tr>
            </tbody>
        </table>

        <h4 class="api-section-title">JavaScript Example</h4>
        <div class="api-code-block">
            <div class="api-code-header">
                <span>JavaScript</span>
                <button class="btn-copy" onclick="copyCode(this)">Copy</button>
            </div>
            <pre><code>const sp = new SPClient(4545, "{{ $encryptedToken }}");
const printers = await sp.printers();
console.log(printers);

// Populate a dropdown
printers.forEach(p => {
    const opt = document.createElement('option');
    opt.value = p.name;
    opt.textContent = `${p.name} (${p.paperWidth} x ${p.paperHeight})`;
    selectEl.appendChild(opt);
});</code></pre>
        </div>

        <div class="api-response-tabs">
            <h4 class="api-section-title">Responses</h4>
            <div class="api-response-group">
                <div class="api-response-label api-response-success">200 — Printer list retrieved</div>
                <div class="api-code-block api-code-block-sm">
                    <pre><code>[
    {
        "name": "EPSON L3260 Series",
        "paperWidth": 210,
        "paperHeight": 297,
        "isDefault": true
    },
    {
        "name": "HP LaserJet Pro",
        "paperWidth": 215.9,
        "paperHeight": 279.4,
        "isDefault": false
    }
]</code></pre>
                </div>
            </div>
            <div class="api-response-group">
                <div class="api-response-label api-response-error">401 — Invalid API Key</div>
                <div class="api-code-block api-code-block-sm">
                    <pre><code>{
    "status": false,
    "message": "Unauthorized"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Endpoint: Print --}}
<div class="panel api-endpoint-panel" id="endpoint-print">
    <div class="panel-header">
        <h3 class="panel-title" style="display: flex; align-items: center; gap: 12px;">
            <span class="api-method api-method-get">GET</span>
            <code>/v1/print/url</code>
        </h3>
    </div>
    <div class="panel-body">
        <p style="color: var(--text-secondary); margin-bottom: 20px;">Send a print job to a specific printer. The agent downloads the document from the given URL and prints it.</p>

        <h4 class="api-section-title">Headers</h4>
        <table class="api-param-table">
            <thead><tr><th>Name</th><th>Value</th><th>Required</th></tr></thead>
            <tbody>
                <tr><td><code>x-api-key</code></td><td><code>[Auto-generated via SPClient]</code></td><td><span class="api-badge api-badge-danger">Required</span></td></tr>
            </tbody>
        </table>

        <h4 class="api-section-title">Query Parameters</h4>
        <table class="api-param-table">
            <thead><tr><th>Param</th><th>Type</th><th>Default</th><th>Description</th></tr></thead>
            <tbody>
                <tr><td><code>url</code></td><td>string</td><td>—</td><td>URL of the image or PDF to print <span class="api-badge api-badge-danger">Required</span></td></tr>
                <tr><td><code>printer</code></td><td>string</td><td>—</td><td>Exact printer name (from <code>/v1/printers</code>) <span class="api-badge api-badge-danger">Required</span></td></tr>
                <tr><td><code>width</code></td><td>number</td><td>101.6</td><td>Paper width in mm (4 inches)</td></tr>
                <tr><td><code>height</code></td><td>number</td><td>152.4</td><td>Paper height in mm (6 inches)</td></tr>
                <tr><td><code>copies</code></td><td>number</td><td>1</td><td>Number of copies to print</td></tr>
            </tbody>
        </table>

        <h4 class="api-section-title">JavaScript Example</h4>
        <div class="api-code-block">
            <div class="api-code-header">
                <span>JavaScript</span>
                <button class="btn-copy" onclick="copyCode(this)">Copy</button>
            </div>
            <pre><code>const sp = new SPClient(4545, "{{ $encryptedToken }}");

const result = await sp.print({
    url: 'https://example.com/shipping-label.pdf',
    printer: 'EPSON L3260 Series',
    width: 101.6,    // 4" label
    height: 152.4,   // 6" label
    copies: 2
});

console.log(result);
// { "status": true, "message": "Print job sent" }</code></pre>
        </div>

        <div class="api-response-tabs">
            <h4 class="api-section-title">Responses</h4>
            <div class="api-response-group">
                <div class="api-response-label api-response-success">200 — Print job sent</div>
                <div class="api-code-block api-code-block-sm">
                    <pre><code>{
    "status": true,
    "message": "Print job sent"
}</code></pre>
                </div>
            </div>
            <div class="api-response-group">
                <div class="api-response-label api-response-error">400 — Invalid parameters</div>
                <div class="api-code-block api-code-block-sm">
                    <pre><code>{
    "status": false,
    "message": "Printer not found"
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SPClient Class Reference --}}
<div class="panel" id="client-reference">
    <div class="panel-header">
        <h3 class="panel-title">📦 SPClient Class Reference</h3>
    </div>
    <div class="panel-body">
        <table class="api-param-table">
            <thead><tr><th>Method</th><th>Returns</th><th>Description</th></tr></thead>
            <tbody>
                <tr>
                    <td><code>new SPClient(port?, encryptedToken?)</code></td>
                    <td>SPClient</td>
                    <td>Create a new client instance. Port defaults to <code>4545</code>. Pass the short-lived Encrypted Token generated from the auth endpoint.</td>
                </tr>
                <tr>
                    <td><code>sp.status()</code></td>
                    <td>Promise&lt;Object&gt;</td>
                    <td>Check if the local agent is running. Never throws — returns <code>{ status: 'inactive' }</code> on failure.</td>
                </tr>
                <tr>
                    <td><code>sp.printers()</code></td>
                    <td>Promise&lt;Array&gt;</td>
                    <td>Fetch available printers. Throws <code>SPClientError</code> on failure.</td>
                </tr>
                <tr>
                    <td><code>sp.print({...})</code></td>
                    <td>Promise&lt;Object&gt;</td>
                    <td>Send a print job. Throws <code>SPClientError</code> on failure.</td>
                </tr>
                <tr>
                    <td><code>sp.setPort(port)</code></td>
                    <td>void</td>
                    <td>Change the agent port at runtime.</td>
                </tr>
            </tbody>
        </table>

        <h4 class="api-section-title" style="margin-top: 24px;">Error Handling</h4>
        <div class="api-code-block">
            <div class="api-code-header">
                <span>JavaScript</span>
                <button class="btn-copy" onclick="copyCode(this)">Copy</button>
            </div>
            <pre><code>try {
    const result = await sp.print({ url, printer });
    showSuccess('Printed successfully!');
} catch (err) {
    if (err instanceof SPClientError) {
        console.log(err.message);       // Human-readable message
        console.log(err.httpStatus);     // HTTP status (0 if unreachable)
        console.log(err.responseBody);   // Raw response JSON or null
    }
}</code></pre>
        </div>
    </div>
</div>

{{-- CORS Setup Guide --}}
<div class="panel" id="cors-setup">
    <div class="panel-header">
        <h3 class="panel-title">🌐 CORS Setup (Local Agent)</h3>
    </div>
    <div class="panel-body">
        <p style="color: var(--text-secondary); margin-bottom: 16px;">Your local PrintSilent agent must return these CORS headers so the browser permits cross-origin requests from your web app:</p>
        <div class="api-code-block">
            <div class="api-code-header">
                <span>HTTP Response Headers</span>
                <button class="btn-copy" onclick="copyCode(this)">Copy</button>
            </div>
            <pre><code>Access-Control-Allow-Origin: https://your-domain.com
Access-Control-Allow-Headers: x-api-key, Accept, Content-Type
Access-Control-Allow-Methods: GET, POST, OPTIONS</code></pre>
        </div>
        <p style="color: var(--text-secondary); margin-top: 12px; font-size: 0.85rem;">
            The agent must also respond to <code>OPTIONS</code> preflight requests with a <code>204 No Content</code> and the same headers above.
        </p>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function copyCode(btn) {
        const codeBlock = btn.closest('.api-code-block').querySelector('code');
        const text = codeBlock.textContent;
        navigator.clipboard.writeText(text).then(() => {
            const orig = btn.textContent;
            btn.textContent = 'Copied!';
            btn.style.color = '#34d399';
            setTimeout(() => {
                btn.textContent = orig;
                btn.style.color = '';
            }, 2000);
        });
    }
</script>
@endpush
