<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'login'], function () {
    Route::get('/{provider}', [AuthController::class, 'loginWithProvider'])->name('login.social');
    Route::get('/{provider}/callback', [AuthController::class, 'handleCallbackByProvider'])->name('login.callback');
    Route::post('/get-token', [AuthController::class, 'getToken'])->name('login.getToken');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
