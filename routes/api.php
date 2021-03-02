<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserActionLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
});

Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
});

Route::apiResource('books', BookController::class)->middleware('auth:api');

Route::apiResource('logs', UserActionLogController::class)->middleware('auth:api');


Route::middleware('auth:api')->prefix('books')->group(function () {
    Route::get('checkin/{bookID}', [BookController::class, 'checkIn']);
    Route::get('checkout/{bookID}', [BookController::class, 'checkOut']);
});
