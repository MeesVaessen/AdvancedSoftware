<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('jwt.auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('roles', [RoleController::class, 'createRole']);
    Route::post('users/{user}/roles/{role}', [RoleController::class, 'assignRole']);
    Route::delete('users/{user}/roles/{role}', [RoleController::class, 'removeRole']);
    Route::get('users/{user}/roles', [RoleController::class, 'getUserRoles']);
});
