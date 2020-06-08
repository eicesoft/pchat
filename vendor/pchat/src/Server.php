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

    private $name = "PHPChat";

    private $config;

    public function __construct($config)
    {
        $this->config = $config;
        echo 'Start php chat server';
        $this->server = new \Swoole\Server($config['server']['host'], $config['server']['port'],
            SWOOLE_PROCESS, SWOOLE_SOCK_TCP);
        $this->server->set($config['server']['params']);
        $this->registry();

        $this->server->on('connect', function ($server, $fd){
            echo "Client:Connect.\n";
        });
        $this->server->on('receive', function ($server, $fd, $reactor_id, $data) {
            $server->send($fd, 'Swoole: '.$data);
            $server->close($fd);
        });
        $this->server->start();
    }

    public function registry()
    {
        $this->server->on('Start', [$this, 'onStart']);
        $this->server->on('ManagerStart', [$this, 'onManagerStart']);
        $this->server->on('WorkerStart', [$this, 'onWorkerStart']);
        $this->server->on('WorkerStop', [$this, 'onWorkerStop']);
        $this->server->on('WorkerError', [$this, 'onWorkerError']);
        $this->server->on('Shutdown', [$this, 'onShutdown']);
    }
    /**
     * service start event
     * @param \swoole_server $serv
     */
    public function onStart($serv) {
        swoole_set_process_name("{$this->name} master");
    }

    /**
     * manager process start
     * @param \swoole_server $serv
     */
    public function onManagerStart($serv) {
        swoole_set_process_name("{$this->name}  manager");
    }

    /**
     * worker process start event
     * @param \swoole_server $serv
     * @param int $worker_id
     */
    public function onWorkerStart($serv, $worker_id) {
        $pid = posix_getpid();

        if ($worker_id >= $serv->setting['worker_num']) {
            swoole_set_process_name("{$this->name}  task_{$worker_id}");
        } else {
            swoole_set_process_name("{$this->name}  worker_{$worker_id}");
        }
    }

    /**
     * worker process stop event
     * @param \swoole_server $serv
     * @param int $worker_id
     */
    public function onWorkerStop($serv, $worker_id) {
        echo vsprintf("% service worker %s stop.\n", [$this->name, $worker_id]);
    }

    /**
     * worker process error event
     * @param \swoole_server $serv
     * @param int $worker_id
     * @param int $worker_pid
     * @param int $exit_code
     * @param int $signal
     */
    public function onWorkerError($serv, $worker_id, $worker_pid, $exit_code, $signal) {
        echo vsprintf("%s worker_%s - (%s, %s)\n", [$this->name, $worker_pid, $exit_code, $signal]);
    }

    /**
     * service shutdown event
     * @param $serv
     */
    public function onShutdown($serv) {
        echo vsprintf("%s service will shutdown...\n", [$this->name]);
    }
}