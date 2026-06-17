<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'plan',
        'status',
        'stripe_id',
        'stripe_status',
        'price_cents',
        'currency',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'trial_ends_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
