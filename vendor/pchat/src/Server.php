<?php
namespace PHPChat;

/*
 *  open_length_check: true
    package_max_length: 102410
    package_length_type: N
    package_length_offset: 8
    package_body_offset: 16
 */

/**
 * PHP Chat PHPChat
 * @author kelezyb
 */
class Server
{
    /**
     * @var \Swoole\Server
     */
    private $server;

    public function __construct($host, $port)
    {
        echo 'Start php chat server';
        $this->server = new \Swoole\Server($host, $port, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);
        $this->server->on('connect', function ($server, $fd){
            echo "Client:Connect.\n";
        });
        $this->server->on('receive', function ($server, $fd, $reactor_id, $data) {
            $server->send($fd, 'Swoole: '.$data);
            $server->close($fd);
        });
        $this->server->start();
    }
}