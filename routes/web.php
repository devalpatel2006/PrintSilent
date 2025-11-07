<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\API\ExternalApiController;
Route::get('/', [ExternalApiController::class, 'welcome'])->name('welcome');