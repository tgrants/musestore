<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
*/

Route::middleware('auth', 'admin')->group(function () {
    // Categories
    Route::get('/categories', [UserController::class, 'index'])->name('users.index');
    Route::post('/categories', [UserController::class, 'store'])->name('users.store');
    Route::patch('/categories/{category}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/categories/{category}', [UserController::class, 'destroy'])->name('users.destroy');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::redirect('/', '/login');

require __DIR__.'/auth.php';
