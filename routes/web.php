<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Resource routes for Library Management
Route::resource('authors', \App\Http\Controllers\AuthorController::class);
Route::resource('categories', \App\Http\Controllers\CategoryController::class);
Route::resource('books', \App\Http\Controllers\BookController::class);
Route::resource('members', \App\Http\Controllers\MemberController::class);
Route::resource('borrow-records', \App\Http\Controllers\BorrowRecordController::class);

// Custom route for returning books
Route::post('borrow-records/{borrowRecord}/return', [\App\Http\Controllers\BorrowRecordController::class, 'returnBook'])
    ->name('borrow-records.return');
