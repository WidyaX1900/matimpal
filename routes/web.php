<?php

use App\Http\Controllers\FriendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('chats.index');
    })->middleware(['auth', 'verified'])->name('home');

    Route::get('/chat/show', function () {
        return view('chats.show');
    })->name('chat.show');

    Route::get('/chat/friends', [FriendController::class, 'friends'])->name('chat.friends');
    
    Route::get('/chat/test', [FriendController::class, 'test'])->name('chat.test');
});

require __DIR__.'/auth.php';
