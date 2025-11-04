<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class ExternalApiController extends Controller
{
    public function psv1(Request $request)
    {
         //$postData = $request->all(); // or customize the payload
         //$response = Http::get('http://127.0.0.1:8781/shippingprint', $postData);
         $queryParams = http_build_query($request->all()); // build query string 
         $url = "http://127.0.0.1:8781/shippingprint?$queryParams";
         return redirect()->away($url); // redirect browser to Dart API
    }
}