
<?php

use App\Http\Controllers\merchants\Auth\ImagemerchantController;
use App\Http\Controllers\merchants\Auth\ProfileController;
use App\Http\Controllers\merchants\merchants\MerchantController;
use App\Http\Controllers\merchants\merchants\RolesMerchantController;
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

                //############################# Start Partie Profile Merchant ##########################################

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
                //############################# end Partie Profile Merchant ######################################

                //############################# Start Partie merchant|permissions|Roles route ##########################################
                    Route::resource('merchants', MerchantController::class);
                    Route::resource('roles', RolesMerchantController::class);
                    Route::controller(MerchantController::class)->group(function() {
                        Route::get('editstatusdéactivemerchant/{id}', 'editstatusdéactive')->name('editstatusdéactivemerchant');
                        Route::get('editstatusactivemerchant/{id}', 'editstatusactive')->name('editstatusactivemerchant');
                        Route::get('/Deleted_merchants', 'softmerchants')->name('merchants.softdeletemerchants');
                        Route::get('/deleteallmerchants', 'deleteallmerchants')->name('merchants.deleteallmerchants');
                        Route::get('/deleteallmerchants_softdelete', 'deleteallmerchantssoftdelete')->name('merchants.deleteallmerchantssoftdelete');
                        Route::get('restoremerchants/{id}', 'restoremerchants')->name('merchants.restoremerchants');
                        Route::get('restoreallmerchants', 'restoreallmerchants')->name('merchants.restoreallmerchants');
                        Route::post('restoreallselectmerchants', 'restoreallselectmerchants')->name('merchants.restoreallselectmerchants');
                    });
                //############################# end Partie User|permissions|roles route ######################################

            });

require __DIR__.'/merchantsauth.php';
