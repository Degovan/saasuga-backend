<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UrlController;
use Illuminate\Http\Request;
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
    Route::post('login/{provider}', 'handleProviderCallback');
    Route::get('login/{provider}/code', 'getProviderCode');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('urls', UrlController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
