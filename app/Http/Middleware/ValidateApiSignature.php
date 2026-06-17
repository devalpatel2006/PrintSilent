<?php

namespace App\Http\Middleware;

use App\Models\UsageLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\IpUtils;

class ValidateApiSignature
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->attributes->get('tenant.api_key');

        if (! $apiKey) {
            return response()->json(['message' => 'API key missing or invalid.'], 401);
        }

        $signature = $request->header('X-API-SIGNATURE');
        $timestamp = $request->header('X-API-TIMESTAMP');
        $nonce = $request->header('X-API-NONCE');

        if (! $signature || ! $timestamp || ! $nonce) {
            $response = response()->json(['message' => 'Signed requests must include signature, timestamp, and nonce.'], 401);
            $this->auditFailure($request, $apiKey->organization_id, $apiKey->id, 'missing-signature-headers', 401);
            return $response;
        }

        $maxSkew = (int) config('security.request_signing.max_clock_skew_seconds', 300);
        if (! is_numeric($timestamp) || abs(now()->timestamp - (int) $timestamp) > $maxSkew) {
            $this->auditFailure($request, $apiKey->organization_id, $apiKey->id, 'timestamp-out-of-window', 401);
            return response()->json(['message' => 'Invalid or expired timestamp.'], 401);
        }

        if (! preg_match('/^[A-Za-z0-9\-_]{16,128}$/', $nonce)) {
            $this->auditFailure($request, $apiKey->organization_id, $apiKey->id, 'invalid-nonce-format', 401);
            return response()->json(['message' => 'Invalid nonce format.'], 401);
        }

        $nonceTtl = (int) config('security.request_signing.nonce_ttl_seconds', 300);
        $nonceCacheKey = sprintf('api-signature:nonce:%s:%s', $apiKey->id, $nonce);
        if (! Cache::add($nonceCacheKey, true, now()->addSeconds($nonceTtl))) {
            $this->auditFailure($request, $apiKey->organization_id, $apiKey->id, 'replayed-nonce', 409);
            return response()->json(['message' => 'Replay attack detected. Nonce already used.'], 409);
        }

        if ($apiKey->allowed_ips) {
            $allowedIps = array_filter(array_map('trim', explode(',', $apiKey->allowed_ips)));
            if (! IpUtils::checkIp($request->ip(), $allowedIps)) {
                return response()->json(['message' => 'IP address not allowed.'], 403);
            }
        }

        $canonical = $this->buildCanonicalString($request, $timestamp, $nonce);
        $secret = $apiKey->secret;
        $expected = hash_hmac('sha256', $canonical, $secret);

        if (! hash_equals($expected, $signature)) {
            $this->auditFailure($request, $apiKey->organization_id, $apiKey->id, 'invalid-signature', 401);
            return response()->json(['message' => 'Invalid request signature.'], 401);
        }

        $throttleKey = sprintf('api-key:%s', $apiKey->id);
        $limit = (int) ($apiKey->rate_limit_per_minute ?? 120);

        if (RateLimiter::tooManyAttempts($throttleKey, $limit)) {
            $this->auditFailure($request, $apiKey->organization_id, $apiKey->id, 'api-key-rate-limit', 429);
            return response()->json(['message' => 'Rate limit exceeded.'], 429);
        }

        RateLimiter::hit($throttleKey, 60);

        if ($apiKey->last_used_at !== null) {
            $apiKey->last_used_at = now();
            $apiKey->saveQuietly();
        } else {
            $apiKey->updateQuietly(['last_used_at' => now()]);
        }

        return $next($request);
    }

    protected function buildCanonicalString(Request $request, string $timestamp, string $nonce): string
    {
        $method = strtoupper($request->method());
        $path = $request->getPathInfo();
        $query = $request->getQueryString() ?: '';
        $body = $request->getContent() ?: '';

        return implode("\n", [$method, $path, $query, $timestamp, $nonce, $body]);
    }

    protected function auditFailure(Request $request, int $organizationId, int $apiKeyId, string $reason, int $statusCode): void
    {
        UsageLog::create([
            'organization_id' => $organizationId,
            'api_key_id' => $apiKeyId,
            'endpoint' => $request->path(),
            'method' => $request->method(),
            'request_payload' => ['security_failure' => $reason],
            'response_status' => $statusCode,
            'response_payload' => ['message' => $reason],
            'ip_address' => $request->ip(),
        ]);
    }
}