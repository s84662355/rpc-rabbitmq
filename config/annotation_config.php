<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-23
 * Time: 14:36
 */
return [

    'class'    => [
         'rpc_method' => RabbitMqRPC\Annotation\RPCMethod::class,
         'connection' => RabbitMqRPC\Annotation\Connection::class,
         'rpc_config' => RabbitMqRPC\Annotation\RPCConfig::class,
         'options'    => RabbitMqRPC\Annotation\Options::class,
    ],

    'method'   => [
        'call_method' => RabbitMqRPC\Annotation\CallMethod::class,

    ],

    'property' => [

    ],

];