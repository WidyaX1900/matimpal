<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VideoCall;
use ElephantIO\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoCallController extends Controller
{
    protected $nodejs_url;
    protected $options;
    protected $client;

    public function __construct()
    {
        $this->nodejs_url = 'http://127.0.0.1:3000/';
        // $this->options = ['client' => Client::CLIENT_4X];
        $this->client = Client::create($this->nodejs_url);
    }

    public function index()
    {
        $logged_name = Auth::user()->username;
        $users = User::where('username', '!=', $logged_name)
            ->orderBy('id', 'desc')
            ->get();

        return view('videocall.index', ['friends' => $users]);
    }

    public function startCall(Request $request)
    {
        $caller = User::where('name', $request->caller)->first();
        $receiver = User::where('name', $request->receiver)->first();
        $room = uniqid();
        $vicall = $this->_startCall($caller, $receiver, $room);

        if($vicall) echo json_encode('success');
    }

    public function missCall(Request $request)
    {
        $user = Auth::user()->username;
        $vicall = VideoCall::where('main_user', $user)
            ->where('status', 'calling')
            ->orderBy('id', 'desc')
            ->first();
        $missed = VideoCall::where('room', $vicall->room)
            ->update(['status' => 'missed call']);

        if ($missed) echo json_encode('success');
    }
    
    public function acceptCall(Request $request)
    {
        $user = Auth::user()->username;
        $vicall = VideoCall::where('main_user', $user)
        ->where('status', 'calling')
            ->orderBy('id', 'desc')
            ->first();
        $accept = VideoCall::where('room', $vicall->room)
                ->update(['status' => 'oncall']);

        if($accept) echo json_encode('success');
    }           

    
    public function rejectCall(Request $request)
    {
        $user = Auth::user()->username;
        $vicall = VideoCall::where('main_user', $user)
            ->where('status', 'calling')
            ->orderBy('id', 'desc')
            ->first();
        $reject = VideoCall::where('room', $vicall->room)
            ->update(['status' => 'rejected']);

        if ($reject) echo json_encode('success');
    }
    
    public function onCall(Request $request)
    {   
        $user = Auth::user()->username;
        $vicall = VideoCall::where('main_user', $user)
                ->where('status', 'oncall')
                ->orderBy('id', 'desc')
                ->first();
        
        $friend = VideoCall::where('main_user', $vicall->secondary_user)
                ->where('status', 'oncall')
                ->where('room', $vicall->room)
                ->first();
        return view('videocall.room', ['vicall' => $vicall, 'friend' => $friend]);
    }
    
    public function updatePeerId(Request $request)
    {
        $user = Auth::user()->username;
        $updatePeer = VideoCall::where('main_user', $user)
                -> where('room', $request->room)
                ->update(['peer_id' => $request->peer_id]);
        
        if($updatePeer) echo json_encode('success');
    }
    
    public function endCall(Request $request)
    {
        $room = $request->room;
        $endCall = VideoCall::where('room', $room)
                -> update([
                    'status' => 'ended',
                    'peer_id' => '',
                    'date_end' => time()
                ]);
        
        $this->_sendToSocket('end-videocall', ['room' => $room]);
        if($endCall) echo json_encode('success');
    }
    
    public function redialCall(Request $request)
    {
        $main_user = Auth::user()->username;
        $secondary_user = User::where('name', $request->receiver)->first();
        $vicall = VideoCall::where('main_user', $main_user)
                ->where('secondary_user', $secondary_user->username)
                ->orderBy('id', 'desc')
                ->first();
        if($vicall) {
            $newCount = $vicall->count + 1;
            $updateCount = VideoCall::where('room', $vicall->room)
                        ->where(function ($query) {
                            $query->where('status', 'missed call')
                                ->orWhere('status', 'rejected');
                        })->update([
                            'count' => $newCount,
                            'status' => 'calling'
                        ]);
            
            if($updateCount) echo json_encode('success');
        }
    }
    
    public function toggleMedia(Request $request)
    {
        $main_user = Auth::user()->username;
        $media = $request->media;
        $toggle = $request->toggle;
        
        if($media === 'audio') {
            $update = ['audio' => $toggle];
        } else {
            $update = ['camera' => $toggle];
        }

        $changeMedia = VideoCall::where('main_user', $main_user)
                ->where('room', $request->room)
                ->update($update);
        echo json_encode('success');
    }

    private function _sendToSocket($event, $data = [])
    {
        $client = $this->client;
        $client->connect();
        $client->of('/');

        $client->emit($event, $data);
        $client->disconnect();
    }

    private function _startCall($caller, $receiver, $room)
    {
        $main = VideoCall::create([
            'main_user' => $caller->username,
            'main_role' => 'caller',
            'secondary_user' => $receiver->username,
            'secondary_role' => 'receiver',
            'room' => $room,
            'status' => 'calling',
            'peer_id' => '',
            'camera' => 'true',
            'audio' => 'true',
            'direction' => 'outgoing',
            'count' => 0,
            'date_start' => time(),
            'date_end' => 0,
        ]);

        $secondary = VideoCall::create([
            'main_user' => $receiver->username,
            'main_role' => 'receiver',
            'secondary_user' => $caller->username,
            'secondary_role' => 'caller',
            'room' => $room,
            'status' => 'calling',
            'peer_id' => '',
            'camera' => 'true',
            'audio' => 'true',
            'direction' => 'incoming',
            'count' => 0,
            'date_start' => time(),
            'date_end' => 0,
        ]);

        return $main && $secondary;
    }
}
