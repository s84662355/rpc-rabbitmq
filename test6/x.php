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
use Predis\Client;



///var_dump(unserialize("a:1:{i:0;O:32:"RabbitMqRPC\Annotation\RPCMethod":1:{s:6:"method";a:1:{i:0;s:4:"aaaa";}}}"))  ;

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
        $this->annotation_config = include dirname(__DIR__ ). '/config/annotation_config.php';
        $server = array(
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'database' =>0
        );
        $this->redis = new Client($server);



        $this->redis_key = '1111';



        parent::__construct($cjh_rpc);
    }

}


$test = new  Test1($rpc);

$test->setOptions(['ddsa'=>'315645']);

echo $test->aaaa("ddgdfgdfgdfgdfd");



$test->setOptions(['d43432dsa'=>'3 1111115']);

echo $test->aaaa(" 1d");

//$rpc->getDriver()->AppServer()->startListen();
 

 