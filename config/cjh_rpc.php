<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-19
 * Time: 15:30
 */
return [

      'debug' => env('RABBITMQ_RPC_DEBUG', true),
      'default' => env('RABBITMQ_RPC_CONNECT_DRIVER', 'first'),
      'driver' => [
          'first' => [
              'host' =>  env('RABBITMQ_RPC_HOST', '127.0.0.1'),
              'port' =>  env('RABBITMQ_RPC_PORT', 5672),
              'vhost' => env('RABBITMQ_RPC_VHOST', '/'),
              'username' => env('RABBITMQ_RPC_LOGIN', 'guest'),
              'password' => env('RABBITMQ_RPC_PASSWORD', 'guest'),

              'rpc_driver' => [
                   'default' => env('RABBITMQ_RPC_DRIVER', '1'),

                    'config' => [
                         '1' => [
                             'queue' => 'bbbbbbb',
                             'timeout' => 3,
                             'length'   => 10,
                             'controller' => '',
                             'log_path' => '',

                         ],
                    ],


              ],


          ]
      ],
];
