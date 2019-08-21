<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/21
 * Time: 23:54
 */

namespace RabbitMqRPC\App;
use RabbitMqRPC\AbstractController;

abstract class AbstractCjhService
{
    protected static $instance = null;
    protected $connection = false;
    protected $rpc_config = false;

    protected $rpc_driver = null;

    protected function __construct()
    {
        $this->rpc_driver = app( 'cjh_rpc')-> getDriver($this->connection)-> AppClient( $this->rpc_config) ;
    }

    public static function getInstance()
    {
        if(empty(self::$instance))
        {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getRpcDriver()
    {
        return   $this->rpc_driver;
    }

    public static function __callStatic($name, $arguments)
    {
       return call_user_func_array([ self::getInstance()->getRpcDriver() ,$name],$arguments);
    }


}