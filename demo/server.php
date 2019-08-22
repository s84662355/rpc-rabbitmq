<?php
require_once  dirname(__DIR__ ). '/vendor/autoload.php';
use RabbitMqRPC\App\AppRpc;
use RabbitMqRPC\App\AppServer;


require_once  'TestController.php';

$config = include_once  "cjh_rpc.php";

$apprpc = new AppRpc($config);

$rpc_driver = $apprpc -> getDriver('first1');

 $server =  $rpc_driver->AppServer('2');

$server->startListen();