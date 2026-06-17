<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintJob extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_QUEUED = 'queued';
    const STATUS_PROCESSING = 'processing';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_PRINTED = 'printed';
    const STATUS_FAILED = 'failed';

    protected $fillable = [
        'organization_id',
        'user_id',
        'api_key_id',
        'device_id',
        'printer_name',
        'image_url',
        'payload',
        'priority',
        'status',
        'response_data',
        'retry_count',
        'started_at',
        'completed_at',
        'error_message',
    ];

    protected $casts = [
        'payload' => 'array',
        'response_data' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function apiKey()
    {
        return $this->belongsTo(ApiKey::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function logs()
    {
        return $this->hasMany(PrintLog::class)->orderByDesc('created_at');
    }

    public function updateStatus(string $newStatus, ?string $message = null, ?array $metadata = null, ?string $triggeredBy = null): self
    {
        $previousStatus = $this->status;

        $this->update(['status' => $newStatus]);

        PrintLog::create([
            'print_job_id' => $this->id,
            'organization_id' => $this->organization_id,
            'status' => $newStatus,
            'previous_status' => $previousStatus,
            'message' => $message,
            'metadata' => $metadata,
            'triggered_by' => $triggeredBy ?? 'system',
        ]);

        return $this;
    }

    public function markQueued(): self
    {
        return $this->updateStatus(self::STATUS_QUEUED, 'Print job queued for processing');
    }

    public function markProcessing(): self
    {
        return $this->update(['started_at' => now()])
            && $this->updateStatus(self::STATUS_PROCESSING, 'Print job processing started');
    }

    public function markDelivered(?array $responseData = null): self
    {
        $this->update([
            'response_data' => $responseData,
            'completed_at' => now(),
        ]);

        return $this->updateStatus(self::STATUS_DELIVERED, 'Print job delivered to device');
    }

    public function markPrinted(?array $responseData = null): self
    {
        $this->update([
            'response_data' => $responseData,
            'completed_at' => now(),
        ]);

        $this->updateStatus(self::STATUS_PRINTED, 'Print job completed successfully');

        return $this;
    }

    public function markFailed(?string $errorMessage = null, ?array $metadata = null): self
    {
        $this->update([
            'error_message' => $errorMessage,
            'completed_at' => now(),
        ]);

        $this->updateStatus(self::STATUS_FAILED, $errorMessage, $metadata);

        return $this;
    }

    public function incrementRetry(): self
    {
        return $this->increment('retry_count');
    }

    public function canRetry(int $maxRetries = 3): bool
    {
        return $this->retry_count < $maxRetries && in_array($this->status, [self::STATUS_FAILED, self::STATUS_QUEUED]);
    }

    public function isCompleted(): bool
    {
        return in_array($this->status, [self::STATUS_PRINTED, self::STATUS_FAILED]);
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isQueued(): bool
    {
        return $this->status === self::STATUS_QUEUED;
    }

    public function isProcessing(): bool
    {
        return $this->status === self::STATUS_PROCESSING;
    }

    public function isFailed(): bool
    {
        return $this->status === self::STATUS_FAILED;
    }
}
