<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Route::get('/', function () {
//     return view('welcome');
// });

        // Route::group(
        //     [
        //         'prefix' => LaravelLocalization::setLocale(),
        //         'middleware' => ['auth','localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
        //     ], function() {

        //         Route::get('/Dashboard/{page}', [AdminController::class, 'index']);

        //     });

// Route::get('/dashboard', function () {
//     return view('welcome');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/users.php';
require __DIR__.'/merchants.php';
require __DIR__.'/clients.php';
require __DIR__.'/api.php';
