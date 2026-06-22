<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ApiDocsController extends Controller
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

        $apiKey = $apiKeyModel ? $apiKeyModel->token : 'YOUR_RAW_API_KEY_HERE';
        // Note: The above assumes token is stored in the DB as 'token' per previous migrations. 
        // Let's ensure we use the actual public_key if token is not available. Wait, the DB previously used 'token' column but ApiKey migration uses 'public_key'.
        // Actually, looking at the previous logic: DB::table('api_keys')->value('token') ?? 'YOUR_RAW_API_KEY_HERE';
        $apiKey = $apiKeyModel ? ($apiKeyModel->token ?? $apiKeyModel->public_key ?? 'YOUR_RAW_API_KEY_HERE') : 'YOUR_RAW_API_KEY_HERE';

        $encryptedToken = $apiKey !== 'YOUR_RAW_API_KEY_HERE' ? encrypt($apiKey) : 'YOUR_ENCRYPTED_TOKEN_HERE';

        return view('admin.api-docs.index', compact('apiKey', 'encryptedToken'));
    }
}
