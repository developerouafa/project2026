
<?php

use App\Http\Controllers\clients\Auth\ImageclientController;
use App\Http\Controllers\clients\Auth\ProfileController;
use App\Http\Controllers\clients\StripeWebhookController;
use App\Models\Client;
use App\Notifications\OrderFinalStatusNotification;
use App\Notifications\TestNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\Request;

        Route::group(
            [
                'prefix' => LaravelLocalization::setLocale(),
                'middleware' => ['client.auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'can_login_clients', 'xss']
            ], function() {

                    Route::view('/clients','livewire.Clients.Index')->name('Products.clients');

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


                //############################# GroupProducts route ##########################################

                    Route::view('Cart', 'livewire.Clients.Cart')->name('Cart');

                //############################# GroupProducts route ##########################################

                Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);
                    Route::get('/checkout/success', function () {
                        return redirect()->route('Cart');
                    })->name('checkout.success');

                    Route::get('/checkout/cancel', function () {
                        return redirect()->route('Cart');
                    })->name('checkout.cancel');


                    Route::post('/client/notifications/mark-all-read', function (Request $request) {
                        $client = Auth::guard('clients')->user();
                        if ($client) {
                            $client->unreadNotifications->markAsRead();
                        }
                        return response()->json(['status' => 'success']);
                    })->name('client.notifications.markAllRead');

                    // Route::get('/test-notification', function () {
                    //     $client = Client::first(); // خذ أول client موجود

                    //     if (!$client) {
                    //         return "No client found!";
                    //     }

                    //     // صيفط notification
                    //     $client->notify(new TestNotification("Hello! This is a test notification."));

                    //     return "Test notification sent to client ID: {$client->id}";
                    // });
            });

require __DIR__.'/clientsauth.php';
