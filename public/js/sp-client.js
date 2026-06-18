/**
 * PrintSilent Browser Client (sp-client.js)
 * 
 * Communicates directly with the local PrintSilent agent running on the user's machine.
 * All requests go to 127.0.0.1 (localhost) — nothing leaves the user's computer.
 * 
 * Usage:
 *   const sp = new SPClient(4545);       // optional port, defaults to 4545
 *   const status = await sp.status();
 *   const printers = await sp.printers();
 *   const result = await sp.print({ url, printer, width, height, copies });
 */

class SPClient {

    /**
     * @param {number} port - Local agent port (default: 4545)
     */
    constructor(port = 4545) {
        this._port = port;
        this._baseUrl = `http://127.0.0.1:${port}`;
        this._apiKey = 'SPRINT_SAAS_SECURE_KEY_2024';
        this._timeout = 5000; // 5 seconds
    }

    /* ------------------------------------------------------------------ */
    /*  Public API                                                         */
    /* ------------------------------------------------------------------ */

    /**
     * Check if the local agent is running.
     * @returns {Promise<Object>} { status: 'active'|'inactive', ... }
     */
    async status() {
        try {
            const data = await this._get('/status');
            return data;
        } catch {
            return { status: 'inactive', error: 'failed' };
        }
    }

    /**
     * Fetch available printers from the local agent.
     * @returns {Promise<Object>}
     */
    async printers() {
        return this._get('/v1/printers');
    }

    /**
     * Send a print job to the local agent.
     * @param {Object} options
     * @param {string} options.url      - URL of the document/image to print
     * @param {string} options.printer  - Printer name
     * @param {number} [options.width=101.6]   - Paper width in mm
     * @param {number} [options.height=152.4]  - Paper height in mm
     * @param {number} [options.copies=1]      - Number of copies
     * @returns {Promise<Object>}
     */
    async print({ url, printer, width = 101.6, height = 152.4, copies = 1 }) {
        const params = new URLSearchParams({
            url,
            printer,
            width: String(width),
            height: String(height),
            copies: String(copies),
        });
        return this._get(`/v1/print/url?${params.toString()}`);
    }

    /* ------------------------------------------------------------------ */
    /*  Internal helpers                                                    */
    /* ------------------------------------------------------------------ */

    /**
     * @private
     */
    async _get(path) {
        const controller = new AbortController();
        const timer = setTimeout(() => controller.abort(), this._timeout);

        try {
            const response = await fetch(`${this._baseUrl}${path}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'x-api-key': this._apiKey,
                },
                signal: controller.signal,
            });

            const data = await response.json();

            if (!response.ok) {
                throw new SPClientError(
                    data.message || `Agent returned ${response.status}`,
                    response.status,
                    data
                );
            }

            return data;
        } catch (err) {
            if (err instanceof SPClientError) throw err;

            if (err.name === 'AbortError') {
                throw new SPClientError(
                    'Local agent did not respond — is PrintSilent running?',
                    0,
                    null
                );
            }

            // Network error (agent not running, CORS blocked, etc.)
            throw new SPClientError(
                'Cannot reach local agent — make sure PrintSilent is running on port ' + this._port,
                0,
                null
            );
        } finally {
            clearTimeout(timer);
        }
    }

    /**
     * Update port at runtime.
     * @param {number} port
     */
    setPort(port) {
        this._port = port;
        this._baseUrl = `http://127.0.0.1:${port}`;
    }
}


/**
 * Custom error class for SPClient failures.
 */
class SPClientError extends Error {
    /**
     * @param {string} message
     * @param {number} httpStatus
     * @param {Object|null} responseBody
     */
    constructor(message, httpStatus, responseBody) {
        super(message);
        this.name = 'SPClientError';
        this.httpStatus = httpStatus;
        this.responseBody = responseBody;
    }
}
