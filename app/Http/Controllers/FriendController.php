<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function friends()
    {
        $logged_name = Auth::user()->username;
        $users = User::where('username', '!=', $logged_name)
                ->orderBy('id', 'desc')
                ->get();
        
        return view('chats.friends', ['friends' => $users]);
    }
}
