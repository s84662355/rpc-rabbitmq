<?php
require_once  dirname(__DIR__ ). '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitMqRPC\RPCServer;
use RabbitMqRPC\AbstractListener;
use PhpAmqpLib\Wire\AMQPTable;
use RabbitMqRPC\AbstractClient ;
use RabbitMqRPC\App\ServerListener;
use RabbitMqRPC\App\AppServer;
use RabbitMqRPC\AbstractController;



$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$rpc_queue = 'aaaaaaaaaaaa';
$channel->queue_declare($rpc_queue , false, false, false, true);


class AppController extends AbstractController{

    public function test($a)
    {
        return $a.'      '.time();
    }

    public function aaa($a,$b,$c)
    {
        return compact('a','b','c');
    }

    public function bbb($a)
    {
        return compact('a' );
    }

}

$listener = new ServerListener(new AppController ());

$server = new AppServer(  $channel, $rpc_queue, $listener );

echo "startListen";

$server->startListen();


