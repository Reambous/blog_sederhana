<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tags', TagController::class);
Route::resource('blogs', BlogController::class);
// Route untuk menyimpan komentar
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
