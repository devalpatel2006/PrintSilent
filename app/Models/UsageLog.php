<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'api_key_id',
        'endpoint',
        'method',
        'request_payload',
        'response_status',
        'response_payload',
        'ip_address',
    ];

    protected $casts = [
        'request_payload' => 'array',
        'response_payload' => 'array',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function apiKey()
    {
        return $this->belongsTo(ApiKey::class);
    }
}
