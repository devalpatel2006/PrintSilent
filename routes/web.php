<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrganizationController;
use App\Http\Controllers\Admin\AdminApiKeyController;
use App\Http\Controllers\Admin\PlaygroundController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/login');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    Route::middleware(\App\Http\Middleware\EnsureAdminAuthenticated::class)->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Admin Playground
        Route::get('/playground', [PlaygroundController::class, 'index'])->name('playground.index');

        // New Resource Routes
        Route::resource('organizations', AdminOrganizationController::class);
        Route::resource('api-keys', AdminApiKeyController::class);
    });
});