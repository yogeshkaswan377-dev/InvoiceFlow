<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProformaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GSTInvoiceController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['company.selected'])
        ->name('dashboard');

    // Company Management
    Route::prefix('company')->group(function () {

        Route::get('/create', [CompanyController::class, 'create'])
            ->name('company.create');

        Route::post('/store', [CompanyController::class, 'store'])
            ->name('company.store');

        Route::get('/switch', [CompanyController::class, 'switchCompany'])
            ->name('company.switch');

        Route::post('/switch/{company}', [CompanyController::class, 'setCurrentCompany'])
            ->name('company.set');

        Route::get('/settings', [CompanyController::class, 'settings'])
            ->name('company.settings');

        Route::put('/settings/{company}', [CompanyController::class, 'update'])
            ->name('company.update');
    });

    // App Settings
    Route::prefix('settings')->group(function () {

        Route::get('/', [SettingController::class, 'index'])
            ->name('settings.index');

        Route::post('/update', [SettingController::class, 'update'])
            ->name('settings.update');

        Route::post('/upload-logo', [SettingController::class, 'uploadLogo'])
            ->name('settings.upload.logo');

        Route::post('/upload-signature', [SettingController::class, 'uploadSignature'])
            ->name('settings.upload.signature');

        Route::delete('/logo/remove', [SettingController::class, 'removeMedia'])
            ->name('settings.logo.remove');

        Route::post('/remove-media', [SettingController::class, 'removeMedia'])
            ->name('settings.remove.media');
    });

    // Client Management
    Route::prefix('clients')
        ->middleware(['company.selected'])
        ->group(function () {

            // CRUD Routes
            Route::get('/', [ClientController::class, 'index'])
                ->name('clients.index');

            Route::get('/create', [ClientController::class, 'create'])
                ->name('clients.create');

            Route::post('/', [ClientController::class, 'store'])
                ->name('clients.store');

            Route::get('/search', [ClientController::class, 'search'])
                ->name('clients.search');

            Route::get('/filter/state', [ClientController::class, 'filterByState'])
                ->name('clients.filter.state');

            Route::get('/filter/status', [ClientController::class, 'filterByStatus'])
                ->name('clients.filter.status');

            Route::get('/{client}', [ClientController::class, 'show'])
                ->name('clients.show');

            Route::get('/{client}/edit', [ClientController::class, 'edit'])
                ->name('clients.edit');

            Route::put('/{client}', [ClientController::class, 'update'])
                ->name('clients.update');

            Route::delete('/{client}', [ClientController::class, 'destroy'])
                ->name('clients.destroy');
        });

    // ============================================
    // PHASE 4A: PROFORMA INVOICES
    // ============================================
    Route::prefix('proformas')
        ->middleware(['company.selected'])
        ->name('proformas.')
        ->group(function () {

            Route::get('/', [ProformaController::class, 'index'])
                ->name('index');

            Route::get('/create', [ProformaController::class, 'create'])
                ->name('create');

            Route::post('/', [ProformaController::class, 'store'])
                ->name('store');

            Route::get('/{id}', [ProformaController::class, 'show'])
                ->name('show')
                ->where('id', '[0-9]+');

            Route::get('/{id}/edit', [ProformaController::class, 'edit'])
                ->name('edit')
                ->where('id', '[0-9]+');

            Route::put('/{id}', [ProformaController::class, 'update'])
                ->name('update')
                ->where('id', '[0-9]+');

            Route::delete('/{id}', [ProformaController::class, 'destroy'])
                ->name('destroy')
                ->where('id', '[0-9]+');

            Route::post('/proformas/{id}/convert-to-gst', [ProformaController::class, 'convertToGst'])
                ->name('proformas.convert-to-gst');
        });


    // ============================================
    // PHASE 4B: GST INVOICES
    // ============================================
    Route::prefix('gst-invoices')
        ->middleware(['company.selected'])
        ->name('gst-invoices.')
        ->group(function () {

            Route::get('/', [GSTInvoiceController::class, 'index'])
                ->name('index');

            Route::get('/create', [GSTInvoiceController::class, 'create'])
                ->name('create');

            Route::post('/', [GSTInvoiceController::class, 'store'])
                ->name('store');

            Route::get('/{id}', [GSTInvoiceController::class, 'show'])
                ->name('show')
                ->where('id', '[0-9]+');

            Route::get('/{id}/edit', [GSTInvoiceController::class, 'edit'])
                ->name('edit')
                ->where('id', '[0-9]+');

            Route::put('/{id}', [GSTInvoiceController::class, 'update'])
                ->name('update')
                ->where('id', '[0-9]+');

            Route::delete('/{id}', [GSTInvoiceController::class, 'destroy'])
                ->name('destroy')
                ->where('id', '[0-9]+');
        });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
