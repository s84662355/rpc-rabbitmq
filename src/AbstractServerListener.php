<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-20
 * Time: 16:35
 */

namespace RabbitMqRPC;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPConnectionClosedException;
use PhpAmqpLib\Channel\AbstractChannel as Channel;
use PhpAmqpLib\Wire\AMQPTable;
use Throwable;
use Exception;
abstract class AbstractServerListener extends AbstractListener
{
    protected $controller = null;


    public function __construct( AbstractController $controller )
    {
        $this->controller = $controller;
    }


    public function handle(array $table, string $body , string $correlation_id) : string
    {
        try{

            if(empty($table['request_method']))
                throw new  Exception(" no  request_method" );
                

            $request_method = $table['request_method'];

            $body = unserialize($body);

            if(!is_array($body))
                throw new  Exception(" no  body " );

            $options = [];
            
            if(!empty($table['options']))
            {
                $options = $table['options'];
            }
            /*
            call_user_func_array([$this->controller,'before'],[$request_method, $body]  );
            $response = call_user_func_array([$this->controller,$request_method],$body);
            call_user_func_array([$this->controller,'after'],[$request_method, $body]);
            */
            $response = call_user_func_array([$this->controller,'callMethod'],[$request_method,  $body , $options ]);
        }catch (Throwable $throwable){
            return  $this->handleError($throwable);
        }

        return $this->filter($response);

    }

    abstract protected function filter($response)  : string ;


    abstract protected function handleError(Throwable $throwable) :string;

};
