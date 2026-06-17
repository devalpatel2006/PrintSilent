<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'url',
        'secret',
        'events',
        'active',
        'retry_count',
        'timeout_seconds',
        'description',
        'last_triggered_at',
        'last_successful_at',
    ];

    protected $casts = [
        'events' => 'array',
        'active' => 'boolean',
        'last_triggered_at' => 'datetime',
        'last_successful_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function deliveries()
    {
        return $this->hasMany(WebhookDelivery::class)->orderByDesc('created_at');
    }

    public function pendingDeliveries()
    {
        return $this->deliveries()
            ->where('status', '!=', 'delivered')
            ->where('next_retry_at', '<=', now());
    }

    public static function generateSecret(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    public function generateSignature(string $payload): string
    {
        return hash_hmac('sha256', $payload, $this->secret);
    }

    public function verifySignature(string $payload, string $signature): bool
    {
        return hash_equals($this->generateSignature($payload), $signature);
    }

    public function supportsEvent(string $event): bool
    {
        return in_array($event, $this->events ?? []);
    }

    public function recordTrigger(): void
    {
        $this->update(['last_triggered_at' => now()]);
    }

    public function recordSuccess(): void
    {
        $this->update(['last_successful_at' => now()]);
    }
}
