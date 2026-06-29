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

use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\SitemapController;
use App\Http\Controllers\Frontend\ContactController;


// ─── Frontend Static Pages (SEO) ─────────────────────────────────────
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/features', [PageController::class, 'features'])->name('pages.features');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pages.pricing');
Route::get('/download', [PageController::class, 'download'])->name('pages.download');
Route::get('/api-documentation', [PageController::class, 'apiDocs'])->name('pages.api-docs');
Route::get('/faq', [PageController::class, 'faq'])->name('pages.faq');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('pages.contact.submit');

Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('pages.privacy');
Route::get('/terms-of-service', [PageController::class, 'terms'])->name('pages.terms');
Route::get('/about', [PageController::class, 'about'])->name('pages.about');

// ─── XML Sitemap ─────────────────────────────────────────────────────
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

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

        // Visitor Tracking
        Route::get('/visitors', [\App\Http\Controllers\Admin\AdminVisitorController::class, 'index'])->name('visitors.index');

        // Contact Messages
        Route::get('/contacts', [\App\Http\Controllers\Admin\AdminContactController::class, 'index'])->name('contacts.index');

        Route::delete('/visitors/delete-all', [\App\Http\Controllers\Admin\AdminVisitorController::class, 'deleteAll'])->name('visitors.delete_all');
    });
});