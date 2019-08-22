<?php
require_once  dirname(__DIR__ ). '/vendor/autoload.php';
use RabbitMqRPC\App\AppRpc;
use RabbitMqRPC\App\AppServer;
require_once  'TestController.php';
$config = include_once  "cjh_rpc.php";
$apprpc = new AppRpc($config);
$rpc_driver = $apprpc -> getDriver('first1');
$client =  $rpc_driver->AppClient(2);
var_dump($client->testa()) ;
echo PHP_EOL;
var_dump($client->testb('dadadada')) ;


