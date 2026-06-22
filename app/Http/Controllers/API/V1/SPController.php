<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class SPController extends Controller
{
    /**
     * Get the encrypted token from the api_keys table
     */
    private function getEncryptedToken()
    {
        $user = auth('web')->user();
        if (!$user) {
            return null;
        }

        $apiKeyModel = null;
        if ($user->is_admin) {
            $apiKeyModel = \App\Models\ApiKey::first();
        } else {
            $orgIds = $user->organizations()->pluck('organizations.id');
            $apiKeyModel = \App\Models\ApiKey::whereIn('organization_id', $orgIds)->first();
        }

        if (!$apiKeyModel) {
            return null;
        }

        $apiKey = $apiKeyModel->token ?? $apiKeyModel->public_key;
        return $apiKey ? encrypt($apiKey) : null;
    }

    public function status(Request $request)
    {
        \Log::info('SPController@status hit', [
            'session_id' => $request->session()->getId(),
            'user' => auth('web')->user() ? auth('web')->user()->id : null,
            'cookies' => $request->cookies->all()
        ]);

        return response()->json([
            'success' => true,
            'encryptedToken' => $this->getEncryptedToken()
        ]);
    }

   public function fetch_printer_list(Request $request)
   {
        // 1. Add your tracking/logging logic here
        // e.g., \Log::info('Printer list fetch initiated', ['user_id' => auth()->id()]);

        return response()->json([
            'success' => true,
            'encryptedToken' => $this->getEncryptedToken()
        ]);
   }

    public function print(Request $request)
    {
        // 1. Add your tracking/logging logic here
        // e.g., \Log::info('Print job initiated', [
        //     'user_id' => auth()->id(),
        //     'printer' => $request->printer,
        //     'url' => $request->url
        // ]);

        return response()->json([
            'success' => true,
            'encryptedToken' => $this->getEncryptedToken()
        ]);
    }
}