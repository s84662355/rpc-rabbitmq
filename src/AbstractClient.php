<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-20
 * Time: 19:54
 */

namespace RabbitMqRPC;
use PhpAmqpLib\Channel\AbstractChannel as Channel;
use RabbitMqRPC\RPCClient;

abstract class AbstractClient
{
    protected $caLL_method = [];
    protected $channel = null;
    protected $request_queue = null;
    protected $timeout = 5;


    public function __construct(Channel $channel ,string  $request_queue , array $caLL_method)
    {
        $this->caLL_method = array_merge($caLL_method,$this->caLL_method) ;
        $this->caLL_method = array_unique($this->caLL_method);
        $this->channel = $channel;
        $this->request_queue = $request_queue;

       /// var_dump($this->caLL_method);
    }


    public function setChannel(Channel $channel)
    {
        $this->channel = $channel;
    }

    public function setRequestQueue(string $request_queue)
    {
        $this->request_queue = $request_queue;
    }

    public function setListener(  array $caLL_method )
    {
        $this->caLL_method = aarray_merge($caLL_method,$this->caLL_method) ;
        $this->caLL_method = array_unique($this->caLL_method);
    }

    public function __call($name, $arguments)
    {
        if(!$this->filter_method($name))
            throw new RPCNoMethodException(__CLASS__,$name);

        $rpc_client
            =
            new RPCClient($this->channel,$this->request_queue);
        $response
            =
            $rpc_client->call(serialize($arguments),[ 'request_method' => $name ], $this->timeout);

        $response = unserialize($response);
        return $this->make($response);
    }

    /**
     * @param mixed $response
     * @return mixed
     */
    abstract protected function make($response)   ;



    private function filter_method($name)
    {
        return  in_array($name, $this->caLL_method);
    }


}