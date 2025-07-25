<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Protected routes (user must be authenticated)
Route::middleware(['auth', 'verified'])->group(function () {

    // Book List View - Now named as 'books.index'
    Route::get('/books', [BookController::class, 'index'])->name('books.index');

    // Dashboard (optional) - You can keep this as a separate route if needed
    Route::get('/dashboard', [BookController::class, 'index'])->name('dashboard');

    // Book CRUD (except index since it's now defined separately)
    Route::resource('books', BookController::class)->except(['index']);

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Category Management Routes
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // ✅ Added routes for Edit Category
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category.update');

    // Subcategory Management Routes
    Route::post('/category/{id}/subcategory', [SubcategoryController::class, 'store'])->name('subcategory.store');
    Route::delete('/subcategory/{subcategory}', [SubcategoryController::class, 'destroy'])->name('subcategory.destroy');
});

// Breeze Auth Routes
require __DIR__.'/auth.php';
