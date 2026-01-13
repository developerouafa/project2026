<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\users\Auth\ImageuserController;
use App\Http\Controllers\users\Auth\ProfileController;
use App\Http\Controllers\users\childrens\childrenController;
use App\Http\Controllers\users\sections\SectionsController;
use App\Http\Controllers\users\users\RolesUserController;
use App\Http\Controllers\users\users\UserController;
use App\Livewire\DashboardUMC\Users\Sections\Sections;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

                // Route::get('/Dashboard/{page}', [AdminController::class, 'index']);

                    // Route::view('/welcomemodel','livewire.welcome');

require __DIR__.'/usersauth.php';
