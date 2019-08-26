<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/21
 * Time: 23:54
 */

namespace RabbitMqRPC\App;
use RabbitMqRPC\AbstractController;
use RabbitMqRPC\Annotation\AnnotationTrait;
use ReflectionClass;
abstract class AbstractCjhService
{
    use AnnotationTrait;

    protected static $instance = null;
    
    protected $connection = false;
    
    protected $rpc_config = false;

    protected $rpc_cli = null;

    protected $caLL_method = [];

    protected $options = []; 

    protected function __construct()
    {
        $this->iniVariable();

        $this->rpc_cli = app( 'cjh_rpc')-> getDriver($this->connection)-> AppClient( $this->rpc_config) ;



        $this->rpc_cli->setCallMethod(  $this->caLL_method );

        $this->initAnnotationParase();
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

    public function getOptions( )
    {
        return $this->options  ;
    }

    public function callMethod($name, $arguments)
    {
        $this->getRpcCli()->setOptions($this->getOptions());
        call_user_func_array([ $this->getRpcCli() ,$name],$arguments);
    }

    protected function iniVariable()
    {
        $this->initAnnotationParase();


        if(!empty($this->class_parase['parase']['rpc_method']))
        {
            $rpc_method = $this->class_parase['parase']['rpc_method'];
            $this->caLL_method = $rpc_method-> method;
        }


        if(!empty($this->class_parase['parase']['connection']))
        {
            $connection = $this->class_parase['parase']['connection'];
            $this->connection = $connection->name;
        }


        if(!empty($this->class_parase['parase']['rpc_config']))
        {
            $rpc_config = $this->class_parase['parase']['rpc_config'];
            $this->rpc_config = $connection->rpc_config;
        }

        if(!empty($this->class_parase['parase']['options']))
        {
            $options = $this->class_parase['parase']['options'];
            $this->options  = $options;
        }






    }


    public static function __callStatic($name, $arguments)
    {
       return call_user_func_array([ self::getInstance() , 'callMethod'], [$name, $arguments]);
    }



}