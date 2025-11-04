<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class ExternalApiController extends Controller
{
    public function psv1(Request $request)
    {
         $postData = $request->all(); // or customize the payload
         $response = Http::get('http://localhost:8781/shippingprint', $postData);
        return response()->json([
            'status' => $response->successful(),
            'queryparam' => $postData
        ]);
    }
}