<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'printer_group_id',
        'name',
        'identifier',
        'is_default',
        'health_status',
        'health_score',
        'last_heartbeat_at',
        'metadata',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'health_score' => 'integer',
        'last_heartbeat_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function group()
    {
        return $this->belongsTo(PrinterGroup::class, 'printer_group_id');
    }

    public function markAsDefault(): self
    {
        static::where('organization_id', $this->organization_id)->update(['is_default' => false]);
        $this->update(['is_default' => true]);

        return $this;
    }

    public function updateHealth(string $status, int $score, ?array $metadata = null): self
    {
        $this->update([
            'health_status' => $status,
            'health_score' => max(0, min(100, $score)),
            'last_heartbeat_at' => now(),
            'metadata' => $metadata ?? $this->metadata,
        ]);

        return $this;
    }
}
