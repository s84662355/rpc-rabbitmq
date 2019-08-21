<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-20
 * Time: 16:10
 */

namespace RabbitMqRPC;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exception\AMQPConnectionClosedException;
use PhpAmqpLib\Channel\AbstractChannel as Channel;
use PhpAmqpLib\Wire\AMQPTable;
class RPCServer {
    private $channel;
    private $callback;
    private $request_queue;
    private $consumer_tag;

    public function __construct(Channel $channel,string $request_queue, AbstractListener $callback )
    {
        $this->channel = $channel;
        $this->request_queue = $request_queue;
        $this->callback  = $callback ;
    }

    public function ready($consumer_tag = false)
    {
        $this->channel->basic_qos(null, 1, null);

        if($consumer_tag)
        {
            $this->consumer_tag = $consumer_tag;
        }else{
            $this->consumer_tag = __CLASS__.time();
        }

        ###不使用应答机制
        $this->channel->basic_consume($this->request_queue, $this->consumer_tag, false, true, false, false, [$this,'process_message']);
    }

    public function process_message(AMQPMessage $request_msg)
    {

        $body = $request_msg->getBody();
        $correlation_id = $request_msg->get('correlation_id');
        $response_queue = $request_msg->get('reply_to');
        $application_headers = $request_msg->get('application_headers');


        $response_body = call_user_func_array([$this->callback,'handle'],[ $application_headers ->getNativeData() ,$body , $correlation_id ]);


        $msg = new AMQPMessage(
            $response_body,
            array(
                'correlation_id' =>  $correlation_id
            )
        );
        $request_msg->delivery_info['channel']->basic_publish(
            $msg, '', $response_queue);
    }


    public function  startListen()
    {
        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

};
