@extends('admin.layouts.app')

@section('title', 'Playground')

@section('content')
<div class="panel">
    <div class="panel-header">
        <h3 class="panel-title">Admin Playground</h3>
    </div>
    <div class="panel-body">
        <div style="margin-bottom: 1rem;">
            <label for="port-input" style="display: block; margin-bottom: 0.5rem;">Port (optional, defaults to 4545):</label>
            <input type="number" id="port-input" class="form-control" placeholder="4545" style="max-width: 200px;">
        </div>
        <button id="btn-test-connection" class="btn btn-primary">Run Test Connection</button>

        <div id="playground-result" class="playground-result" style="margin-top: 1rem; white-space: pre-wrap; background: rgba(255,255,255,0.04); padding: 1rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.08); min-height: 120px;">
            Click the button to test the connection.
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const resultBox = document.getElementById('playground-result');
    const testButton = document.getElementById('btn-test-connection');
    const portInput = document.getElementById('port-input');

    testButton.addEventListener('click', async function () {
        testButton.disabled = true;
        testButton.textContent = 'Testing...';
        try {
            const port = portInput.value.trim();
            const url = port ? `/api/v1/status/${port}` : '/api/v1/status';

            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                }
            });

            const data = await response.json();
            resultBox.textContent = JSON.stringify(data, null, 2);
        } catch (error) {
            resultBox.textContent = 'Request failed: ' + error.message;
        } finally {
            testButton.disabled = false;
            testButton.textContent = 'Run Test Connection';
        }
    });
</script>
@endpush
