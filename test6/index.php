<?php
$loader  = require_once  dirname(__DIR__ ). '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;
use RabbitMqRPC\App\CjhRpcProvider;
use RabbitMqRPC\App\AppRpc;
use RabbitMqRPC\Annotation\CallMethod;
use Doctrine\Common\Annotations\AnnotationRegistry;
use RabbitMqRPC\App\AbstractMiddleware;
use Predis\Client;


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
                        'length'   => 2,

                    ],
                ],


            ],


        ]
    ],
];


class Test extends  \RabbitMqRPC\App\AbstractController
{
    public function __construct()
    {
        $this->annotation_config = include dirname(__DIR__ ). '/config/annotation_config.php';
        $server = array(
            'host'     => '127.0.0.1',
            'port'     => 6379,
            'database' =>0
        );
        $this->redis = new Client($server);
        $this->redis_key = '1111';
        $this->cleanCache = true;
        parent::__construct();
        echo "dsadsadsa";
    }

    protected function before($name, $arguments , $options = [])
    {

        var_dump(__METHOD__);
        echo PHP_EOL;

    }

    protected function after($name, $arguments ,$options = [], &$results )
    {
        var_dump(__METHOD__);
        echo PHP_EOL;
    }

    /**
     * @CallMethod(handle={"Test2"})
     *
     * */
    public function aaaa($a)
    {
              return "s222222222   $a";
    }

}

class Test3 extends AbstractMiddleware
{
    public function  __construct($name, $arguments, array $options = [])
    {

        echo $name;
        echo PHP_EOL;
        var_dump($arguments);
        echo PHP_EOL;
        var_dump($options);
        echo  PHP_EOL;

    }

    public function before()
    {
        var_dump(__METHOD__);
        echo PHP_EOL;
    }

    public function after(&$results)
    {
        var_dump(__METHOD__);
        echo PHP_EOL;
    }
}



AnnotationRegistry::registerLoader(array($loader, "loadClass"));

$rpc = new AppRpc($config,[
    'Test2' =>  Test3::class
]);




$rpc->getDriver()->AppServer()->startListen();
 

 