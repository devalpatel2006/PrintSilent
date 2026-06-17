<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'domain',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_users')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function usageLogs()
    {
        return $this->hasMany(UsageLog::class);
    }

    public function printJobs()
    {
        return $this->hasMany(PrintJob::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function printerGroups()
    {
        return $this->hasMany(PrinterGroup::class);
    }

    public function printers()
    {
        return $this->hasMany(Printer::class);
    }

    public function defaultPrinter()
    {
        return $this->printers()->where('is_default', true);
    }

    public function onlineDevices()
    {
        return $this->devices()->where('status', 'online');
    }

    public function offlineDevices()
    {
        return $this->devices()->where('status', 'offline');
    }
}
