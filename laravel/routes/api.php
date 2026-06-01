<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FriendController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\EnsureUserIsApproved;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', EnsureUserIsApproved::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/friends', [FriendController::class, 'index']);
    Route::post('/friends/request/{username}', [FriendController::class, 'sendRequest']);
    Route::put('/friends/accept/{id}', [FriendController::class, 'accept']);
    Route::delete('/friends/reject/{id}', [FriendController::class, 'reject']);

    Route::post('/messages', [MessageController::class, 'store']);

    Route::get('/users/search', [UserController::class, 'search']);
    Route::get('/users/{username}', [UserController::class, 'show']);
});
