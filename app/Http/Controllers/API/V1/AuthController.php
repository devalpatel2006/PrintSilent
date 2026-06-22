<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;

class AuthController extends Controller
{
    /**
     * Authenticate and get the API key profile.
     *
     * POST /api/v1/auth/me
     * Body: { "token": "..." } or Header: Authorization: Bearer ...
     */
    public function me(Request $request): JsonResponse
    {
        $token = $request->input('token') ?? $request->bearerToken();

        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Token is required.',
            ], 401);
        }

        $apiKey = ApiKey::where('token', $token)->first();

        if (!$apiKey) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid token.',
            ], 401);
        }

        // Check revoked
        if ($apiKey->revoked) {
            return response()->json([
                'status' => false,
                'message' => 'Token has been revoked.',
            ], 403);
        }

        // Check expires_at
        if ($apiKey->expires_at && $apiKey->expires_at->isPast()) {
            return response()->json([
                'status' => false,
                'message' => 'Token has expired.',
            ], 403);
        }

        // Check allowed IPs
        if ($apiKey->allowed_ips) {
            $allowedIps = array_filter(array_map('trim', explode(',', $apiKey->allowed_ips)));
            if (!IpUtils::checkIp($request->ip(), $allowedIps)) {
                return response()->json([
                    'status' => false,
                    'message' => 'IP address not allowed.',
                ], 403);
            }
        }

        // Update last used at
        if ($apiKey->last_used_at !== null) {
            $apiKey->last_used_at = now();
            $apiKey->saveQuietly();
        } else {
            $apiKey->updateQuietly(['last_used_at' => now()]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Authenticated successfully.',
            'data'   => [
                'id' => $apiKey->id,
                'name' => $apiKey->name,
                'organization_id' => $apiKey->organization_id,
                'abilities' => $apiKey->abilities,
            ],
        ]);
    }

    /**
     * Generate a short-lived encrypted token for local agent communication.
     *
     * POST /api/v1/auth/third-party-token
     * Body: { "api_key": "..." }
     */
    public function generateEncryptedToken(Request $request): JsonResponse
    {
        $rawKey = $request->input('api_key') ?? $request->bearerToken();

        if (!$rawKey) {
            return response()->json(['status' => false, 'message' => 'API Key is required.'], 401);
        }

        $apiKey = ApiKey::where('token', $rawKey)->first();

        if (!$apiKey || $apiKey->revoked || ($apiKey->expires_at && $apiKey->expires_at->isPast())) {
            return response()->json(['status' => false, 'message' => 'Invalid API Key.'], 401);
        }

        // Return the encrypted token (Valid for 1 hour from generation time)
        // Using encryptString() avoids PHP serialization, making it easier to decrypt in Flutter
        return response()->json([
            'status' => true,
            'encryptedToken' => \Illuminate\Support\Facades\Crypt::encryptString($apiKey->token),
            'expires_in' => 3600
        ]);
    }
}
