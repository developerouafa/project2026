<?php

// use App\Http\Controllers\AdminController;
// use App\Http\Controllers\ProfileController;
// use App\Livewire\Testcrud;
use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Route;
// use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


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


    //! Clear Cache  //! Clear Config //! Cache Config //! Clear Route
    Route::get('/clear', function() {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return redirect()->back();
    });

                // Route::get('Dashboard/{page}', [AdminController::class, 'index']);

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

// require __DIR__.'/auth.php';


    Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function(){

            // Route::group(
            //     [
            //         'prefix' => LaravelLocalization::setLocale(),
            //         'middleware' => [
            //             'auth',
            //             'localeSessionRedirect',
            //             'localizationRedirect',
            //             'localeViewPath',
            //             'can_login',
            //             'xss'
            //             ]
            //     ], function() {

                // Route::get('/welcomemodel', function () {
                //     return view('livewire.welcome');
                // });
                    Route::view('/welcomemodel','livewire.welcome');

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


                //############################# Section & Children Section route ##########################################
                    Route::group(['prefix' => 'Sections'], function(){
                        Route::controller(SectionsController::class)->group(function() {
                            Route::get('/index', 'index')->name('Sections.index');
                            Route::get('/export', 'export')->name('Sections.export');
                            Route::get('/Deleted_Section', 'softdelete')->name('Sections.softdelete');
                            Route::get('/Show_by_Section/{id}', 'showsection')->name('Sections.showsection');
                            Route::post('/create', 'store')->name('Sections.store');
                            Route::patch('/update', 'update')->name('Sections.update');
                            Route::delete('/destroy', 'destroy')->name('Sections.destroy');
                            Route::get('editstatusdéactivesec/{id}', 'editstatusdéactive')->name('editstatusdéactivesec');
                            Route::get('editstatusactivesec/{id}', 'editstatusactive')->name('editstatusactivesec');
                            Route::get('/deleteallSections', 'deleteall')->name('Sections.deleteallSections');
                            Route::get('/deleteall_softdelete', 'deleteallsoftdelete')->name('Sections.deleteallsoftdelete');
                            Route::get('restoresc/{id}', 'restore')->name('restoresc');
                            Route::get('restoreallsections', 'restoreallsections')->name('Sections.restoreallsections');
                            Route::post('restoreallselectsections', 'restoreallselectsections')->name('Sections.restoreallselectsections');
                        });

                        Route::controller(childrenController::class)->group(function() {
                            Route::get('/child', 'index')->name('Children_index');
                            Route::get('/Deleted_Children', 'softdelete')->name('Children.softdelete');
                            Route::get('/Show_by_Children/{id}', 'showchildren')->name('Children.showchildren');
                            Route::post('/createchild', 'store')->name('Children.create');
                            Route::patch('/updatechild', 'update')->name('Children.update');
                            Route::delete('/deletechild', 'destroy')->name('Children.delete');
                            Route::get('editstatusdéactivech/{id}', 'editstatusdéactive')->name('editstatusdéactivech');
                            Route::get('editstatusactivech/{id}', 'editstatusactive')->name('editstatusactivech');
                            Route::get('/deleteallChildrens', 'deleteall')->name('Children.deleteallChildrens');
                            Route::get('/deleteallsoftdelete', 'deleteallsoftdelete')->name('Children.deleteallsoftdelete');
                            Route::get('restorech/{id}', 'restore')->name('restorech');
                            Route::get('restoreallchildrens', 'restoreallchildrens')->name('Children.restoreallchildrens');
                            Route::post('restoreallselectchildrens', 'restoreallselectchildrens')->name('Children.restoreallselectchildrens');
                        });
                    });
                //############################# end Section & Children Section route ######################################

                // ############################# Start Partie Sizes route ##########################################

                    Route::view('/dashboard/sizes','livewire.Dashboardumc.users.sizes.index')->name('sizes.index');

                // ############################# end Partie Sizes route ######################################


            });


require __DIR__.'/users.php';
require __DIR__.'/merchants.php';
require __DIR__.'/clients.php';
require __DIR__.'/api.php';
