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

    //'debug' => env('RABBITMQ_RPC_DEBUG', true),
    //'redis_key' => env('RABBITMQ_RPC_REDIS_KEY', 'RABBITMQ_RPC_REDIS_KEY'),



    'debug' => true,
    'redis_key' =>   'RABBITMQ_RPC_REDIS_KEY' ,

];