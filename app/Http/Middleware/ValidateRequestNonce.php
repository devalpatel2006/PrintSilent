<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateRequestNonce
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->method() === 'GET') {
            return $next($request);
        }

        $nonce = $request->header('X-Request-Nonce');
        $timestamp = $request->header('X-Request-Timestamp');

        if (!$nonce || !$timestamp) {
            return response()->json([
                'status' => false,
                'message' => 'Request nonce and timestamp required.',
            ], 401);
        }

        if (!is_numeric($timestamp) || abs(now()->timestamp - (int)$timestamp) > 300) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired timestamp.',
            ], 401);
        }

        if (!\App\Models\RequestNonce::isValid($nonce, $request->ip())) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or already used nonce. Possible replay attack.',
            ], 401);
        }

        return $next($request);
    }
}
