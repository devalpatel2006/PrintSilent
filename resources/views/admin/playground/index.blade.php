@extends('admin.layouts.app')

@section('title', 'Playground')

@section('content')
<div class="panel">
    <div class="panel-header">
        <h3 class="panel-title">PrintSilent Agent — Direct Browser Connection</h3>
    </div>
    <div class="panel-body">

        @if(!$apiKey)
            <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 24px;">
                <h4 style="color: #f87171; margin-top: 0;">Missing API Key</h4>
                <p style="color: var(--text-secondary); margin-bottom: 16px;">You need to generate an API Key for your organization before you can use the Playground to connect to your local print agent.</p>
                <a href="{{ route('admin.api-keys.create') }}" class="btn btn-primary">Generate API Key Now</a>
            </div>
        @else
            {{-- Port config --}}
            <div style="margin-bottom: 1rem;">
                <label for="port-input" style="display: block; margin-bottom: 0.5rem;">Agent Port (default: 4545):</label>
                <input type="number" id="port-input" class="form-control" placeholder="4545" value="4545" style="max-width: 200px;">
            </div>

            {{-- Action buttons --}}
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1rem;">
                <button id="btn-status" class="btn btn-primary">Check Status</button>
                <button id="btn-printers" class="btn btn-primary">Fetch Printers</button>
            </div>

            {{-- Status result --}}
            <div style="margin-bottom: 1.5rem;">
                <h4 style="margin-bottom: 0.5rem;">Agent Status</h4>
                <div id="status-result" class="playground-result" style="white-space: pre-wrap; background: rgba(255,255,255,0.04); padding: 1rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.08); min-height: 60px;">
                    Click "Check Status" to test connection.
                </div>
            </div>

            {{-- Printer list result --}}
            <div style="margin-bottom: 1.5rem;">
                <h4 style="margin-bottom: 0.5rem;">Available Printers</h4>
                <div id="printers-result" class="playground-result" style="white-space: pre-wrap; background: rgba(255,255,255,0.04); padding: 1rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.08); min-height: 60px;">
                    Click "Fetch Printers" to load printer list.
                </div>
            </div>

            {{-- Test print (hidden until printers are loaded) --}}
            <div id="print-section" style="margin-bottom: 1.5rem; display: none;">
                <h4 style="margin-bottom: 0.5rem;">Test Print</h4>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: flex-end; margin-bottom: 0.5rem;">
                    <div style="flex: 1; min-width: 200px;">
                        <label style="display: block; margin-bottom: 0.25rem; font-size: 0.85rem; color: var(--text-secondary);">Document</label>
                        <div style="padding: 10px 14px; background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 8px; font-family: monospace; font-size: 0.85rem; color: var(--text-secondary);">
                            📄 Demofile.pdf
                        </div>
                    </div>
                    <div style="width: 240px;">
                        <label for="print-printer" style="display: block; margin-bottom: 0.25rem; font-size: 0.85rem; color: var(--text-secondary);">Printer</label>
                        <select id="print-printer" class="form-control" style="width: 100%; padding: 10px 14px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); border-radius: 8px; color: var(--text); font-size: 0.9rem; appearance: auto;">
                            <option value="">Select a printer...</option>
                        </select>
                    </div>
                    <button id="btn-print" class="btn btn-primary">Send Print Job</button>
                </div>
                <div id="print-result" class="playground-result" style="white-space: pre-wrap; background: rgba(255,255,255,0.04); padding: 1rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.08); min-height: 60px;">
                    Select a printer and click "Send Print Job".
                </div>
            </div>

            <div style="padding: 0.75rem 1rem; background: rgba(76,175,80,0.08); border: 1px solid rgba(76,175,80,0.25); border-radius: 8px; font-size: 0.85rem;">
                ✅ <strong>Secure Tracking:</strong> All requests hit the Laravel backend first to securely log the action and fetch your personal token. Then, your browser safely contacts your local printer agent.
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/sp-client.js') }}"></script>
<script>
    // ─── CSRF Token ──────────────────────────────────────────────
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const headers = {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    };

    const portInput  = document.getElementById('port-input');
    const DEMO_PDF_URL = '{{ asset("demopdf/Demofile.pdf") }}';

    // ─── Status ──────────────────────────────────────────────────
    const statusBox = document.getElementById('status-result');
    document.getElementById('btn-status')?.addEventListener('click', async function () {
        this.disabled = true;
        this.textContent = 'Tracking & Checking...';
        statusBox.textContent = 'Logging request with server...';
        
        try {
            const backendResponse = await fetch('/api/v1/status', { 
                headers: { 'X-CSRF-TOKEN': csrfToken },
                credentials: 'same-origin',
                cache: 'no-store'
            });
            
            if (!backendResponse.ok) {
                throw new Error(`Server returned status ${backendResponse.status}`);
            }
            
            const contentType = backendResponse.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new Error("Server did not return JSON data. Please make sure you are logged in.");
            }

            const backendData = await backendResponse.json();

            if (backendData.success && backendData.encryptedToken) {
                statusBox.textContent = 'Connecting to local agent...';
                const port = parseInt(portInput.value) || 4545;
                const sp = new SPClient(port, backendData.encryptedToken);
                
                const data = await sp.status();
                statusBox.textContent = JSON.stringify(data, null, 2);
            } else {
                throw new Error("Backend failed to provide an API token. Ensure you have an active API Key.");
            }
        } catch (err) {
            statusBox.textContent = '❌ ' + err.message;
        } finally {
            this.disabled = false;
            this.textContent = 'Check Status';
        }
    });

    // ─── Printers ────────────────────────────────────────────────
    const printersBox = document.getElementById('printers-result');
    const printerSelect = document.getElementById('print-printer');
    const printSection = document.getElementById('print-section');

    document.getElementById('btn-printers')?.addEventListener('click', async function () {
        this.disabled = true;
        this.textContent = 'Tracking & Fetching...';
        printersBox.textContent = 'Logging request with server...';
        
        try {
            const backendResponse = await fetch('/api/v1/fetch_printer_list', { 
                method: 'POST', 
                headers: headers,
                credentials: 'same-origin',
                cache: 'no-store'
            });
            
            if (!backendResponse.ok) {
                throw new Error(`Server returned status ${backendResponse.status}`);
            }

            const backendData = await backendResponse.json();

            if (backendData.success && backendData.encryptedToken) {
                printersBox.textContent = 'Fetching printers from local agent...';
                const port = parseInt(portInput.value) || 4545;
                const sp = new SPClient(port, backendData.encryptedToken);
                
                const data = await sp.printers();
                printersBox.textContent = JSON.stringify(data, null, 2);

                // Populate the printer dropdown
                const printerList = data.printers || data.data || [];
                printerSelect.innerHTML = '<option value="">Select a printer...</option>';

                if (Array.isArray(printerList) && printerList.length > 0) {
                    printerList.forEach(p => {
                        const name = (typeof p === 'string') ? p : (p.name || p.printer || p.printerName || '');
                        if (name) {
                            const opt = document.createElement('option');
                            opt.value = name;
                            opt.textContent = name;
                            printerSelect.appendChild(opt);
                        }
                    });
                    printSection.style.display = 'block';
                } else {
                    printSection.style.display = 'none';
                    printersBox.textContent += '\n\n⚠️ No printers found on local agent.';
                }
            } else {
                throw new Error("Backend failed to provide an API token. Ensure you have an active API Key.");
            }
        } catch (err) {
            printersBox.textContent = '❌ ' + err.message;
            printSection.style.display = 'none';
        } finally {
            this.disabled = false;
            this.textContent = 'Fetch Printers';
        }
    });

    // ─── Print ───────────────────────────────────────────────────
    const printResult = document.getElementById('print-result');
    document.getElementById('btn-print')?.addEventListener('click', async function () {
        const printer = printerSelect.value;
        const port    = parseInt(portInput.value) || 4545;

        if (!printer) {
            printResult.textContent = '⚠️ Please select a printer.';
            return;
        }

        this.disabled = true;
        this.textContent = 'Tracking & Sending...';
        printResult.textContent = 'Logging request with server...';
        
        try {
            const backendResponse = await fetch('/api/v1/print', {
                method: 'POST',
                headers: headers,
                credentials: 'same-origin',
                cache: 'no-store',
                body: JSON.stringify({ url: DEMO_PDF_URL, printer })
            });
            
            if (!backendResponse.ok) {
                throw new Error(`Server returned status ${backendResponse.status}`);
            }

            const backendData = await backendResponse.json();

            if (backendData.success && backendData.encryptedToken) {
                printResult.textContent = 'Sending print job to local agent...';
                const sp = new SPClient(port, backendData.encryptedToken);
                
                const data = await sp.print({ url: DEMO_PDF_URL, printer });
                printResult.textContent = JSON.stringify(data, null, 2);
            } else {
                throw new Error("Backend failed to provide an API token. Ensure you have an active API Key.");
            }
        } catch (err) {
            printResult.textContent = '❌ ' + err.message;
        } finally {
            this.disabled = false;
            this.textContent = 'Send Print Job';
        }
    });</script>
@endpush
