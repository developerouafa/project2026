<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SizesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('api/user', function (Request $request) {
    return $request->user();
});

Route::get('registerapi', [AuthController::class , 'registertwo']);
Route::get('loginapi', [AuthController::class , 'login']);

Route::get('testapi', function () {
    return response()->json(['ok' => true]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class , 'user']);
    Route::post('/logout', [AuthController::class , 'logout']);

    // مسار المقاسات (Sizes Route) - CRUD complete
    // Route::apiResource('sizesapi', SizesController::class);
    Route::get('/sizesapi', [SizesController::class , 'index']);
    Route::post('/sizesapistore', [SizesController::class , 'store']);
    Route::get('/sizesapishow/{id}', [SizesController::class , 'show']);
    Route::put('/sizesapiupdate/{id}', [SizesController::class , 'update']);
    Route::delete('/sizesapidestroy/{id}', [SizesController::class , 'destroy']);

});
