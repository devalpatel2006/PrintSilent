<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Models\Organization;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_admin) {
            $stats = [
                'Total Organizations' => Organization::count(),
                'Total API Keys' => ApiKey::count(),
                'Total Users' => \App\Models\User::count(),
            ];

            return view('admin.dashboard', [
                'stats' => $stats,
                'organizations' => Organization::latest()->limit(10)->get(['id', 'name', 'slug', 'created_at']),
                'apiKeys' => ApiKey::with('organization')->latest()->limit(10)->get(),
            ]);
        } else {
            $orgIds = auth()->user()->organizations()->pluck('organizations.id');
            
            $stats = [
                'Your Organizations' => $orgIds->count(),
                'Active API Keys' => ApiKey::whereIn('organization_id', $orgIds)->where('revoked', false)->count(),
                // 'Connected Printers' => \App\Models\Printer::whereIn('organization_id', $orgIds)->count(),
            ];

            return view('admin.dashboard', [
                'stats' => $stats,
                'organizations' => auth()->user()->organizations()->latest()->limit(10)->get(),
                'apiKeys' => ApiKey::with('organization')->whereIn('organization_id', $orgIds)->latest()->limit(10)->get(),
            ]);
        }
    }
}
