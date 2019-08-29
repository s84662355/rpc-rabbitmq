<?php
require_once  dirname(__DIR__ ). '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

 //queue_purge
 


$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest' ,'/');
$channel = $connection->channel();

$channel->basic_qos(null, 1, null);
$arguments = new AMQPTable();
$arguments->set('x-max-length',intval(2));


$channel ->queue_declare(
               'hello' ,
                false,
                false,
                false,
                true,
                false,
                $arguments
                );



$callback = function($msg) {
  echo " [x] Received ", $msg->body, "\n";
};
 
$channel->basic_consume('hello', 'asdasdasdsa', false, true, false, false, $callback);

while(count($channel->callbacks)) {
    $channel->wait();
}