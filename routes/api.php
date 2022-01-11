<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\LoyaltyPointsController;
use App\Http\Controllers\LoyaltyPointsTransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'user'], function () {
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix' => 'account', 'middleware' => 'accountParamsIsValid'], function () {
        Route::post('create', [AccountController::class, 'create'])
            ->withoutMiddleware('accountParamsIsValid');
        Route::post('activate/{type}/{id}', [AccountController::class, 'activate']);
        Route::post('deactivate/{type}/{id}', [AccountController::class, 'deactivate']);
        Route::get('balance/{type}/{id}', [AccountController::class, 'balance']);
    });

    Route::group(['prefix' => 'loyaltyPoints'], function () {
        Route::post('deposit', [LoyaltyPointsController::class, 'deposit']);
        Route::post('cancel', [LoyaltyPointsController::class, 'cancel']);
        Route::post('withdraw', [LoyaltyPointsController::class, 'withdraw']);
    });

    Route::group(['prefix' => 'loyaltyPoints/v2'], function () {
        Route::post('deposit', [LoyaltyPointsTransactionController::class, 'deposit']);
        Route::post('cancel', [LoyaltyPointsTransactionController::class, 'cancel']);
        Route::post('withdraw', [LoyaltyPointsTransactionController::class, 'withdraw']);
    });
});





