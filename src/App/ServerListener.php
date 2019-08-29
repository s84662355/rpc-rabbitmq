<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-20
 * Time: 14:20
 */
namespace RabbitMqRPC\App;
use RabbitMqRPC\AbstractController;
use RabbitMqRPC\AbstractListener;
use  RabbitMqRPC\AbstractServerListener;
use Throwable;

class ServerListener extends  AbstractServerListener
{
    private $log_path = false;

    public function __construct(AbstractCjhController $controller,$log_path = false)
    {
        parent::__construct($controller);
        $this->log_path = $log_path;
    }

    public function setLogPath($log_path)
    {
        $this->log_path = $log_path;
    }

    public function filter($response): string
    {
        $resp = serialize(new Response($response));
        if($this->log_path)
            LogService::instance($this->log_path)->info($resp);
        return $resp;
    }

    protected function handleError(Throwable $throwable) :string
    {
        if($this->log_path)
            LogService::instance($this->log_path)->info($throwable->__toString());

       ///// echo $throwable->__toString();
        $response = new Response();
        $response->error($throwable);
        $resp = serialize(  $response );

        return $resp ;
    }



}
