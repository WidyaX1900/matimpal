<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('chats.index');
    })->middleware(['auth', 'verified'])->name('home');

    Route::get('/chat/show', function () {
        return view('chats.show');
    })->name('chat.show');

    Route::get('/chat/friends', function () {
        return view('chats.friends');
    })->name('chat.friends');
});

require __DIR__.'/auth.php';
