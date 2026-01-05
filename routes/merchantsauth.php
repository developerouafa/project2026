<?php

use App\Http\Controllers\merchants\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

        Route::group(
            [
                'prefix' => LaravelLocalization::setLocale(),
                'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
            ], function() {

                Route::middleware('guest')->group(function () {

                    Route::get('login/merchants', [AuthenticatedSessionController::class, 'create'])->name('login.merchants');
                    Route::post('login/merchants', [AuthenticatedSessionController::class, 'store'])->name('login.merchants');

                });

                Route::middleware('auth:merchants')->group(function () {
                    Route::post('logout/merchants', [AuthenticatedSessionController::class, 'destroy'])->name('logout.merchants');
                });
            });
