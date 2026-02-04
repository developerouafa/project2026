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
