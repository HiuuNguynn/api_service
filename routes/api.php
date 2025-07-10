<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PersonController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Person API Routes
Route::prefix('people')->group(function () {
    Route::get('/', [PersonController::class, 'index'])->name('api.people.index');
    Route::get('/create', [PersonController::class, 'create'])->name('api.people.create');
    Route::post('/', [PersonController::class, 'store'])->name('api.people.store');

    Route::middleware('check.user.id')->group(function () {
        Route::get('/{id}', [PersonController::class, 'show'])->name('api.people.show');
        Route::get('/{id}/edit', [PersonController::class, 'edit'])->name('api.people.edit');
        Route::put('/{id}', [PersonController::class, 'update'])->name('api.people.update');
        Route::delete('/{id}', [PersonController::class, 'destroy'])->name('api.people.destroy');
        Route::get('/{id}/with-posts', [PersonController::class, 'getPersonWithPosts'])->name('api.people.with-posts');
    });
});

// Post API Routes
Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('api.posts.index');
    Route::get('/create', [PostController::class, 'create'])->name('api.posts.create');
    Route::post('/', [PostController::class, 'store'])->name('api.posts.store');

    Route::middleware('check.id.post')->group(function () {
        Route::get('/{id}', [PostController::class, 'show'])->name('api.posts.show');
        Route::get('/{id}/edit', [PostController::class, 'edit'])->name('api.posts.edit');
        Route::put('/{id}', [PostController::class, 'update'])->name('api.posts.update');
        Route::delete('/{id}', [PostController::class, 'destroy'])->name('api.posts.destroy');
    });
});

// Auth API Routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
    Route::middleware('auth.jwt')->post('/change_password', [AuthController::class, 'changePassword']);
    Route::post('/reset_password', [AuthController::class, 'resetPassword']);
    Route::post('/forgot_password', [AuthController::class, 'forgotPassword']);
});
