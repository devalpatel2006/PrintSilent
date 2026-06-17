<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateBroadcastJwt
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken() ?: $request->header('X-JWT-TOKEN') ?: $request->query('token');

        if (! $token) {
            return response()->json(['message' => 'JWT token required for websocket auth.'], 401);
        }

        try {
            JWT::$leeway = (int) config('security.jwt.leeway_seconds', 60);
            $payload = JWT::decode($token, new Key((string) config('security.jwt.secret'), 'HS256'));
        } catch (\Throwable $exception) {
            return response()->json(['message' => 'Invalid JWT token.', 'error' => $exception->getMessage()], 401);
        }

        if (empty($payload->sub)) {
            return response()->json(['message' => 'Invalid JWT payload.'], 401);
        }

        $user = User::find((int) $payload->sub);
        if (! $user) {
            return response()->json(['message' => 'Authenticated user not found.'], 401);
        }

        Auth::setUser($user);
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }
}
