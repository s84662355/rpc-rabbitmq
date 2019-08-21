<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-20
 * Time: 15:30
 */

namespace RabbitMqRPC;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPConnectionClosedException;
use PhpAmqpLib\Channel\AbstractChannel as Channel;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use PhpAmqpLib\Wire\AMQPTable;
class RPCClient {
    private $channel;
    private $callback_queue;
    private $response;
    private $corr_id;
    private $request_queue;


    public function __construct(Channel $channel,string $request_queue,string $connect_name = null) {
        $this->channel = $channel;
        $this->request_queue = $request_queue;
        $this->corr_id = md5($connect_name.microtime().time().uniqid().rand(1000,100000).implode('',$_ENV));
       //// $channel->queue_declare($rpc_queue , false, false, false, true);
      list($this->callback_queue, ,) = $this->channel->queue_declare('asdasdas', false, false,false,false)    ;
      ///  list($this->callback_queue, ,) = $this->channel->queue_declare($this->corr_id , false, false, true, false);
        ###不使用应答机制
        $this->channel->basic_consume(
            $this->callback_queue, '', false,true, false, false,
            array($this, 'on_response'));

    }


    public function on_response($rep)
    {
        if($rep->get('correlation_id') == $this->corr_id) {
            $this->response = $rep->body;
        }

        $rep->delivery_info['channel']->basic_cancel($rep->delivery_info['consumer_tag']);
    }

    public function call($n, $args = [] , $timeout = 1) {
        $this->response = null;

        $application_headers = new AMQPTable($args );

        $msg = new AMQPMessage(
            (string) $n,
            array('correlation_id' => $this->corr_id,
                'application_headers' =>  $application_headers ,
                'reply_to' => $this->callback_queue)
        );
        $this->channel->basic_publish($msg, '', $this->request_queue) ;

        try{
            $this->channel->wait(null,false,$timeout);
        }catch (AMQPTimeoutException $exception){
            throw  RPCResponseException::create($timeout,$this->request_queue,$this->corr_id,$method,$this->callback_queue,$n);
        }

        return  $this->response;
    }
};
