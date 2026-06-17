<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'print_job_id',
        'organization_id',
        'status',
        'previous_status',
        'message',
        'metadata',
        'triggered_by',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function printJob()
    {
        return $this->belongsTo(PrintJob::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
