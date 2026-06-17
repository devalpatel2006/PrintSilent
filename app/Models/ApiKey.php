<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($apiKey) {
            if (empty($apiKey->token)) {
                $apiKey->token = Str::random(60);
            }
        });
    }

    protected $fillable = [
        'organization_id',
        'name',
        'public_key',
        'secret',
        'abilities',
        'allowed_ips',
        'rate_limit_per_minute',
        'revoked',
        'expires_at',
        'last_used_at',
        'last_rotated_at',
        'token_algorithm',
        'token_expiry_seconds',
        'jwt_enabled',
    ];

    protected $hidden = [
        'secret',
        'token',
    ];

    protected $casts = [
        'secret' => 'encrypted',
        'abilities' => 'array',
        'revoked' => 'boolean',
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
        'last_rotated_at' => 'datetime',
        'jwt_enabled' => 'boolean',
    ];

    public static function generatePublicKey(): string
    {
        return 'pk_' . Str::upper(Str::random(40));
    }

    public static function generateSecret(): string
    {
        return Str::random(64);
    }

    public function allowsAbility(string $ability): bool
    {
        return in_array($ability, $this->abilities ?? [], true);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function usageLogs()
    {
        return $this->hasMany(UsageLog::class);
    }

    public function printJobs()
    {
        return $this->hasMany(PrintJob::class);
    }

    public function generateJWT(): string
    {
        $payload = [
            'iss' => config('app.url'),
            'sub' => $this->id,
            'org_id' => $this->organization_id,
            'public_key' => $this->public_key,
            'iat' => now()->timestamp,
            'exp' => now()->addSeconds($this->token_expiry_seconds)->timestamp,
            'abilities' => $this->abilities,
        ];

        return \Firebase\JWT\JWT::encode(
            $payload,
            $this->secret,
            $this->token_algorithm
        );
    }

    public function verifyJWT(string $token): bool
    {
        try {
            $decoded = \Firebase\JWT\JWT::decode(
                $token,
                new \Firebase\JWT\Key($this->secret, $this->token_algorithm)
            );

            return $decoded->sub === $this->id && $decoded->org_id === $this->organization_id;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function rotateSecret(): self
    {
        $this->update([
            'secret' => self::generateSecret(),
            'last_rotated_at' => now(),
        ]);

        return $this;
    }
}
