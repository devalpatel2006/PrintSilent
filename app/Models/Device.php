<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'fingerprint',
        'device_token',
        'device_type',
        'os',
        'os_version',
        'app_version',
        'metadata',
        'status',
        'last_seen_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'last_seen_at' => 'datetime',
    ];

    public static function generateToken(): string
    {
        return 'dvc_' . Str::upper(Str::random(32));
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function sessions()
    {
        return $this->hasMany(DeviceSession::class);
    }

    public function activeSessions()
    {
        return $this->sessions()->where('expires_at', '>', now());
    }

    public function markOnline(): self
    {
        $this->update([
            'status' => 'online',
            'last_seen_at' => now(),
        ]);

        return $this;
    }

    public function markOffline(): self
    {
        $this->update(['status' => 'offline']);

        return $this;
    }

    public function isOnline(): bool
    {
        return $this->status === 'online' && $this->activeSessions()->exists();
    }
}
