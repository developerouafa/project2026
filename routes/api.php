<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SizesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('api/register', [AuthController::class, 'register']);
Route::get('api/registertwo', [AuthController::class, 'registertwo']);
Route::get('api/login', [AuthController::class, 'login']);

Route::get('api/test', function () {
    return response()->json(['ok' => true]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::apiResource('sizes', SizesController::class);
Route::get('sizes/index', [SizesController::class, 'index']);
Route::get('sizes/store', [SizesController::class, 'store']);
Route::get('sizes/{id}', [SizesController::class, 'show']);
Route::get('sizes/show/{id}', [SizesController::class, 'show']);
Route::put('sizes/update/{id}', [SizesController::class, 'update']);
Route::delete('sizes/destroy/{id}', [SizesController::class, 'destroy']);
