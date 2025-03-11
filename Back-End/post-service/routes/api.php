<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')->group(function () {
//    Route::middleware('jwt.auth')->group(function () {
        Route::post('/create', [PostController::class, 'createPost']);
        Route::post('/update', [PostController::class, 'updatePost']);
        Route::post('/delete', [PostController::class, 'deletePost']);
        Route::get('/{paginate}', [PostController::class, 'getPosts']);
        Route::get('/', [PostController::class, 'getPosts']);
    Route::get('/{id}', [PostController::class, 'getPost']);
//    });
});
