<?php

use App\Http\Controllers\clients\Auth\AuthenticatedSessionController;
use App\Http\Controllers\clients\Auth\PasswordController;
use App\Http\Controllers\clients\Auth\RegisteredClientController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

        Route::group(
            [
                'prefix' => LaravelLocalization::setLocale(),
                'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
            ], function() {

                Route::middleware('guest')->group(function () {

                    // Registration Routes
                    Route::get('register/clients', [RegisteredClientController::class, 'create'])->name('register.clients');
                    Route::post('register', [RegisteredClientController::class, 'store'])->name('registerstore.clients');

                    // Login Routes
                    Route::get('login/clients', [AuthenticatedSessionController::class, 'create'])->name('login.clients');
                    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('loginstore.clients');
                });

                Route::middleware('client.auth')->group(function () {
                    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
                    Route::post('logout/clients', [AuthenticatedSessionController::class, 'destroy'])->name('logout.clients');
                });

            });
