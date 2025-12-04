<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookBorrowingController;
use App\Http\Controllers\BookCategoryController;
use App\Http\Controllers\DashboardController;

use App\Http\Middleware\AdminMiddleware;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// All authenticated users
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ========== BOOKS ==========
    // List all books (everyone)
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    
    // 👇 CREATE route MUST come BEFORE {book} route
    Route::get('/books/create', [BookController::class, 'create'])
        ->name('books.create')
        ->middleware(AdminMiddleware::class);
    
    // Store new book (admin only)
    Route::post('/books', [BookController::class, 'store'])
        ->name('books.store')
        ->middleware(AdminMiddleware::class);
    
    // 👇 {book} routes come AFTER /create
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])
        ->name('books.edit')
        ->middleware(AdminMiddleware::class);
    
    Route::put('/books/{book}', [BookController::class, 'update'])
        ->name('books.update')
        ->middleware(AdminMiddleware::class);
    
    Route::delete('/books/{book}', [BookController::class, 'destroy'])
        ->name('books.destroy')
        ->middleware(AdminMiddleware::class);

    // ========== BORROWINGS ==========
    Route::get('/borrowings', [BookBorrowingController::class, 'index'])->name('borrowings.index');
    
    // 👇 CREATE route MUST come BEFORE {borrowing} route
    Route::get('/borrowings/create', [BookBorrowingController::class, 'create'])
        ->name('borrowings.create')
        ->middleware(AdminMiddleware::class);
    
    Route::post('/borrowings', [BookBorrowingController::class, 'store'])
        ->name('borrowings.store')
        ->middleware(AdminMiddleware::class);
    
    // 👇 {borrowing} routes come AFTER /create
    Route::get('/borrowings/{borrowing}', [BookBorrowingController::class, 'show'])->name('borrowings.show');
    
    Route::patch('/borrowings/{borrowing}/return', [BookBorrowingController::class, 'returnBook'])
        ->name('borrowings.return')
        ->middleware(AdminMiddleware::class);
    
    Route::delete('/borrowings/{borrowing}', [BookBorrowingController::class, 'destroy'])
        ->name('borrowings.destroy')
        ->middleware(AdminMiddleware::class);

    // ========== CATEGORIES (Admin Only) ==========
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::resource('categories', BookCategoryController::class);
    });

    // ========== DASHBOARD (Admin Only) ==========
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware(AdminMiddleware::class);
});

require __DIR__.'/auth.php';