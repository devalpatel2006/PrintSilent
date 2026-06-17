<?php

namespace App\Http\Middleware;

use App\Models\UsageLog;
use Closure;
use Illuminate\Http\Request;

class RecordApiUsage
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $organization = $request->attributes->get('tenant.organization');
        $apiKey = $request->attributes->get('tenant.api_key');

        if ($organization) {
            UsageLog::create([
                'organization_id' => $organization->id,
                'api_key_id' => $apiKey->id ?? null,
                'endpoint' => $request->path(),
                'method' => $request->method(),
                'request_payload' => $this->buildRequestPayload($request),
                'response_status' => $response->getStatusCode(),
                'response_payload' => $this->decodeResponse($response->getContent()),
                'ip_address' => $request->ip(),
            ]);
        }

        return $response;
    }

    protected function decodeResponse(string $content): ?array
    {
        $decoded = json_decode($content, true);

        return is_array($decoded)
            ? $decoded
            : ['raw' => substr($content, 0, (int) config('security.audit.truncate_payload_chars', 500))];
    }

    protected function buildRequestPayload(Request $request): array
    {
        return [
            'input' => $request->except(['password', 'password_confirmation', 'refresh_token']),
            'meta' => [
                'request_id' => $request->header('X-REQUEST-ID'),
                'api_timestamp' => $request->header('X-API-TIMESTAMP'),
                'api_nonce' => $request->header('X-API-NONCE'),
                'auth_type' => $request->bearerToken() ? 'bearer' : 'api_key',
                'user_agent' => substr((string) $request->userAgent(), 0, 255),
            ],
        ];
    }
}
