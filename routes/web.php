<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrimaryController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\AdminBukuController;

// Route for root URL
Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/beranda', [PrimaryController::class, 'index'])->name('home');

// Show book details
Route::get('/book/{bukuid}', [BookController::class, 'show'])->name('book.show');

// Borrow book
Route::post('/book/{bukuid}/borrow', [BookController::class, 'borrow'])->name('book.borrow');

// Return book
Route::post('/book/{bukuid}/return', [BookController::class, 'return'])->name('book.return');
 
// Store a comment (Ulasan)
Route::post('/book/{bukuid}/ulasan', [BookController::class, 'storeUlasan'])->name('book.storeUlasan');

// Update a comment (Ulasan)
Route::put('/book/{bukuid}/ulasan/{ulasanid}', [BookController::class, 'updateUlasan'])->name('book.updateUlasan');

// Delete a comment (Ulasan)
Route::delete('/book/{bukuid}/ulasan/{ulasanid}', [BookController::class, 'deleteUlasan'])->name('book.deleteUlasan');

Route::post('/book/{bukuid}/addToKoleksi', [BookController::class, 'addToKoleksi'])->name('book.addToKoleksi');

// routes/web.php
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/tentangkami', function () {
    return view('aboutus');
});

Route::get('/peminjaman', [BorrowController::class, 'showPeminjaman']);

Route::get('/profil', [UserController::class, 'showProfile']);
Route::delete('/koleksi/{koleksiid}/delete', [UserController::class, 'deleteFromCollection'])->name('koleksi.delete');

// routes/web.php
Route::get('/check-overdue', [UserController::class, 'checkOverdue'])->name('check.overdue');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
 