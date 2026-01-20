
<?php

use App\Http\Controllers\clients\Auth\ImageclientController;
use App\Http\Controllers\clients\Auth\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


        Route::group(
            [
                'prefix' => LaravelLocalization::setLocale(),
                'middleware' => ['client.auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'can_login_clients', 'xss']
            ], function() {

                    Route::view('/clients','livewire.Clients.Index')->name('Products');

                //############################# Start Partie Profile Client ##########################################

                    Route::group(['prefix' => 'Profile'], function(){
                        Route::controller(ProfileController::class)->group(function() {
                            Route::get('/profileclient', 'edit')->name('profileclient.edit');
                            Route::patch('/profileclientu', 'updateprofile')->name('profileclient.update');
                            Route::delete('/profileclientd', 'destroy')->name('profileclient.destroy');
                        });

                        Route::controller(ImageclientController::class)->group(function() {
                            Route::post('/imageclients', 'store')->name('imageclient.store');
                            Route::patch('/imageclientu', 'update')->name('imageclient.update');
                            Route::get('/imageclientd', 'destroy')->name('imageclient.delete');
                        });
                    });
                //############################# end Partie Profile Client ######################################

            });

require __DIR__.'/clientsauth.php';
