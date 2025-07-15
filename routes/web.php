<?php

use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PersonController;
use App\Http\Controllers\API\PostController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// ...existing code...
Route::get('/people', [PersonController::class, 'index'])->name('people.index');
Route::get('/people/create', [PersonController::class, 'create'])->name('people.create');
Route::post('/people', [PersonController::class, 'store'])->name('people.store');
Route::get('/people/edit/{user_id}', [PersonController::class, 'edit'])->name('people.edit');
Route::put('/people/{user_id}', [PersonController::class, 'update'])->name('people.update');
Route::delete('/people/{user_id}', [PersonController::class, 'destroy'])->name('people.destroy');
Route::post('/people/{user_id}/archive-posts', [PersonController::class, 'archivePosts'])->name('people.archivePosts');



require __DIR__.'/auth.php';
