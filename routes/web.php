<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tags', TagController::class);
