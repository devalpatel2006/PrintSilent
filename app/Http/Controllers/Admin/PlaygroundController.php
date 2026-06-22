<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlaygroundController extends Controller
{
    public function index()
    {
        $apiKeyModel = null;
        
        if (auth()->user()->is_admin) {
            $apiKeyModel = \App\Models\ApiKey::first();
        } else {
            $orgIds = auth()->user()->organizations()->pluck('organizations.id');
            $apiKeyModel = \App\Models\ApiKey::whereIn('organization_id', $orgIds)->first();
        }

        $apiKey = $apiKeyModel ? ($apiKeyModel->token ?? $apiKeyModel->public_key) : null;

        return view('admin.playground.index', compact('apiKey'));
    }
}
