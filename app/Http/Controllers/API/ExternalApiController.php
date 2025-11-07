<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class ExternalApiController extends Controller
{

    public function welcome(Request $request)
    {
        $printerdata = Http::get('http://localhost:8781/GetPrinterData'); 
        $printers = $printerdata['printer'] ?? [];
        return view('welcome', compact('printers'));
    }

    public function printepage(Request $request)
    {
        $printerName = $request->input('printer_name'); // "HP LaserJet Pro MFP M126nw"
        $imageUrl = $request->input('imageurl');  
        $queryParams = [
        'printer' => $printerName,
        'url' => $imageUrl,
        // Optionally add width and height
        'width' => $request->input('width', 1016),
        'height' => $request->input('height', 2032),
    ];
        $postData = $request->all(); // or customize the payload
        $responsedata = Http::get('http://localhost:8781/shippingprint', $queryParams); 
        return response()->json([
                'status' => "true",
                'response'=> $responsedata
        ]);
    }
}