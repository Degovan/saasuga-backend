<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UrlController;
use App\Http\Controllers\Api\UserController;
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

Route::controller(LoginController::class)->group(function () {
    Route::get('login/{provider}', 'redirectToProvider');
    Route::get('login/{provider}/callback', 'handleProviderCallback');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'show']);
    Route::delete('user', [UserController::class, 'logout']);

    Route::apiResource('urls', UrlController::class);
});
