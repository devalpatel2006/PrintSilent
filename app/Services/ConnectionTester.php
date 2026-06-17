<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Throwable;

class ConnectionTester
{
    public function test(string $url, array $headers = [], int $timeout = 10): array
    {
        try {
            $response = Http::withHeaders($headers)->timeout($timeout)->get($url);

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'body' => $response->body(),
                'json' => $response->json(),
            ];
        } catch (Throwable $exception) {
            return [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
        }
    }
}
