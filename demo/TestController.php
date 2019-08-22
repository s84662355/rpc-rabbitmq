<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-22
 * Time: 11:53
 */
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitMqRPC\RPCServer;
use RabbitMqRPC\AbstractListener;
use PhpAmqpLib\Wire\AMQPTable;
use RabbitMqRPC\AbstractClient ;
use RabbitMqRPC\App\ServerListener;
use RabbitMqRPC\App\AppServer;
use RabbitMqRPC\App\AbstractCjhController;
use RabbitMqRPC\App\RPCDriver;


class TestController extends AbstractCjhController
{

     public function __construct($a)
     {
         echo "start ".__CLASS__;
         echo $a;
     }

     public function testa()
     {
         return __METHOD__;
     }

     public function testb($a)
     {
        return __METHOD__.'  '.$a;
     }

     public function testc($a,$b)
     {
        return __METHOD__.'  '.serialize(compact('a','b'));
     }

     public function before($name, $arguments)
     {

     }


     public function after($name, $arguments)
     {

     }

}