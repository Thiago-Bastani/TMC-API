<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SetupController;
use App\Http\Middleware\RedirectIfNoAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware(RedirectIfNoAdmin::class)->group(function () {
    Route::get('/setup', [SetupController::class, 'show']);
    Route::post('/setup', [SetupController::class, 'store']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth')->group(function () {
        Route::get('/', fn() => redirect('/dashboard'));
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::post('/dashboard/approve/{id}', [DashboardController::class, 'approve']);
        Route::post('/dashboard/reject/{id}', [DashboardController::class, 'reject']);
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
