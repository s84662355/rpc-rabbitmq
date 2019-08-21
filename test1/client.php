<?php
require_once  dirname(__DIR__ ). '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitMqRPC\RPCServer;
use RabbitMqRPC\AbstractListener;
use RabbitMqRPC\RPCClient;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$rpc_queue = 'sdfsdfsd';

///   public function __construct(Channel $channel,string $request_queue,string $connect_name = null) {

 $client = new RPCClient($channel,$rpc_queue);

var_dump($client->call('dadasdads;lgdkslg;dksl;gkdk;gldskl;sdas'.time(),[ 'request_method' => '55vcxvcxvxc5555' ]))  ;

