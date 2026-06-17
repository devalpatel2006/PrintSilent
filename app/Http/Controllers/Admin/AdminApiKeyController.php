<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Models\Organization;
use Illuminate\Http\Request;

class AdminApiKeyController extends Controller
{
    public function index()
    {
        $apiKeys = ApiKey::with('organization')->orderBy('created_at', 'desc')->get();
        return view('admin.api-keys.index', compact('apiKeys'));
    }

    public function create()
    {
        $organizations = Organization::orderBy('name')->get();
        return view('admin.api-keys.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|string|max:255',
            'expires_at' => 'nullable|date',
            'rate_limit_per_minute' => 'required|integer|min:1|max:10000',
            'abilities' => 'nullable|string',
            'allowed_ips' => 'nullable|string',
        ]);

        $secret = ApiKey::generateSecret();
        
        // Parse abilities
        $abilities = ['*'];
        if (!empty($validated['abilities'])) {
            $abilities = array_map('trim', explode(',', $validated['abilities']));
        }

        $apiKey = ApiKey::create([
            'organization_id' => $validated['organization_id'],
            'name' => $validated['name'],
            'public_key' => ApiKey::generatePublicKey(),
            'secret' => encrypt($secret),
            'abilities' => $abilities,
            'allowed_ips' => $validated['allowed_ips'],
            'rate_limit_per_minute' => $validated['rate_limit_per_minute'],
            'expires_at' => $validated['expires_at'],
        ]);

        // We only show the secret once upon creation.
        // The unencrypted secret is passed back to the view via session.
        $keyDetails = [
            'name' => $apiKey->name,
            'public_key' => $apiKey->public_key,
            'secret' => $secret,
        ];

        return redirect()->route('admin.api-keys.index')
            ->with('success', 'API Key generated successfully. Make sure to copy the secret now.')
            ->with('created_api_key', $keyDetails);
    }

    public function destroy(ApiKey $apiKey)
    {
        $apiKey->update(['revoked' => true]);
        return redirect()->route('admin.api-keys.index')
            ->with('success', 'API Key revoked successfully.');
    }
}
