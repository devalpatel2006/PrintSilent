<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrganizationController;
use App\Http\Controllers\Admin\AdminApiKeyController;
use App\Http\Controllers\Admin\PlaygroundController;
use App\Http\Controllers\Admin\ApiDocsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ─── Frontend ────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('frontend.index');
})->name('home');

// Frontend Auth (register + login)
Route::get('/register', [FrontendAuthController::class, 'showRegister'])->name('register');
Route::post('/register', [FrontendAuthController::class, 'register'])->name('register.submit');
Route::get('/login', [FrontendAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [FrontendAuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [FrontendAuthController::class, 'logout'])->name('logout');

// ─── Frontend SP Agent APIs ───────────────────────────────────────────
Route::middleware('auth')->prefix('api/v1')->group(function () {
    Route::get('/status/{port?}', [\App\Http\Controllers\API\V1\SPController::class, 'status']);
    Route::post('/fetch_printer_list', [\App\Http\Controllers\API\V1\SPController::class, 'fetch_printer_list']);
    Route::post('/print', [\App\Http\Controllers\API\V1\SPController::class, 'print']);
});

// ─── Admin Panel ─────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(\App\Http\Middleware\EnsureAdminAuthenticated::class)->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Admin Playground
        Route::get('/playground', [PlaygroundController::class, 'index'])->name('playground.index');

        // API Documentation
        Route::get('/api-docs', [ApiDocsController::class, 'index'])->name('api-docs.index');

        // User Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        // New Resource Routes
        Route::resource('organizations', AdminOrganizationController::class);
        Route::resource('api-keys', AdminApiKeyController::class);
    });
});