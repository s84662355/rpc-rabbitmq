<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-19
 * Time: 15:30
 */
return [
      'default' => env('RABBITMQ_DRIVER', 'first'),
      'driver' => [
          'first' => [
              'host' =>  env('RABBITMQ_HOST', '127.0.0.1'),
              'port' =>  env('RABBITMQ_PORT', 5672),
              'vhost' => env('RABBITMQ_VHOST', '/'),
              'username' => env('RABBITMQ_LOGIN', 'guest'),
              'password' => env('RABBITMQ_PASSWORD', 'guest'),

              'rpc_driver' => [
                   'default' => env('RABBITMQ_RPC_DRIVER', '1'),

                    'config' => [
                         '1' => [
                             'queue' => 'bbbbbbb',
                             'timeout' => 3,
                             'controller' => '',

                         ],
                    ],


              ],


          ]
      ],
];
