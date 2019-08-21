<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-20
 * Time: 13:48
 */
namespace RabbitMqRPC\App;
use PhpAmqpLib\Channel\AbstractChannel as Channel;
use RabbitMqRPC\AbstractServer;
use RabbitMqRPC\AbstractServerListener;

class AppServer  extends  AbstractServer
{

    public function __construct(Channel $channel, string $request_queue, AbstractServerListener $callback)
    {
        parent::__construct($channel, $request_queue, $callback);
    }


}