<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-20
 * Time: 16:48
 */

namespace RabbitMqRPC;
use PhpAmqpLib\Wire\AMQPTable;
abstract class AbstractListener
{
    abstract public function handle(array $table, string $body , string $correlation_id) : string;
}