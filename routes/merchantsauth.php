<?php

use App\Http\Controllers\merchants\Auth\AuthenticatedSessionController;
use App\Http\Controllers\merchants\Auth\ConfirmablePasswordController;
use App\Http\Controllers\merchants\Auth\PasswordController;
use App\Http\Controllers\merchants\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

        Route::group(
            [
                'prefix' => LaravelLocalization::setLocale(),
                'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
            ], function() {

                Route::middleware('guest')->group(function () {

                    Route::get('register/merchants', [RegisteredUserController::class, 'create'])->name('register.merchants');
                    Route::post('register', [RegisteredUserController::class, 'store'])->name('registerstore.merchants');

                    Route::get('login/merchants', [AuthenticatedSessionController::class, 'create'])->name('login.merchants');
                    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('loginstore.merchants');

                });

                Route::middleware('merchant.auth')->group(function () {

                    // Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                    //             ->name('password.confirm');

                    // Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

                    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

                    Route::post('logout/merchants', [AuthenticatedSessionController::class, 'destroy'])->name('logout.merchants');
                });
            });
