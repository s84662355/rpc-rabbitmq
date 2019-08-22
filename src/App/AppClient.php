<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-20
 * Time: 14:50
 */
namespace RabbitMqRPC\App;
use PhpAmqpLib\Channel\AbstractChannel as Channel;
use RabbitMqRPC\AbstractClient;
use RabbitMqRPC\AbstractServer;
use RabbitMqRPC\AbstractServerListener;
use Exception;
class AppClient  extends  AbstractClient
{
    public function __construct(Channel $channel, string $request_queue, array $caLL_method = [])
    {
        parent::__construct($channel, $request_queue, $caLL_method);
    }

    /**
     * @param mixed $response
     * @return mixed
     */
    protected function make(  $response)
    {

        $error = $response->getError();
        if(!empty($error))
        {
            throw new  Exception($error['message'],$error['code']);
        }
        return $response->getBody();
    }


}