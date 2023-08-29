<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'login'], function () {
    Route::get('/{provider}', [AuthController::class, 'loginWithProvider'])->name('login.social');
    Route::get('/{provider}/callback', [AuthController::class, 'handleCallbackByProvider'])->name('login.callback');
    Route::post('/get-token', [AuthController::class, 'getToken'])->name('login.getToken');
});


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::group(['prefix' => 'users'], function () {
        Route::get('/{userId}/stats', [DashboardController::class, 'getStats'])->name('users.stats');
        Route::get('/{userId}/events', [DashboardController::class, 'getEvents'])->name('users.events');
        Route::get('/fill-data', [DashboardController::class, 'fillData'])->name('users.seeder');
    });

    Route::group(['prefix' => 'events'], function () {
        Route::put('/{eventId}/mark-as-read', [EventController::class, 'markAsRead'])->name('events.markAsRead');
        Route::put('/{eventId}/mark-as-unread', [EventController::class, 'markAsUnread'])->name('events.markAsUnread');
    });

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
