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
use RabbitMqRPC\App\RPCDriver;




class testController extends  AbstractController{

    public function __construct($a,$b)
    {
        var_dump(compact('a','b'));
    }

    public function test1($a,$b)
    {

        echo $a;
        echo "<br>";
        return compact('a');
    }


}



 $rabbitmq_rpc = include_once 'rabbitmq_rpc.php' ;

///$rabbitmq_rpc['driver']['first'];

 //var_dump($rabbitmq_rpc['driver']['first']);
 $rpc_driver = new RPCDriver($rabbitmq_rpc['driver']['first']);

$rpc_driver->AppServer('2')-> startListen( );
