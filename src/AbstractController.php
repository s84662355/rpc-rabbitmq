<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-20
 * Time: 16:38
 */

namespace RabbitMqRPC;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPConnectionClosedException;
use PhpAmqpLib\Channel\AbstractChannel as Channel;
use PhpAmqpLib\Wire\AMQPTable;
abstract class AbstractController
{
    public function __call($name, $arguments)
    {
        throw new RPCNoMethodException(__CLASS__, $name);
    }


    abstract public function before($name, $arguments);


    abstract public function after($name, $arguments);


};
