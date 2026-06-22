<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ApiDocsController extends Controller
{
    public function index()
    {
        $apiKey = \Illuminate\Support\Facades\DB::table('api_keys')->value('token') ?? 'YOUR_RAW_API_KEY_HERE';
        $encryptedToken = $apiKey !== 'YOUR_RAW_API_KEY_HERE' ? encrypt($apiKey) : 'YOUR_ENCRYPTED_TOKEN_HERE';

        return view('admin.api-docs.index', compact('apiKey', 'encryptedToken'));
    }
}
