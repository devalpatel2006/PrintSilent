<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class SPController extends Controller
{
    /**
     * Get the API key for the current user's organization.
     * Returns the public_key string that the local agent validates against.
     */
   private function getEncryptedToken()
    {
        // Fetch the token from the api_keys table (modify query as needed for specific users)
        $apiKey = \Illuminate\Support\Facades\DB::table('api_keys')->value('token');
        
        // Return the encrypted token
        return encrypt($apiKey);
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