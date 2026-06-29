<?php

namespace App\Providers;

use App\Services\SeoService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(SeoService::class, function () {
            return new SeoService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer('layouts.frontend', function ($view) {
            $seo = app(SeoService::class);
            $view->with('seo', $seo->toArray());
        });
    }
}
