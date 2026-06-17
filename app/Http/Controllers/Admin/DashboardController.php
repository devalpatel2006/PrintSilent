<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Models\Organization;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'organizations' => Organization::count(),
            'api_keys' => ApiKey::count(),
        ];

        return view('admin.dashboard', [
            'stats' => $stats,
            'organizations' => Organization::latest()->limit(10)->get(['id', 'name', 'slug', 'created_at']),
            'apiKeys' => ApiKey::latest()->limit(10)->get(['id', 'organization_id', 'name', 'public_key', 'revoked', 'expires_at', 'last_used_at']),
        ]);
    }
}
