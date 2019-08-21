<?php
require_once  dirname(__DIR__ ). '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitMqRPC\RPCServer;
use RabbitMqRPC\AbstractListener;
use PhpAmqpLib\Wire\AMQPTable;
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$rpc_queue = 'sdfsdfsd';
$channel->queue_declare($rpc_queue , false, false, false, true);


class listener extends AbstractListener{

    public function handle( array $table , string $body , string $correlation_id): string
    {
       echo  $table['request_method'];

       return $body;
    }
}


$server = new RPCServer($channel,$rpc_queue , new listener());

$server->ready('aksljdklasjdlaks');


///echo date('Y-m-d h:i:s');
//echo 'startListen';

$server->startListen();