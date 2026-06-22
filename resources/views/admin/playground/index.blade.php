@extends('admin.layouts.app')

@section('title', 'Playground')

@section('content')
<div class="panel">
    <div class="panel-header">
        <h3 class="panel-title">PrintSilent Agent — Direct Browser Connection</h3>
    </div>
    <div class="panel-body">

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

        {{-- Test print --}}
        <div style="margin-bottom: 1.5rem;">
            <h4 style="margin-bottom: 0.5rem;">Test Print</h4>
            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.5rem;">
                <input type="text" id="print-url" class="form-control" placeholder="Image / PDF URL" style="flex: 1; min-width: 200px;">
                <input type="text" id="print-printer" class="form-control" placeholder="Printer name" style="width: 200px;">
                <button id="btn-print" class="btn btn-primary">Send Print Job</button>
            </div>
            <div id="print-result" class="playground-result" style="white-space: pre-wrap; background: rgba(255,255,255,0.04); padding: 1rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.08); min-height: 60px;">
                Fill in the fields above and click "Send Print Job".
            </div>
        </div>

        <div style="padding: 0.75rem 1rem; background: rgba(76,175,80,0.08); border: 1px solid rgba(76,175,80,0.25); border-radius: 8px; font-size: 0.85rem;">
            ✅ <strong>Secure Tracking:</strong> All requests hit the Laravel backend first to securely log the action and fetch the token. Then, your browser safely contacts your local printer agent.
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/sp-client.js') }}"></script>
<script>
    const portInput  = document.getElementById('port-input');

    // ─── Status ──────────────────────────────────────────────────
    const statusBox = document.getElementById('status-result');
    document.getElementById('btn-status').addEventListener('click', async function () {
        this.disabled = true;
        this.textContent = 'Tracking & Checking...';
        statusBox.textContent = 'Logging request with server...';
        
        try {
            // STEP 1: Ping backend to track and get token
            const backendResponse = await fetch('/api/v1/status');
            const backendData = await backendResponse.json();

            if (backendData.success) {
                // STEP 2: Use the token from backend to query local agent
                statusBox.textContent = 'Connecting to local agent...';
                const port = parseInt(portInput.value) || 4545;
                const sp = new SPClient(port, backendData.encryptedToken);
                
                const data = await sp.status();
                statusBox.textContent = JSON.stringify(data, null, 2);
            } else {
                throw new Error("Backend failed to provide token.");
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
    document.getElementById('btn-printers').addEventListener('click', async function () {
        this.disabled = true;
        this.textContent = 'Tracking & Fetching...';
        printersBox.textContent = 'Logging request with server...';
        
        try {
            // STEP 1: Ping backend to track and get token
            const backendResponse = await fetch('/api/v1/fetch_printer_list', { method: 'POST' });
            const backendData = await backendResponse.json();

            if (backendData.success) {
                // STEP 2: Use the token from backend to query local agent
                printersBox.textContent = 'Fetching printers from local agent...';
                const port = parseInt(portInput.value) || 4545;
                const sp = new SPClient(port, backendData.encryptedToken);
                
                const data = await sp.printers();
                printersBox.textContent = JSON.stringify(data, null, 2);
            } else {
                throw new Error("Backend failed to provide token.");
            }
        } catch (err) {
            printersBox.textContent = '❌ ' + err.message;
        } finally {
            this.disabled = false;
            this.textContent = 'Fetch Printers';
        }
    });

    // ─── Print ───────────────────────────────────────────────────
    const printResult = document.getElementById('print-result');
    document.getElementById('btn-print').addEventListener('click', async function () {
        const url     = document.getElementById('print-url').value.trim();
        const printer = document.getElementById('print-printer').value.trim();
        const port    = parseInt(portInput.value) || 4545;

        if (!url || !printer) {
            printResult.textContent = '⚠️ Please enter both URL and printer name.';
            return;
        }

        this.disabled = true;
        this.textContent = 'Tracking & Sending...';
        printResult.textContent = 'Logging request with server...';
        
        try {
            // STEP 1: Ping backend to track and get token
            const backendResponse = await fetch('/api/v1/print', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ url, printer })
            });
            const backendData = await backendResponse.json();

            if (backendData.success) {
                // STEP 2: Use the token from backend to send print job to local agent
                printResult.textContent = 'Sending print job to local agent...';
                const sp = new SPClient(port, backendData.encryptedToken);
                
                const data = await sp.print({ url, printer });
                printResult.textContent = JSON.stringify(data, null, 2);
            } else {
                throw new Error("Backend failed to provide token.");
            }
        } catch (err) {
            printResult.textContent = '❌ ' + err.message;
        } finally {
            this.disabled = false;
            this.textContent = 'Send Print Job';
        }
    });</script>
@endpush
