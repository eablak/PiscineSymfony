<?php

namespace App\WebSocket;

use Workerman\Worker;

class WebSocketServer
{
    private Worker $worker;

    public function __construct()
    {
        $this->worker = new Worker('websocket://0.0.0.0:8080');
        
        $this->worker->onConnect = function ($connection) {
            echo "New connection\n";
        };
        
        $this->worker->onMessage = function ($connection, $data) {
            foreach ($this->worker->connections as $client) {
                $client->send($data);
            }
        };
        
        $this->worker->onClose = function ($connection) {
            echo "Connection closed\n";
        };
    }
     
    public function run(): void
    {
        Worker::runAll();
    }
}
