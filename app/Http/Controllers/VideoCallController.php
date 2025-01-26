<?php

namespace App\Http\Controllers;

use App\Models\VideoCall;
use ElephantIO\Client;
use Illuminate\Http\Request;

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

    public function startCall(Request $request)
    {
        
    }

    public function closeCall(Request $request)
    {
        
    }
    
    public function acceptCall(Request $request)
    {
        
    }
    
    public function rejectCall(Request $request)
    {
        
    }

    private function _sendToSocket($event, $data = [])
    {
        $client = $this->client;
        $client->connect();
        $client->of('/');

        $client->emit($event, $data);
        $client->disconnect();
    }
}
