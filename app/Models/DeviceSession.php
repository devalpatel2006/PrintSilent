<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DeviceSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'session_token',
        'ip_address',
        'user_agent',
        'authenticated_at',
        'expires_at',
        'last_activity_at',
    ];

    protected $casts = [
        'authenticated_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    public static function generateToken(): string
    {
        return 'sess_' . hash('sha256', Str::random(64));
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isActive(): bool
    {
        return ! $this->isExpired();
    }

    public function touchActivity(): self
    {
        $this->update(['last_activity_at' => now()]);

        return $this;
    }
}
