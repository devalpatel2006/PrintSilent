<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuditRequestResponse
{
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);

        $response = $next($request);

        $endTime = microtime(true);
        $responseTimeMs = ($endTime - $startTime) * 1000;

        $this->logRequest($request, $response, $responseTimeMs);

        return $response;
    }

    private function logRequest(Request $request, $response, float $responseTimeMs): void
    {
        try {
            $organization = $request->attributes->get('tenant.organization');
            $apiKey = $request->attributes->get('tenant.api_key');

            if (!$organization) {
                return;
            }

            $statusCode = $response->getStatusCode();
            $success = $statusCode >= 200 && $statusCode < 300;

            $requestData = null;
            if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
                $requestData = $request->all();
                unset($requestData['password'], $requestData['secret'], $requestData['token']);
            }

            $responseData = null;
            if ($response->headers->get('content-type') === 'application/json') {
                try {
                    $responseData = json_decode($response->getContent(), true);
                } catch (\Exception $e) {
                    // Silent fail
                }
            }

            $action = $this->determineAction($request);
            $resourceType = $this->determineResourceType($request);
            $resourceId = $this->extractResourceId($request);

            \App\Models\AuditLog::log(
                $organization,
                $apiKey,
                $action,
                $request->method(),
                $request->getPathInfo(),
                $request->ip(),
                $statusCode,
                $resourceType,
                $resourceId,
                $requestData,
                $responseData,
                $request->header('User-Agent'),
                $success,
                !$success ? $response->getContent() : null,
                $responseTimeMs,
            );
        } catch (\Exception $e) {
            // Silent fail - don't disrupt request
        }
    }

    private function determineAction(Request $request): string
    {
        $path = $request->path();
        $method = $request->method();

        if (str_contains($path, 'printpage')) {
            return 'print_job_created';
        } elseif (str_contains($path, 'device/register')) {
            return 'device_registered';
        } elseif (str_contains($path, 'device/authenticate')) {
            return 'device_authenticated';
        } elseif (str_contains($path, 'api-keys/create')) {
            return 'api_key_created';
        } elseif (str_contains($path, 'webhook')) {
            return match ($method) {
                'POST' => 'webhook_created',
                'PUT' => 'webhook_updated',
                'DELETE' => 'webhook_deleted',
                default => 'webhook_action',
            };
        }

        return match ($method) {
            'POST' => 'resource_created',
            'PUT', 'PATCH' => 'resource_updated',
            'DELETE' => 'resource_deleted',
            'GET' => 'resource_queried',
            default => 'api_call',
        };
    }

    private function determineResourceType(Request $request): ?string
    {
        $path = $request->path();

        if (str_contains($path, 'print-')) {
            return 'print_job';
        } elseif (str_contains($path, 'device')) {
            return 'device';
        } elseif (str_contains($path, 'api-key')) {
            return 'api_key';
        } elseif (str_contains($path, 'webhook')) {
            return 'webhook';
        }

        return null;
    }

    private function extractResourceId(Request $request): ?int
    {
        $id = $request->input('id') ?? $request->input('print_job_id') ?? $request->input('device_id') ?? $request->input('webhook_id');

        return $id ? (int)$id : null;
    }
}
