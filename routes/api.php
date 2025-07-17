<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PersonController;

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
    });
});

// Auth API Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth.jwt')->post('/logout', [AuthController::class, 'logout']);
    Route::middleware('auth.jwt')->post('/change_password', [AuthController::class, 'changePassword']);
    Route::post('/reset_password', [AuthController::class, 'resetPassword']);
    Route::post('/forgot_password', [AuthController::class, 'forgotPassword']);
    Route::delete('/delete_account/{id}', [AuthController::class, 'deleteAccount']);
});

Route::prefix('admin')->middleware(['auth.jwt', 'check.admin'])->group(function () {       
    Route::get('/unactive_person/{id}', [PersonController::class, 'unactivePerson']);
    Route::get('/active_person/{id}', [PersonController::class, 'activePerson']);
    Route::get('/unactive_all_person', [PersonController::class, 'unactiveAllPerson']);
    Route::get('/active_all_person', [PersonController::class, 'activeAllPerson']);
});

Route::post('/registerMutilsPerson', [AuthController::class, 'registerMutilsPerson']);
