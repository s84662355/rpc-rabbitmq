<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-20
 * Time: 16:30
 */

namespace RabbitMqRPC;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPConnectionClosedException;
use PhpAmqpLib\Channel\AbstractChannel as Channel;
use PhpAmqpLib\Wire\AMQPTable;
abstract  class AbstractServer {
    protected $channel;
    protected $callback;
    protected $request_queue;

    public function __construct(Channel $channel,string $request_queue,  AbstractServerListener $callback )
    {
        $this->channel = $channel;
        $this->request_queue = $request_queue;
        $this->callback  = $callback ;
    }

    public function setChannel(Channel $channel)
    {
        $this->channel = $channel;
    }

    public function setRequestQueue(string $request_queue)
    {
        $this->request_queue = $request_queue;
    }

    public function setListener( AbstractServerListener $callback )
    {
        $this->callback  = $callback ;
    }

    public function  startListen($consumer_tag = false)
    {
          $server = new RPCServer($this->channel,$this->request_queue, $this->callback);
          $server->ready($consumer_tag  );
          $server->startListen();
    }



};
