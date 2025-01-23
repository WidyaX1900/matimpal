<?php

use App\Http\Controllers\FriendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServerController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('chats.index');
    })->middleware(['auth', 'verified'])->name('home');

    Route::get('/chat/show', function () {
        return view('chats.show');
    })->name('chat.show');

    Route::get('/chat/friends', [FriendController::class, 'friends'])->name('chat.friends');
    
    Route::get('/server/test', [ServerController::class, 'test'])->name('server.tes');
    
    Route::get('/server/receive', [ServerController::class, 'receive'])->name('server.receive');
});

require __DIR__.'/auth.php';
