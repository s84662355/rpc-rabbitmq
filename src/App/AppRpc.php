<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/21
 * Time: 23:00
 */

namespace RabbitMqRPC\App;

class AppRpc
{
    private $rpc_driver_pool = [];
    private $config = [];

    public function __construct($config)
    {
         $this->config = $config;
    }

    private function getDriverConfig($driver_config = false) : array
    {
        if(!$driver_config)
        {
            $driver_config = $this->config['default'];
        }

        return  $this->config['driver'][$driver_config ];
    }

    public function getDriver($driver = false) : RPCDriver
    {
        if(!$driver){
            $driver = $this->config['default'];
        }
        if(empty($this->rpc_driver_pool[$driver]))
        {
            $driver_config = $this->getDriverConfig($driver);
            $this->rpc_driver_pool[$driver] = new RPCDriver($driver_config);
        }
        return  $this->rpc_driver_pool[$driver] ;
    }

}