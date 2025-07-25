<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AdminController;

use App\Http\Controllers\API\AuthController;


// Person API Routes
Route::prefix('people')->group(function () {
    Route::middleware('check.user.id', 'auth.jwt')->group(function () {
        Route::get('/show_all_people', [UserController::class, 'getAllPeople']);
        Route::put('/update_user/{id}', [UserController::class, 'update']);
    });
});

// Auth API Routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth.jwt')->post('/logout', [AuthController::class, 'logout']);
    Route::middleware('auth.jwt')->post('/change_password', [AuthController::class, 'changePassword']);
    Route::post('/reset_password', [AuthController::class, 'resetPassword']);
    Route::post('/forgot_password', [AuthController::class, 'forgotPassword']);
});

Route::prefix('admin')->middleware(['auth.jwt', 'check.admin'])->group(function () {   
    Route::post('/register', [AuthController::class, 'register']);
    Route::middleware('check.user.status')->group(function () {
        Route::get('/set_admin/{id}', [AdminController::class, 'setAdmin']);
        Route::get('/set_user/{id}', [AdminController::class, 'setUser']);
        Route::delete('/delete_account/{id}', [AuthController::class, 'deleteAccount']);
    });
    Route::get('/restore_account/{id}', [AuthController::class, 'restoreAccount']);
    Route::get('/export_users', [AdminController::class, 'exportUsers']);
    Route::post('/import_users', [AdminController::class, 'importUsers']);
    Route::get('/users_deleted', [AdminController::class, 'usersDeleted']);
    Route::get('/send_emails_to_people', [AdminController::class, 'sendBatchEmailsToPeople']);
});






