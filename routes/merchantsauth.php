<?php

use App\Http\Controllers\merchants\Auth\AuthenticatedSessionController;
use App\Http\Controllers\merchants\Auth\PasswordController;
use App\Http\Controllers\merchants\Auth\RegisteredMerchantController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

        Route::group(
            [
                'prefix' => LaravelLocalization::setLocale(),
                'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
            ], function() {

                Route::middleware('guest')->group(function () {

                    // Registration Routes
                    // Route::get('register/merchants', [RegisteredMerchantController::class, 'create'])->name('register.merchants');
                    Route::post('registerstore', [RegisteredMerchantController::class, 'store'])->name('registerstore');

                    // Login Routes
                    Route::get('loginmer', [AuthenticatedSessionController::class, 'create'])->name('loginmer');
                    Route::post('loginmerchants', [AuthenticatedSessionController::class, 'store'])->name('loginmerchants');

                });

                Route::middleware('merchant.auth')->group(function () {
                    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
                    Route::post('logout/merchants', [AuthenticatedSessionController::class, 'destroy'])->name('logout.merchants');
                });
            });
