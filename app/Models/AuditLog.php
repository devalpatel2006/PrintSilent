<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'api_key_id',
        'action',
        'resource_type',
        'resource_id',
        'method',
        'path',
        'ip_address',
        'status_code',
        'request_data',
        'response_data',
        'user_agent',
        'success',
        'error_message',
        'response_time_ms',
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
        'success' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function apiKey()
    {
        return $this->belongsTo(ApiKey::class);
    }

    public static function log(
        Organization $organization,
        ?ApiKey $apiKey,
        string $action,
        string $method,
        string $path,
        string $ip,
        int $statusCode,
        ?string $resourceType = null,
        ?int $resourceId = null,
        ?array $requestData = null,
        ?array $responseData = null,
        ?string $userAgent = null,
        bool $success = true,
        ?string $errorMessage = null,
        ?float $responseTimeMs = null,
    ): self {
        return static::create([
            'organization_id' => $organization->id,
            'api_key_id' => $apiKey?->id,
            'action' => $action,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
            'method' => $method,
            'path' => $path,
            'ip_address' => $ip,
            'status_code' => $statusCode,
            'request_data' => $requestData,
            'response_data' => $responseData,
            'user_agent' => $userAgent,
            'success' => $success,
            'error_message' => $errorMessage,
            'response_time_ms' => $responseTimeMs,
        ]);
    }
}
