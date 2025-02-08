<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $username = Auth::user()->username;
        
        $subquery = Chat::selectRaw('id,
        CASE
            WHEN sender = ? THEN receiver
            WHEN receiver = ? THEN sender
        END AS lawan_chat, message, date', [$username, $username])
        ->where(function($query) use ($username){
            $query->where('sender', $username)
                ->orWhere('receiver', $username);
        });

        $grouped = Chat::fromSub($subquery, 't1')
            ->selectRaw('lawan_chat, MAX(id) as max_id')
            ->groupBy('lawan_chat');

        $chats = Chat::joinSub($grouped, 'tt1', function($join) {
            $join->on('chats.id', '=', 'tt1.max_id');
        })
        ->join('users as tt2', 'tt2.username', '=', 'tt1.lawan_chat')
        ->select('tt1.lawan_chat', 'tt1.max_id', 'tt2.name', 'chats.*')
        ->orderByDesc('chats.id')
        ->get();

        $data = [
            'chats' => $chats
        ];
        return view('chats.index', $data);
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
        
        if($sendChat) echo json_encode([
            'send_from' => $sender,
            'send_to' => $receiver
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat, $friend)
    {
        $friend_user = User::firstWhere('username', $friend);
        $data = [
            'friend' => $friend_user
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

    public function getChatAll(Request $request)
    {
        $username = Auth::user()->username;
        $friend = $request->friend;

        $chats = Chat::where(function ($query) use ($username, $friend) {
            $query->where('sender', $username)
                ->where('receiver', $friend);
        })->orWhere(function ($query) use ($username, $friend) {
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
}
