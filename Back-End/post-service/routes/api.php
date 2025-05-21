<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::prefix('posts')->group(function () {
    Route::post('/create', [PostController::class, 'createPost']);
    Route::post('/update', [PostController::class, 'updatePost']);
    Route::post('/delete', [PostController::class, 'deletePost']);
    Route::get('/{uuid}/like', [PostController::class, 'likePost']);
    Route::get('/{uuid}/dislike', [PostController::class, 'dislikePost']);
    Route::get('/health', function () {
        try {
            return response()->json(['status' => 'OK']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'DB Connection Error'], 500);
        }
    });
    Route::get('/{paginate}', [PostController::class, 'getPosts']);
    Route::get('/', [PostController::class, 'getPosts']);
    Route::get('/getPost/{uuid}', [PostController::class, 'getPost']);


});


