<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
