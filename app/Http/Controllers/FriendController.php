<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ElephantIO\Client;

class FriendController extends Controller
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
    
    public function friends()
    {
        $logged_name = Auth::user()->username;
        $users = User::where('username', '!=', $logged_name)
                ->orderBy('id', 'desc')
                ->get();
        
        return view('chats.friends', ['friends' => $users]);
    }

    public function test()
    {
        $data = ['name' => Auth::user()->name];
        $this->_sendToSocket('get-info', $data);
        echo "Test Socket";
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
