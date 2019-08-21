<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-21
 * Time: 17:06
 */
namespace RabbitMqRPC\App;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Formatter\LineFormatter;

class LogService
{

    private static $logger = null;


    public static function instance($path)
    {
        if(empty(self::$logger))
        {
            self::$logger =  new Logger('INFO');
            $handler = (new RotatingFileHandler($path   , 1))
                ->setFormatter(new LineFormatter(null, null, true, true));

            self::$logger ->pushHandler($handler);
        }
        return   self::$logger;
    }


}