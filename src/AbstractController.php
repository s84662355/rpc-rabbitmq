<?php
namespace RabbitMqRPC;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPConnectionClosedException;
use PhpAmqpLib\Channel\AbstractChannel as Channel;
use PhpAmqpLib\Wire\AMQPTable;
abstract class AbstractServerListener extends AbstractListener
{


    public function __construct(  )
    {

    }



    public function handle(array $table, string $body , string $correlation_id) :string
    {
        if()



    }



};
