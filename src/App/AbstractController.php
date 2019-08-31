<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-22
 * Time: 14:45
 */

namespace RabbitMqRPC\App;

use RabbitMqRPC\AbstractController as Controller;
use RabbitMqRPC\Annotation\AnnotationTrait;
use RabbitMqRPC\RPCNoMethodException;
use ReflectionClass;
abstract class AbstractController extends   Controller
{
    use AnnotationTrait;

    protected $annotation_config = [];

    protected $handle = [];

    public function __construct()
    {
        $this->initAnnotationParase();
    }

    abstract protected function before($name, $arguments , $options = []);

    abstract protected function after($name, $arguments ,$options = [], &$results );

    public function callMethod($name, $arguments , $options = [])
    {
        $this->before($name, $arguments , $options  );

        $handles = $this->checkCanCallOn($name);

        if(!empty($handles))
        {
            foreach ($handles as &$value)
            {
                $value =  $this->handle[$value];
                $reflectionClass = new ReflectionClass( $value );
                $value = call_user_func_array([$reflectionClass,'newInstance'],[
                    $name , $arguments ,$options
                ] ) ;
                call_user_func_array([ $value  ,'before'],[]);
            }

        }

        $results = call_user_func_array([$this ,$name],$arguments);


        if(!empty($handles))
        {
            foreach ($handles as &$value)
            {
                   $value->after($results );
            }
        }

        $this->after($name, $arguments  ,$options ,$results );

        return  $results;
    }


    protected function checkCanCallOn($name)
    {
         if(empty($this->method_parase[$name]) )
         {
             throw new RPCNoMethodException(__CLASS__, $name);
         }

         $method_parase = $this->method_parase[$name];

         if( !$method_parase['reflection']->isPublic() || empty($method_parase['parase']['call_method']))
         {
             ##要抛出错误
               throw new RPCNoMethodException(__CLASS__,$name);
         }

         $handle_class = $method_parase['parase']['call_method']->handle;


         if(!empty($handle_class))
         {
            return  $handle_class;
         }

         return null;
    }

    public function setHandle($handle)
    {
        $this->handle = $handle;
    }

}
