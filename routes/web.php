<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('chats.index');
});

Route::get('/chat/show', function () {
    return view('chats.show');
});
