<?php

use App\Http\Controllers\FriendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\VideoCallController;
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
    
    Route::post('/videocall/startcall', [VideoCallController::class, 'startCall'])->name('videocall.startcall');
    
    Route::post('/videocall/closecall', [VideoCallController::class, 'closeCall'])->name('videocall.closecall');
    
    Route::post('/videocall/acceptcall', [VideoCallController::class, 'acceptCall'])->name('videocall.acceptcall');
    
    Route::post('/videocall/rejectcall', [VideoCallController::class, 'rejectCall'])->name('videocall.rejectcall');
    
    Route::get('/videocall/oncall', [VideoCallController::class, 'onCall'])->name('videocall.oncall');

    Route::post('/videocall/updatepeer', [VideoCallController::class, 'updatePeerId'])->name('videocall.updatepeer');
    
    Route::post('/videocall/endcall', [VideoCallController::class, 'endCall'])->name('videocall.endcall');
});

require __DIR__.'/auth.php';
