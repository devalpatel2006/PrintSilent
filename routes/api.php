<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\SPController;
use App\Http\Controllers\API\V1\AuthController;

Route::get('/v1/status/{port?}', [SPController::class, 'status']);
Route::post('/v1/fetch_printer_list', [SPController::class,'fetch_printer_list']);
Route::post('/v1/print', [SPController::class,'print']);

/*
|--------------------------------------------------------------------------
| Custom API Key Authentication Routes
|--------------------------------------------------------------------------
|
| POST   /api/v1/auth/me      → Get authenticated user profile using ApiKey
|
*/

// Public route as token is validated inside the controller
Route::post('/v1/auth/me', [AuthController::class, 'me']);
Route::post('/v1/auth/third-party-token', [AuthController::class, 'generateEncryptedToken']);