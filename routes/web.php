<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\UniversityCommentController;
use App\Http\Controllers\UniversityController;
use Illuminate\Support\Facades\Route;


// Auth
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LogoutController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('home');

// Properties
Route::prefix('properties')->name('properties.')->group(function () {
    Route::get('/',          [PropertyController::class, 'index'])->name('index');
    Route::get('/{property}',[PropertyController::class, 'show'])->name('show');
});

// Universities
Route::get('/universities', [UniversityController::class, 'index'])->name('universities.index');
Route::get('/universities/{university}', [UniversityController::class, 'show'])->name('universities.show');

// Comments
Route::middleware('auth')->group(function () {
    Route::post('/universities/{university}/comments', [UniversityCommentController::class, 'store'])
        ->name('universities.comments.store');
    Route::post('/comments/{comment}/reply', [UniversityCommentController::class, 'reply'])
        ->name('comments.reply');
});
