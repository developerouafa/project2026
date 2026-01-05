<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\users\Auth\ImageuserController;
use App\Http\Controllers\users\Auth\ProfileController;
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

                //############################# Start Partie Profile User ##########################################

                    Route::group(['prefix' => 'Profile'], function(){
                        Route::controller(ProfileController::class)->group(function() {
                            Route::get('/profile', 'edit')->name('profile.edit');
                            Route::patch('/profile', 'updateprofile')->name('profile.update');
                            Route::delete('/profile', 'destroy')->name('profile.destroy');
                        });

                        Route::controller(ImageuserController::class)->group(function() {
                            Route::post('/imageuser', 'store')->name('imageuser.store');
                            Route::patch('/imageuser', 'update')->name('imageuser.update');
                            Route::get('/imageuser', 'destroy')->name('imageuser.delete');
                        });
                    });
                //############################# end Partie Profile User ######################################

            });


require __DIR__.'/usersauth.php';
