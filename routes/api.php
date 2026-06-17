<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\SPController;

Route::get('/v1/status/{port?}', [SPController::class, 'status']);
Route::post('/v1/fetch_printer_list', [SPController::class,'fetch_printer_list']);
Route::post('/v1/print', [SPController::class,'print']);