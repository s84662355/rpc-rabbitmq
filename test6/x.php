<?php
$loader  = require_once  dirname(__DIR__ ). '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;
use RabbitMqRPC\App\CjhRpcProvider;
use RabbitMqRPC\App\AppRpc;
use RabbitMqRPC\Annotation\CallMethod;
use Doctrine\Common\Annotations\AnnotationRegistry;
use RabbitMqRPC\App\AbstractService;

use RabbitMqRPC\Annotation\RPCMethod;
use RabbitMqRPC\Annotation\Connection;
use RabbitMqRPC\Annotation\RPCConfig;
use RabbitMqRPC\Annotation\Options;

$config =  [
    'default' =>  'first',
    'driver' => [
        'first' => [
            'host' =>   '127.0.0.1',
            'port' =>  5672,
            'vhost' =>  '/',
            'username' =>'guest',
            'password' =>  'guest',
            'rpc_driver' => [
                'default' =>  '1',

                'config' => [
                    '1' => [
                        'queue' => 'bbbbbbb',
                        'timeout' => 3,
                        'controller' => 'Test',

                    ],
                ],


            ],


        ]
    ],
];


AnnotationRegistry::registerLoader(array($loader, "loadClass"));

$rpc = new AppRpc($config);

/**
 * @RPCMethod(method={"aaaa"})
 *
 * */
class Test1   extends AbstractService
{
    public function __construct(AppRpc $cjh_rpc)
    {
        parent::__construct($cjh_rpc);
    }

}


$test = new  Test1($rpc);

$test->setOptions(['ddsa'=>'315645']);

echo $test->aaaa("dsadsad");



$test->setOptions(['d43432dsa'=>'3511111111111115']);

echo $test->aaaa("d1 11111d");

//$rpc->getDriver()->AppServer()->startListen();
 

 