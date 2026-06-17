<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class SPController extends Controller
{
    public function status($port = 4545)
    {
        try {
            $response = Http::get("http://127.0.0.1:{$port}/status");
            return response()->json($response->json(), $response->status());
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'inactive',
                'error' => 'failed'
            ], 500);
        }
    }

   public function fetch_printer_list(Request $request)
{
    try {

        $port = $request->input('port', 4545); // Default port 4545

        $response = Http::withHeaders([
            'x-api-key' => 'SPRINT_SAAS_SECURE_KEY_2024',
        ])->get("http://127.0.0.1:{$port}/v1/printers");

        return response()->json(
            $response->json(),
            $response->status()
        );

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}
    public function print(Request $request)
    {
        try {

            $port = $request->input('port', 4545);

            $response = Http::withHeaders([
                'x-api-key' => 'SPRINT_SAAS_SECURE_KEY_2024',
            ])->get("http://127.0.0.1:{$port}/v1/print/url", [
                'url'     => $request->url,
                'printer' => $request->printer,
                'width'   => $request->width ?? 101.6,
                'height'  => $request->height ?? 152.4,
                'copies'  => $request->copies ?? 1,
            ]);

            return response()->json(
                $response->json(),
                $response->status()
            );

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}