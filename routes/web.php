<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('data')->group(function () {
   Route::prefix('{locale}')->group(function () {
        Route::get('/', [\App\Http\Controllers\PageController::class, 'apiLangPages'])
            ->name('index');

       Route::get('/news', [\App\Http\Controllers\NewsController::class,'apiLangPages'])
           ->name('news');

        Route::get('/news/{path}', [\App\Http\Controllers\NewsController::class,'apiLangPages'])
            ->where('path', '^[a-zA-Z0-9-_\/]+$')
            ->name('news-detail');

        Route::get('/{path}', [\App\Http\Controllers\PageController::class, 'apiLangPages'])
            ->where('path', '^(?!admin)[a-zA-Z0-9-_\/]+$')
            ->name('page');
    });

   // Default locale
    Route::get('/{path}', [\App\Http\Controllers\PageController::class,'apiLangPages'])
        ->where('path', '^(?!admin)[a-zA-Z0-9-_\/]+$')
        ->name('page-default');

    Route::get('/', [\App\Http\Controllers\PageController::class,'apiLangPages'])
        ->name('index-default');

    Route::get('/news', [\App\Http\Controllers\NewsController::class,'apiLangPages'])
        ->name('news-default');

    Route::get('/news/{path}', [\App\Http\Controllers\NewsController::class,'apiLangPages'])
        ->where('path', '^[a-zA-Z0-9-_\/]+$')
        ->name('news-default');

    Route::post('/form/create-news', [\App\Http\Controllers\FormController::class,'newsSubscriptionCreate']);
    Route::post('/form/create-cooperation', [\App\Http\Controllers\FormController::class,'cooperationCreate']);
    Route::post('/form/create-about', [\App\Http\Controllers\FormController::class,'aboutCreate']);
});

