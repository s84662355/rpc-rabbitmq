<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-27
 * Time: 14:50
 */

namespace RabbitMqRPC;


class RPCControllerException  extends \Exception
{
    public function __construct($msg,$code = 0, Throwable $previous = null)
    {
        parent::__construct($msg , $code, $previous);
    }

}