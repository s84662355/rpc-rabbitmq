<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-26
 * Time: 11:30
 */

namespace RabbitMqRPC\App;

abstract class AbstractMiddleware
{
    public function __construct($name, $arguments , $options = [])
    {

    }

    public function before()
    {

    }

    public function after(&$results)
    {

    }

}