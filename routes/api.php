<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\MidtransController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/menu', [MenuApiController::class, 'index']);
Route::post('/order', [OrderApiController::class, 'store']);


Route::get('/get-laravel-user-id', [UserController::class, 'getLaravelUserId']);

Route::post('/sync-product', [MenuApiController::class, 'sync']);
Route::post('/sync-user', [UserController::class, 'syncUser']);


Route::get('/orders/{user_id}', [OrderApiController::class, 'getUserOrders']);

Route::post('/update-fcm-token', [UserController::class, 'updateFcmToken']);
Route::post('/midtrans/callback', [MidtransController::class, 'callback']);



