<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

//logout
Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::apiResource('products', \App\Http\Controllers\Api\ProductController::class)->middleware('auth:sanctum');
Route::apiResource('orders', \App\Http\Controllers\Api\OrderController::class)->middleware('auth:sanctum');
