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

    protected $rpc_cli = null;

    protected $caLL_method = [];

    protected $options = []; 

    protected function __construct()
    {
        $this->rpc_cli = app( 'cjh_rpc')-> getDriver($this->connection)-> AppClient( $this->rpc_config) ;

        $this->rpc_cli->setCallMethod(  $this->caLL_method );
    }

    public static function getInstance()
    {
        if(empty(self::$instance))
        {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getRpcCli()
    {
        return   $this->rpc_cli;
    }

    public function setOptions($options = [])
    {
        $this->options = $options;
    }

    public static function __callStatic($name, $arguments)
    {
       self::getInstance()->getRpcCli()->setOptions($this->options);
       return call_user_func_array([ self::getInstance()->getRpcCli() ,$name],$arguments);
    }
}