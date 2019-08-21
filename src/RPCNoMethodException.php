<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-20
 * Time: 13:50
 */

namespace RabbitMqRPC;
use Throwable;

class RPCNoMethodException extends \Exception
{


    public function __construct($class,$method,$code = 0, Throwable $previous = null)
    {
        $msg = 'Class '.$class.' not have '.$method.' function';
        parent::__construct($msg , $code, $previous);
    }



}