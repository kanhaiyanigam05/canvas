<?php

use Kanhaiyanigam05\Http\Middleware\Admin;
use Kanhaiyanigam05\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use Kanhaiyanigam05\Http\Controllers\Auth\AuthenticatedSessionController;
use Kanhaiyanigam05\Http\Controllers\Auth\PasswordResetLinkController;
use Kanhaiyanigam05\Http\Controllers\Auth\NewPasswordController;
use Kanhaiyanigam05\Http\Controllers\UploadsController;
use Kanhaiyanigam05\Http\Controllers\PostController;
use Kanhaiyanigam05\Http\Controllers\TagController;
use Kanhaiyanigam05\Http\Controllers\TopicController;
use Kanhaiyanigam05\Http\Controllers\UserController;
use Kanhaiyanigam05\Http\Controllers\SearchController;
Route::namespace('Auth')->group(function () {
    // Login routes...
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('canvas.login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Forgot password routes...
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('canvas.password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('canvas.password.email');

    // Reset password routes...
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('canvas.password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('canvas.password.update');

    // Logout routes...
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('canvas.logout');
});

Route::middleware([Authenticate::class])->group(function () {
    Route::prefix('api')->group(function () {
        // Stats routes...
        Route::get('stats', 'StatsController');

        // Upload routes...
        Route::prefix('uploads')->group(function () {
            Route::post('/', [UploadsController::class, 'store']);
            Route::delete('/', [UploadsController::class, 'destroy']);
        });

        // Post routes...
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index']);
            Route::get('create', [PostController::class, 'create']);
            Route::get('{id}', [PostController::class, 'show']);
            Route::get('{id}/stats', [PostController::class, 'stats']);
            Route::post('{id}', [PostController::class, 'store']);
            Route::delete('{id}', [PostController::class, 'destroy']);
        });

        // Tag routes...
        Route::prefix('tags')->middleware([Admin::class])->group(function () {
            Route::get('/', [TagController::class, 'index']);
            Route::get('create', [TagController::class, 'create']);
            Route::get('{id}', [TagController::class, 'show']);
            Route::get('{id}/posts', [TagController::class, 'posts']);
            Route::post('{id}', [TagController::class, 'store']);
            Route::delete('{id}', [TagController::class, 'destroy']);
        });

        // Topic routes...
        Route::prefix('topics')->middleware([Admin::class])->group(function () {
            Route::get('/', [TopicController::class, 'index']);
            Route::get('create', [TopicController::class, 'create']);
            Route::get('{id}', [TopicController::class, 'show']);
            Route::get('{id}/posts', [TopicController::class, 'posts']);
            Route::post('{id}', [TopicController::class, 'store']);
            Route::delete('{id}', [TopicController::class, 'destroy']);
        });

        // User routes...
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->middleware([Admin::class]);
            Route::get('create', [UserController::class, 'create'])->middleware([Admin::class]);
            Route::get('{id}', [UserController::class, 'show']);
            Route::get('{id}/posts', [UserController::class, 'posts']);
            Route::post('{id}', [UserController::class, 'store']);
            Route::delete('{id}', [UserController::class, 'destroy'])->middleware([Admin::class]);
        });

        // Search routes...
        Route::prefix('search')->group(function () {
            Route::get('posts', [SearchController::class, 'posts']);
            Route::get('tags', [SearchController::class, 'tags'])->middleware([Admin::class]);
            Route::get('topics', [SearchController::class, 'topics'])->middleware([Admin::class]);
            Route::get('users', [SearchController::class, 'users'])->middleware([Admin::class]);
        });
    });

    // Catch-all route...
    Route::get('/{view?}', 'ViewController')->where('view', '(.*)')->name('canvas');
});
