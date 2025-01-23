<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ElephantIO\Client;
use Illuminate\Support\Facades\Auth;

class ServerController extends Controller
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
