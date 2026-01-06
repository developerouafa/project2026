
<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\merchants\Auth\ImagemerchantController;
use App\Http\Controllers\merchants\Auth\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


        Route::group(
            [
                'prefix' => LaravelLocalization::setLocale(),
                'middleware' => ['merchant.auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'can_login_merchants', 'xss']
            ], function() {

                Route::get('/merchants', function () {
                    return view('Dashboard_UMC.merchants.index');
                });

                //############################# Start Partie Profile User ##########################################

                    Route::group(['prefix' => 'Profile'], function(){
                        Route::controller(ProfileController::class)->group(function() {
                            Route::get('/profilemerchante', 'edit')->name('profilemerchant.edit');
                            Route::patch('/profilemerchantu', 'updateprofile')->name('profilemerchant.update');
                            Route::delete('/profilemerchantd', 'destroy')->name('profilemerchant.destroy');
                        });

                        Route::controller(ImagemerchantController::class)->group(function() {
                            Route::post('/imagemerchants', 'store')->name('imagemerchant.store');
                            Route::patch('/imagemerchantu', 'update')->name('imagemerchant.update');
                            Route::get('/imagemerchantd', 'destroy')->name('imagemerchant.delete');
                        });
                    });
                //############################# end Partie Profile User ######################################

            });

require __DIR__.'/merchantsauth.php';
