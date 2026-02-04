<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Testcrud;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

    //! Clear Cache  //! Clear Config //! Cache Config //! Clear Route
    Route::get('/clear', function() {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return redirect()->back();
    });

require __DIR__.'/users.php';
require __DIR__.'/merchants.php';
require __DIR__.'/clients.php';
require __DIR__.'/api.php';
