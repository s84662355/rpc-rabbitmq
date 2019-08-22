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
	public function __construct()
	{

	}

    abstract public function before($name, $arguments , $options = []);

    abstract public function after($name, $arguments, &$results ,$options = []);

    public function callMethod($name, $arguments , $options = [])
    {
            $this->before($name, $arguments , $options = []);
            $results = call_user_func_array([$this ,$name],$arguments);
            $this->after($name, $arguments , &$results ,$options = []);      
            return  $results;
    } 

    public function __call($name, $arguments)
    {
        throw new RPCNoMethodException(__CLASS__, $name);
    }
};
