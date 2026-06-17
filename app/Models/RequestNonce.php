<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestNonce extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'nonce',
        'ip_address',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public static function generateNonce(): string
    {
        return bin2hex(random_bytes(16));
    }

    public static function isValid(string $nonce, string $ip): bool
    {
        $record = static::where('nonce', $nonce)
            ->where('ip_address', $ip)
            ->where('expires_at', '>', now())
            ->first();

        if ($record) {
            $record->delete();
            return true;
        }

        return false;
    }

    public static function cleanExpired(): int
    {
        return static::where('expires_at', '<=', now())->delete();
    }
}
