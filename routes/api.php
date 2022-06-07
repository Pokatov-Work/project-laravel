<?php

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

// Получение данных о криптовалютах
Route::prefix('crypto')->group(function () {
    Route::get('/list', [\App\Http\Controllers\ApiCryptoController::class, 'getWbtCryptoList']);
    Route::get('/graph', [\App\Http\Controllers\ApiCryptoController::class, 'getWbtCryptoGraph']);
    Route::get('/price', [\App\Http\Controllers\ApiCryptoController::class, 'getCryptoPrice']);

});
