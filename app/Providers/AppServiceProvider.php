<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GST\GSTCalculationService;
use App\Services\GST\TaxBreakdownService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(GSTCalculationService::class, function ($app) {
            return new GSTCalculationService();
        });

        $this->app->singleton(TaxBreakdownService::class, function ($app) {
            return new TaxBreakdownService($app->make(GSTCalculationService::class));
        });
    }
}
