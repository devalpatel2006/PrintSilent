<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrinterGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'name',
        'description',
        'routing_strategy',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function printers()
    {
        return $this->hasMany(Printer::class);
    }
}
