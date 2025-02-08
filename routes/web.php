<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\VideoCallController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('chats.index');
    })->middleware(['auth', 'verified'])->name('home');

    Route::get('/chat/show/{friend}', [ChatController::class, 'show'])->name('chat.show');
    
    Route::post('/chat/store', [ChatController::class, 'store'])->name('chat.store');

    Route::get('/friend', [FriendController::class, 'index'])->name('friend.index');
    
    Route::get('/server/test', [ServerController::class, 'test'])->name('server.tes');
    
    Route::get('/server/receive', [ServerController::class, 'receive'])->name('server.receive');
    
    Route::get('/videocall', [VideoCallController::class, 'index'])->name('videocall.index');

    Route::post('/videocall/startcall', [VideoCallController::class, 'startCall'])->name('videocall.startcall');
    
    Route::post('/videocall/closecall', [VideoCallController::class, 'closeCall'])->name('videocall.closecall');
    
    Route::post('/videocall/acceptcall', [VideoCallController::class, 'acceptCall'])->name('videocall.acceptcall');
    
    Route::post('/videocall/rejectcall', [VideoCallController::class, 'rejectCall'])->name('videocall.rejectcall');
    
    Route::get('/videocall/oncall', [VideoCallController::class, 'onCall'])->name('videocall.oncall');

    Route::post('/videocall/updatepeer', [VideoCallController::class, 'updatePeerId'])->name('videocall.updatepeer');
    
    Route::post('/videocall/endcall', [VideoCallController::class, 'endCall'])->name('videocall.endcall');

    Route::post('/videocall/rejectcall', [VideoCallController::class, 'rejectCall'])->name('videocall.rejectcall');
    
    Route::post('/videocall/misscall', [VideoCallController::class, 'missCall'])->name('videocall.misscall');
    
    Route::post('/videocall/redialcall', [VideoCallController::class, 'redialCall'])->name('videocall.redialcall');
    
    Route::post('/videocall/togglemedia', [VideoCallController::class, 'toggleMedia'])->name('videocall.togglemedia');

    Route::get('/videocall/newcall', [VideoCallController::class, 'newCall'])->name('videocall.newcall');
});

require __DIR__.'/auth.php';
