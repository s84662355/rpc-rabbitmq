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





 $rabbitmq_rpc = include_once 'rabbitmq_rpc.php' ;

///$rabbitmq_rpc['driver']['first'];

 //var_dump($rabbitmq_rpc['driver']['first']);
 $rpc_driver = new RPCDriver($rabbitmq_rpc['driver']['first']);

var_dump($rpc_driver->AppClient('2')->test1('2322323455646fkl','' ))  ;


 var_dump($rpc_driver->AppClient('2')->test1('25646fkl','dasdsadsd'  ))  ;




