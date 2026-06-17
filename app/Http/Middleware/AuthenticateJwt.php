<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthenticateJwt
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken() ?: $request->header('X-JWT-TOKEN');

        if (! $token) {
            return response()->json(['message' => 'JWT token required.'], 401);
        }

        $secret = (string) config('security.jwt.secret');
        if ($secret === '') {
            return response()->json(['message' => 'JWT secret not configured.'], 500);
        }

        try {
            JWT::$leeway = (int) config('security.jwt.leeway_seconds', 60);
            $payload = JWT::decode($token, new Key($secret, 'HS256'));
        } catch (\Throwable $exception) {
            return response()->json(['message' => 'Invalid JWT token.'], 401);
        }

        $tokenId = (string) ($payload->jti ?? '');
        if ($tokenId !== '' && Cache::has("jwt:revoked:{$tokenId}")) {
            return response()->json(['message' => 'JWT token revoked.'], 401);
        }

        $expectedIssuer = (string) config('security.jwt.issuer');
        $expectedAudience = (string) config('security.jwt.audience');
        if (($payload->iss ?? null) !== $expectedIssuer || ($payload->aud ?? null) !== $expectedAudience) {
            return response()->json(['message' => 'Invalid JWT issuer or audience.'], 401);
        }

        $userId = (int) ($payload->sub ?? 0);
        $organizationId = (int) ($payload->org_id ?? 0);

        if ($userId <= 0 || $organizationId <= 0) {
            return response()->json(['message' => 'Invalid JWT payload.'], 401);
        }

        $user = User::find($userId);
        if (! $user || ! $user->belongsToOrganization($organizationId)) {
            return response()->json(['message' => 'User is not authorized for this tenant.'], 403);
        }

        $tenantOrganization = $request->attributes->get('tenant.organization');
        if ($tenantOrganization && (int) $tenantOrganization->id !== $organizationId) {
            return response()->json(['message' => 'JWT organization mismatch.'], 403);
        }

        Auth::setUser($user);
        $request->attributes->set('auth.jwt.payload', (array) $payload);
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
