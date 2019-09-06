<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-20
 * Time: 14:30
 */
namespace RabbitMqRPC\App;
use RabbitMqRPC\RPCControllerException;
use \ReflectionClass;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use RabbitMqRPC\RPCServer;
use RabbitMqRPC\AbstractListener;
use PhpAmqpLib\Wire\AMQPTable;
use RabbitMqRPC\AbstractClient ;
use RabbitMqRPC\App\ServerListener;
use RabbitMqRPC\App\AppServer;
use RabbitMqRPC\AbstractController;

class RPCDriver
{
    private $connection = null;
    private $config = [];
    private $channel = null;
    private $rpcDriverConfig = [];
    private $defaultRpcDriverConfig = '';
    private $appClients = [];
    private $handle = [];

    public function __construct( $config )
    {
        $this->config = $config;
        $this->connection = new AMQPStreamConnection($config['host'],$config['port'], $config['username'], $config['password'],$config['vhost']);
        $this->channel = $this->connection->channel();

        $this->rpcDriverConfig = $config['rpc_driver']['config'];
        $this->defaultRpcDriverConfig = $config['rpc_driver']['default'];
    }

    public function setHandle($handle)
    {
         $this->handle = $handle;
    }

    private function getRpcDriverConfig($rpcDriver = false)
    {
        if(!$rpcDriver)
            $rpcDriver = $this->defaultRpcDriverConfig;
        return $this->rpcDriverConfig[$rpcDriver];
    }

    public function  AppClient($rpcDriver = false) : AppClient
    {
        if(empty($this->appClients[$rpcDriver]))
        {
            $config = $this->getRpcDriverConfig($rpcDriver);
            $this->appClients[$rpcDriver] = new AppClient($this->channel,$config['queue']);

            if( !empty($config['caLL_method']) && is_array($config['caLL_method']))
            {
                $this->appClients[$rpcDriver]-> setCallMethod(  $config['caLL_method'] );
            }

            if(!empty($config['timeout']))
            {
                $this->appClients[$rpcDriver]->setTimeOut($config['timeout']);
            }
        }
        return $this->appClients[$rpcDriver];
    }


    public function AppServer($rpcDriver = false) : AppServer
    {
        $config = $this->getRpcDriverConfig($rpcDriver);

        $arguments = new AMQPTable();

        if (!empty($config['length'])) {
            $arguments->set('x-max-length', intval($config['length']));
        }


        ///x-message-ttl
        if (!empty($config['ttl']))
        {
            $arguments->set('x-message-ttl', intval($config['ttl']));
        }
 
        $this
            ->channel
            ->queue_declare(
                $config['queue'] ,
                false,
                false,
                false,
                true,
                false,
                $arguments
                );


        $listener = new ServerListener( $this->getController($config['controller']));

        if(!empty($config['log_path'])){
            $listener->setLogPath($config['log_path']);
        }

        $server = new AppServer( $this->channel,$config['queue'], $listener );

        return $server;
    }

    private function getController(string $AppController)
    {
        if(empty($AppController))
        {
            throw  new RPCControllerException(' Controller config 不能为空');
        }

        if(!class_exists($AppController))
        {
            throw  new RPCControllerException(" $AppController 没有定义 ");
        }

        $controller_instance = new $AppController() ;
        $controller_instance-> setHandle($this->handle);
        return $controller_instance;
    }


    public function refurbish()
    {
        try{
            $this->connection->reconnect();
            $this->channel = $this->connection->channel();
        }catch (\Exception $exception){}
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

}
