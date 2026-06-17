<?php

return [
    'jwt' => [
        'secret' => env('JWT_SECRET', env('APP_KEY')),
        'issuer' => env('JWT_ISSUER', env('APP_URL', 'http://localhost')),
        'audience' => env('JWT_AUDIENCE', 'sp-api'),
        'ttl_minutes' => (int) env('JWT_TTL_MINUTES', 15),
        'refresh_ttl_minutes' => (int) env('JWT_REFRESH_TTL_MINUTES', 43200), // 30 days
        'leeway_seconds' => (int) env('JWT_LEEWAY_SECONDS', 60),
    ],
    'request_signing' => [
        'max_clock_skew_seconds' => (int) env('REQUEST_SIGNATURE_MAX_SKEW', 300),
        'nonce_ttl_seconds' => (int) env('REQUEST_SIGNATURE_NONCE_TTL', 300),
    ],
    'audit' => [
        'truncate_payload_chars' => (int) env('AUDIT_LOG_PAYLOAD_TRUNCATE', 500),
    ],
];
