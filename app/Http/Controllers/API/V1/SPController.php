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
        // Fetch the token from the api_keys table (modify query as needed for specific users)
        $apiKey = \Illuminate\Support\Facades\DB::table('api_keys')->value('token');
        
        // Return the encrypted token
        return encrypt($apiKey);
    }

    public function status(Request $request)
    {
        // 1. Add your tracking/logging logic here
        // e.g., \Log::info('Agent status check initiated', ['user_id' => auth()->id()]);

        // 2. Return the token so the frontend can execute the local call
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