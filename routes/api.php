<?php

use App\Http\Controllers\AuthController;
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

Route::name('api.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
});

Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::prefix('/news')->name('news.')->group(function () {
        Route::get('/by-author/{author}', [NewsController::class, 'newsByAuthor'])->name('by-author');
        Route::post('/', [NewsController::class, 'store'])->name('store');
        Route::get('/search/{search}', [NewsController::class, 'search'])->name('search');
        Route::get('/{news}', [NewsController::class, 'show'])->name('show');
        Route::get('/by-topic/{topic}', [NewsController::class, 'newsByTopic'])->name('by-topic');
    });

    Route::prefix('/authors')->name('authors.')->group(function () {
        Route::get('/', [AuthorController::class, 'index'])->name('index');
        Route::post('/', [AuthorController::class, 'store'])->name('store');
    });

    Route::prefix('/topics')->name('topics.')->group(function () {
        Route::post('/', [TopicController::class, 'store'])->name('store');
    });
});
