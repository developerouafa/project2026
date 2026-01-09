<?php

use App\Http\Controllers\users\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

        Route::group(
            [
                'prefix' => LaravelLocalization::setLocale(),
                'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
            ], function() {

                // Authentication Routes
                Route::middleware('guest')->group(function () {

                    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                        ->name('login');

                    Route::post('loginusers', [AuthenticatedSessionController::class, 'store'])->name('loginusers');

                });

                // Logout Routes
                Route::middleware('auth')->group(function () {
                    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                        ->name('logout');
                });
            });
