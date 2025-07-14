<?php

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
use Kanhaiyanigam05\Http\Controllers\ViewController;

// Public routes (no auth)
Route::prefix('auth')->group(function () {
    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('canvas.login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Forgot Password
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('canvas.password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('canvas.password.email');

    // Reset Password
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('canvas.password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('canvas.password.update');

    // Logout
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('canvas.logout');
});

// Protected routes (requires authentication)
//Route::middleware(['canvas.auth'])->group(function () {

    Route::prefix('api')->group(function () {
        // Stats
        Route::get('stats', [ViewController::class, 'stats']);

        // Uploads
        Route::prefix('uploads')->group(function () {
            Route::post('/', [UploadsController::class, 'store']);
            Route::delete('/', [UploadsController::class, 'destroy']);
        });

        // Posts
        Route::prefix('posts')->group(function () {
            Route::get('/', [PostController::class, 'index']);
            Route::get('create', [PostController::class, 'create']);
            Route::get('{id}', [PostController::class, 'show']);
            Route::get('{id}/stats', [PostController::class, 'stats']);
            Route::post('{id}', [PostController::class, 'store']);
            Route::delete('{id}', [PostController::class, 'destroy']);
        });

        // Tags (admin only)
        Route::prefix('tags')->middleware(['canvas.admin'])->group(function () {
            Route::get('/', [TagController::class, 'index']);
            Route::get('create', [TagController::class, 'create']);
            Route::get('{id}', [TagController::class, 'show']);
            Route::get('{id}/posts', [TagController::class, 'posts']);
            Route::post('{id}', [TagController::class, 'store']);
            Route::delete('{id}', [TagController::class, 'destroy']);
        });

        // Topics (admin only)
        Route::prefix('topics')->middleware(['canvas.admin'])->group(function () {
            Route::get('/', [TopicController::class, 'index']);
            Route::get('create', [TopicController::class, 'create']);
            Route::get('{id}', [TopicController::class, 'show']);
            Route::get('{id}/posts', [TopicController::class, 'posts']);
            Route::post('{id}', [TopicController::class, 'store']);
            Route::delete('{id}', [TopicController::class, 'destroy']);
        });

        // Users
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->middleware(['canvas.admin']);
            Route::get('create', [UserController::class, 'create'])->middleware(['canvas.admin']);
            Route::get('{id}', [UserController::class, 'show']);
            Route::get('{id}/posts', [UserController::class, 'posts']);
            Route::post('{id}', [UserController::class, 'store']);
            Route::delete('{id}', [UserController::class, 'destroy'])->middleware(['canvas.admin']);
        });

        // Search
        Route::prefix('search')->group(function () {
            Route::get('posts', [SearchController::class, 'posts']);
            Route::get('tags', [SearchController::class, 'tags'])->middleware(['canvas.admin']);
            Route::get('topics', [SearchController::class, 'topics'])->middleware(['canvas.admin']);
            Route::get('users', [SearchController::class, 'users'])->middleware(['canvas.admin']);
        });
    });

    // Fallback route (e.g. SPA view)
    Route::get('/{view?}', [ViewController::class, '__invoke'])->where('view', '(.*)')->name('canvas');
//});
