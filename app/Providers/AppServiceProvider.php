<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GST\GSTCalculationService;
use App\Services\GST\TaxBreakdownService;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use App\Repositories\InvoiceRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // GST Services
        $this->app->singleton(GSTCalculationService::class, function ($app) {
            return new GSTCalculationService();
        });

        $this->app->singleton(TaxBreakdownService::class, function ($app) {
            return new TaxBreakdownService($app->make(GSTCalculationService::class));
        });

        // Invoice Repository
        $this->app->bind(
            InvoiceRepositoryInterface::class,
            InvoiceRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
