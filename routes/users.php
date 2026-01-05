<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


                Route::get('/Dashboard/{page}', [AdminController::class, 'index']);

        Route::group(
            [
                'prefix' => LaravelLocalization::setLocale(),
                'middleware' => ['auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'can_login', 'xss']
            ], function() {

                Route::get('/', function () {
                    return view('Dashboard_UMC.users.index');
                });

            });

// Route::get('/dashboard', function () {
//     return view('welcome');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/usersauth.php';
