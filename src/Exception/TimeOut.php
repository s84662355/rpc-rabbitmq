<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/31
 * Time: 1:12
 */

namespace RabbitMqRPC\Exception;
use Exception;
use Throwable;

class TimeOut extends  Exception
{
    public  function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}