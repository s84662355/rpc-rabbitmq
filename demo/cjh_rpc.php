<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-19
 * Time: 15:30
 */

return [
    'default' => 'first' ,
    'driver' => [
        'first' => [
            'host' =>    '127.0.0.1' ,
            'port' =>    5672 ,
            'vhost' =>   '/' ,
            'username' =>   'guest' ,
            'password' =>   'guest' ,
            'rpc_driver' => [
                'default' =>  '1',
                'config' => [
                    '1' => [
                        'queue' => 'bbbbbbb',
                        'timeout' => 3,
                        'controller' => [
                            'name' => 'TestController',
                            'args' => [
                                's68253546345fdsfds',
                                '23423423423432'
                            ],
                        ],
                    ],
                    '2' => [
                        'queue' => 'dadasdadab',
                        'timeout' => 3,
                        'caLL_method' => [
                            'testa',
                            'testb',
                        ],
                        'controller' => [
                            'name' => 'TestController',
                            'args' => [
                                's68ds',
                                '2323432'
                            ],
                        ],
                    ],
                ],
            ],
        ],

        'first1' => [
            'host' =>    '127.0.0.1' ,
            'port' =>    5672,
            'vhost' =>   '/' ,
            'username' =>   'guest' ,
            'password' =>   'guest' ,
            'rpc_driver' => [
                'default' =>  '1',
                'config' => [
                    '1' => [
                        'queue' => 'bbbbbbb',
                        'timeout' => 3,
                        'controller' => [
                            'name' => 'TestController',
                            'args' => [
                                's68253546345fdsfds',
                                '23423423423432'
                            ],
                        ],
                    ],
                    '2' => [
                        'queue' => 'dadsgvdfgdfab',
                        'timeout' => 3,
                        'caLL_method' => [
                            'testa',
                            'testb',
                        ],
                        'controller' => [
                            'name' => 'TestController',
                            'args' => [
                                's68ds',
                                '2323432'
                            ],
                        ],
                    ],
                ],
            ],
        ],




    ],
];
