<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\users\Auth\ImageuserController;
use App\Http\Controllers\users\Auth\ProfileController;
use App\Http\Controllers\users\users\RolesUserController;
use App\Http\Controllers\users\users\UserController;
use App\Livewire\DashboardUMC\Users\Sections\Sections;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

                // Route::get('/Dashboard/{page}', [AdminController::class, 'index']);

        Route::group(
            [
                'prefix' => LaravelLocalization::setLocale(),
                'middleware' => ['auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'can_login', 'xss']
            ], function() {

                Route::get('/', function () {
                    return view('Dashboard_UMC.users.index');
                });

                //############################# Start Partie Profile User ##########################################

                    Route::group(['prefix' => 'Profile'], function(){
                        Route::controller(ProfileController::class)->group(function() {
                            Route::get('/profile', 'edit')->name('profile.edit');
                            Route::patch('/profile', 'updateprofile')->name('profile.update');
                        });

                        Route::controller(ImageuserController::class)->group(function() {
                            Route::post('/imageuser', 'store')->name('imageuser.store');
                            Route::patch('/imageuser', 'update')->name('imageuser.update');
                            Route::get('/imageuser', 'destroy')->name('imageuser.delete');
                        });
                    });
                //############################# end Partie Profile User ######################################

                //############################# Start Partie User|permissions|Roles route ##########################################
                    Route::resource('users', UserController::class);
                    Route::resource('roles', RolesUserController::class);
                    Route::controller(UserController::class)->group(function() {
                        Route::get('/Deleted_Users', 'softusers')->name('Users.softdeleteusers');
                        Route::get('/deleteallusers', 'deleteallusers')->name('Users.deleteallusers');
                        Route::get('/deleteallusers_softdelete', 'deletealluserssoftdelete')->name('Users.deletealluserssoftdelete');
                        Route::get('restoreusers/{id}', 'restoreusers')->name('Users.restoreusers');
                        Route::get('restoreallusers', 'restoreallusers')->name('Users.restoreallusers');
                        Route::post('restoreallselectusers', 'restoreallselectusers')->name('Users.restoreallselectusers');
                    });
                //############################# end Partie User|permissions|roles route ######################################


                // ############################# Start Partie Sections route ##########################################
                    Route::group(['prefix' => 'Sections'], function(){
                            // Route::middleware(['auth','permission:section-list'])->group(function () {
                            // Route::get('/sections', Sections::class)->name('sections.render');
                            // Route::view('sections','livewire.dashboard-u-m-c.users.sections.index');
                            Route::view('welcome','livewire.dashboard-u-m-c.users.sections.welcome');
                            // Route::view('index','livewire.dashboard-u-m-c.users.sections.index');
                        // });
                    });
                // ############################# end Partie Sections route ######################################
            });


require __DIR__.'/usersauth.php';
