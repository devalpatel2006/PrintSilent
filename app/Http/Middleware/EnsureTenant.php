<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;

class EnsureTenant
{
    public function handle(Request $request, Closure $next)
    {
        $publicKey = $request->header('X-API-KEY');

        if (! $publicKey) {
            $authorization = (string) $request->header('Authorization', '');
            if (str_starts_with($authorization, 'ApiKey ')) {
                $publicKey = trim(substr($authorization, 7));
            }
        }

        if (! $publicKey) {
            return response()->json(['message' => 'API key required.'], 401);
        }

        $apiKey = ApiKey::where('public_key', $publicKey)->first();

        if (! $apiKey) {
            $tokenHash = hash('sha256', $publicKey);
            $apiKey = ApiKey::where('token', $tokenHash)->first();
        }

        if (! $apiKey || $apiKey->revoked || ($apiKey->expires_at && $apiKey->expires_at->isPast())) {
            return response()->json(['message' => 'Invalid or expired API key.'], 401);
        }

        $organization = $apiKey->organization;
        if (! $organization) {
            return response()->json(['message' => 'Tenant organization not found.'], 404);
        }

        $request->attributes->set('tenant.organization', $organization);
        $request->attributes->set('tenant.api_key', $apiKey);
        app()->instance('tenant.organization', $organization);
        app()->instance('tenant.api_key', $apiKey);

        return $next($request);
    }
}
