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
abstract class AbstractCjhService extends   AbstractService
{
    protected static $instance = null;

    protected function __construct( )
    {
        $this->annotation_config = config('annotation_config');
        $this->redis = app('redis');
        $this->redis_key = config('annotation_config.redis_key');
        parent::__construct(app('cjh_rpc'));
    }

    public static function getInstance()
    {
        if(empty(self::$instance))
        {
            self::$instance = new static();
        }
        return self::$instance;
    }


    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([ self::getInstance() , $name],   $arguments );
    }

}
