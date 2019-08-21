<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-21
 * Time: 17:15
 */

namespace RabbitMqRPC\App;
use Serializable;
use Throwable;

class Response implements Serializable
{
    private $error_msg = [];
    private $body ;

    public function __construct($body = null)
    {
       $this->body = $body;
    }

    public function error(Throwable $throwable)
    {
        $this->error_msg['message'] = $throwable->getMessage();
        $this->error_msg['code'] = $throwable->getCode();
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getError()
    {
        return $this->error_msg;
    }


    public function serialize()
    {
        return  serialize([
            'error_msg' => $this->error_msg,
            'body'      => $this->body,
        ]);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        $this->body = $data['body'];
        $this->error_msg = $data['error_msg'];
    }
}