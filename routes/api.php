<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
});

Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);

        Route::post('register', [AuthController::class, 'register']);
});


Route::prefix('books')->middleware('auth:api')->group(function () {
    Route::resource('/', BookController::class);
    Route::post('checkin/{bookID}', [BookController::class, 'checkIn']);
    Route::post('checkout/{bookID}', [BookController::class, 'checkOut']);
});
