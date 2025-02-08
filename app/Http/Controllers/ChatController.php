<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getChatAll(Request $request)
    {       
        $username = Auth::user()->username;
        $friend = $request->friend;
        
        $chats = Chat::where(function($query) use ($username, $friend) {
            $query->where('sender', $username)
                ->where('receiver', $friend);
        })->orWhere(function($query) use ($username, $friend) {
            $query->where('sender', $friend)
            ->where('receiver', $username);
        })->orderBy('date', 'desc')->get();

        $data = [
            'chats' => $chats,
            'me' => $username
        ];
        $response = view('chats.list-chat', $data);
        echo $response;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request)
    {
        $sender = Auth::user()->username;
        $receiver = $request->receiver;
        $message = $request->message;
        
        $sendChat = Chat::create([
            'sender' => $sender,
            'receiver' => $receiver,
            'message' => $message,
            'read' => 0,
            'date' => time()
        ]);
        
        if($sendChat) echo json_encode('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat, $friend)
    {
        $data = [
            'friend' => $friend
        ];
        return view('chats.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChatRequest $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
