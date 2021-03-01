<?php

use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
});

Route::prefix('auth')->group(function () {
        Route::post('login', function () {
            return true;
        });

        Route::post('register', function () {
            return true;
        });
});

Route::resource('books', BookController::class);

Route::prefix('books')->group(function () {
    Route::post('checkin/{bookID}', [BookController::class, 'checkIn']);
    Route::post('checkout/{bookID}', [BookController::class, 'checkOut']);
});
