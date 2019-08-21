<?php

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
                             'method' => [
                                    'test1',
                                    'test2',
                             ],
                             'controller' => [
                                 'name' => 'testController',
                                 'args' => [
                                     's68253546345fdsfds',
                                     '23423423423432'
                                 ],
                             ],
                         ],

                        '2' => [
                            'queue' => 'cccc',
                            'method' => [
                                'test1',
                                'test2',
                            ],
                            'controller' => [
                                'name' => 'testController',
                                'args' => [
                                    's68253546345fdsfds',
                                    '23423423423432'
                                ],
                            ],
                        ],



                    ],


               ],


          ]
      ],
];
