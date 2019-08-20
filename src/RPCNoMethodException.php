<?php
namespace RabbitMqRPC;
use Throwable;

class RPCResponseException extends \Exception
{
    private $msg_data = [];

    public function __construct($msg_data = [], $code = 0, Throwable $previous = null)
    {
        $this->msg_data = $msg_data;
        array_walk_recursive($msg_data,function(&$value,$key){
            $value = $key.':'.$value;
        });
        parent::__construct(implode('   ',$msg_data), $code, $previous);
    }

    public static function create($timeout,$request_queue,$corr_id,$method,$callback_queue,$request_body)
    {
        $msg_data =
           compact([
               'timeout',
               'request_queue',
               'corr_id',
               'method',
               'callback_queue',
               'request_body',
           ]);
        return new static( $msg_data  );
    }

    public function __get($name)
    {
        return empty($this->msg_data[$name]) ? null : $this->msg_data[$name];
    }


}