<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;

Route::resource('tags', TagController::class);
Route::resource('blogs', BlogController::class);
// Route untuk menyimpan komentar
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

// --- 1. JALUR PUBLIK (Boleh diakses siapa saja) ---
Route::get('/', function () {
    return redirect('/blogs');
});

// Login & Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Blog: Index & Show (Baca doang boleh umum)
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');

// Jalur untuk melihat blog berdasarkan Tag
Route::get('/kategori/{id}', [BlogController::class, 'filterByTag'])->name('blogs.byTag');

Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');


// Komentar (Umum boleh komen)
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');


// --- 2. JALUR ADMIN (Harus Login) ---
// Kita bungkus dalam grup 'middleware' => 'auth'
Route::middleware('auth')->group(function () {

    // Blog: Create, Store, Edit, Update, Destroy
    // (except index & show karena sudah didefinisikan di atas)
    Route::resource('blogs', BlogController::class)->except(['index', 'show']);

    // Tag: Semua fitur tag hanya untuk admin
    Route::resource('tags', TagController::class);

    // Tambah ini:
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
