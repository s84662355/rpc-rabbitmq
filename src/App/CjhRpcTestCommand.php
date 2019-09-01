<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/22
 * Time: 1:05
 */
namespace RabbitMqRPC\App;
use Illuminate\Console\Command;

class CjhRpcTestCommand  extends Command
{
    ///php artisan CjhRpcTestCommand
    protected $signature = ' CjhRpcCommand {--c=} {--r=}     ';


    private $app_client = null;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->doHandle();
        while (true)
        {
            $method = $this->ask( ' 输入需要调用的方法' );


        }
    }

    public function doHandle(  )
    {
        $connection = $this->option('c');
        $rpc_config      = $this->option('r');

        $rpc_config  = config('cjh_rpc.driver.'.$connection.'.rpc_driver.config.'.$rpc_config);

        $controller = $rpc_config['controller'];

        $controller = new $controller();


        $response = call_user_func_array([ $controller,'callMethod'],[$request_method,  $body , $options ]);




    }

}