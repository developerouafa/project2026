
<?php

use App\Http\Controllers\merchants\Auth\ImagemerchantController;
use App\Http\Controllers\merchants\Auth\ProfileController;
use App\Http\Controllers\merchants\merchants\MerchantController;
use App\Http\Controllers\merchants\merchants\RolesMerchantController;
use App\Http\Controllers\merchants\StripeWebhookController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Livewire\Dashboardumc\merchants\Products;
use App\Livewire\Dashboardumc\Merchants\Products\createproductnocolor;
use App\Livewire\Dashboardumc\merchants\Products\ProductIndex;
use App\Livewire\Dashboardumc\merchants\Products\ProductForm;
use App\Livewire\Dashboardumc\merchants\Products\ProductImages;
use App\Models\Sections;

    Route::group(
        [
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => ['merchant.auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'can_login_merchants', 'xss']
        ], function() {

            Route::get('/merchants', function () {
                return view('Dashboard_UMC.merchants.index');
            });

            //############################# Start Partie Profile Merchant ##########################################

                Route::group(['prefix' => 'ProfileMerchant'], function(){
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
                Route::group(['prefix' => 'Merchants_Permissions_Merchant'], function(){
                    Route::resource('merchant', MerchantController::class);
                    Route::resource('rolesmerchant', RolesMerchantController::class);
                    Route::controller(MerchantController::class)->group(function() {
                        Route::get('/Deleted_merchants', 'softmerchants')->name('merchant.softdeletemerchants');
                        Route::get('/deleteallmerchants', 'deleteallmerchants')->name('merchant.deleteallmerchants');
                        Route::get('/deleteallmerchants_softdelete', 'deleteallmerchantssoftdelete')->name('merchant.deleteallmerchantssoftdelete');
                        Route::get('restoremerchants/{id}', 'restoremerchants')->name('merchant.restoremerchants');
                        Route::get('restoreallmerchants', 'restoreallmerchants')->name('merchant.restoreallmerchants');
                        Route::post('restoreallselectmerchants', 'restoreallselectmerchants')->name('merchant.restoreallselectmerchants');
                    });
                });

            //############################# end Partie User|permissions|roles route ######################################


            // ############################# Start Partie Products route ##########################################

                Route::view('/dashboard/products','livewire.Dashboardumc.merchants.products.products')->name('dashboard.products');
                Route::view('/dashboard/createproductnocolor','livewire.Dashboardumc.merchants.products.createnocolor')->name('dashboard.createproductnocolor');

                Route::view('/dashboard/productscolor','livewire.Dashboardumc.merchants.ProductsColor.include_create')->name('dashboard.productscolor');

                Route::view('/dashboard/promotions','livewire.Dashboardumc.merchants.Promotions.index')->name('dashboard.promotions');

            // ############################# end Partie Products route ######################################

            //############################# GroupProducts route ##########################################

                Route::view('Add_GroupProducts','livewire.Dashboardumc.merchants.GroupProducts.include_create')->name('Add_GroupProducts');

            //############################# end GroupProducts route ######################################

            //############################# Merchants Order route ##########################################

                Route::view('ordersmerchant','livewire.Dashboardumc.merchants.orders')->name('ordersmerchant');
                Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);
            //############################# end Merchants Order route ######################################

        });

require __DIR__.'/merchantsauth.php';
