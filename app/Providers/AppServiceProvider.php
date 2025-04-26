<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\SaleDetail;
use App\Observers\SaleDetailObserver;
use App\Services\SaleService;
use App\Services\StockService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(StockService::class, function ($app) {
            return new StockService();
        });
    
        $this->app->singleton(SaleService::class, function ($app) {
            return new SaleService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        SaleDetail::observe(SaleDetailObserver::class);
    }
}
