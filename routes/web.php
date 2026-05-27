<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ClientController;
use Illuminate\Support\Facades\Route;

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

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';
