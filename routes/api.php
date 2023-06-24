<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TopicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::prefix('/news')->name('news.')->group(function () {
        Route::get('/by-author/{author}', [NewsController::class, 'newsByAuthor'])->name('by-author');
        Route::post('/', [NewsController::class, 'store'])->name('store');
    });

    Route::prefix('/authors')->name('authors.')->group(function () {
        Route::get('/', [AuthorController::class, 'index'])->name('index');
    });

    Route::prefix('/topics')->name('topics.')->group(function () {
        Route::post('/', [TopicController::class, 'store'])->name('store');
    });
});
