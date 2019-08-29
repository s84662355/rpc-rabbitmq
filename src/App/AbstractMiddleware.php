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
    abstract  public function __construct($name, $arguments ,array $options = []);

    abstract public function before();

    abstract public function after(&$results);

}