<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookDelivery extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_FAILED = 'failed';

    protected $fillable = [
        'webhook_id',
        'organization_id',
        'event',
        'payload',
        'status',
        'attempt',
        'http_status',
        'response_body',
        'error_message',
        'next_retry_at',
        'delivered_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'next_retry_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function webhook()
    {
        return $this->belongsTo(Webhook::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function markDelivered(?int $httpStatus = null, ?string $responseBody = null): void
    {
        $this->update([
            'status' => self::STATUS_DELIVERED,
            'http_status' => $httpStatus,
            'response_body' => $responseBody,
            'delivered_at' => now(),
        ]);

        $this->webhook->recordSuccess();
    }

    public function markFailed(?int $httpStatus = null, ?string $errorMessage = null, ?string $responseBody = null): void
    {
        $webhook = $this->webhook;
        $nextAttempt = $this->attempt + 1;

        if ($nextAttempt <= $webhook->retry_count) {
            $backoffSeconds = 60 * $nextAttempt;
            $this->update([
                'status' => self::STATUS_PENDING,
                'http_status' => $httpStatus,
                'error_message' => $errorMessage,
                'response_body' => $responseBody,
                'attempt' => $nextAttempt,
                'next_retry_at' => now()->addSeconds($backoffSeconds),
            ]);
        } else {
            $this->update([
                'status' => self::STATUS_FAILED,
                'http_status' => $httpStatus,
                'error_message' => $errorMessage,
                'response_body' => $responseBody,
                'attempt' => $nextAttempt,
            ]);
        }
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isDelivered(): bool
    {
        return $this->status === self::STATUS_DELIVERED;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }
}
