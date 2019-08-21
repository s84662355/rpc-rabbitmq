<?php
require_once  dirname(__DIR__ ). '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitMqRPC\RPCServer;
use RabbitMqRPC\AbstractListener;
use RabbitMqRPC\RPCClient;
use RabbitMqRPC\App\AppClient;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$rpc_queue = 'aaaaaaaaaaaa';




$client = new AppClient( $channel, $rpc_queue, [
       'aaa',
       'bbb',
       'ccc',
   ]);

  var_dump($client->bbb(145645645, [21,3432,645645])) ;




