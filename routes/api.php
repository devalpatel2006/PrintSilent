<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\SPController;
use App\Http\Controllers\API\V1\AuthController;



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