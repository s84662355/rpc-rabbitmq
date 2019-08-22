<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/22
 * Time: 1:05
 */
namespace RabbitMqRPC\App;
use Illuminate\Console\Command;

class CjhRpcCommand  extends Command
{
    protected $signature = ' CjhRpcCommand {name?}  {--c=} {--r=}  {--out=}';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        if(!empty($name))
        {
            $file_out = $this->option('out');
            $daemon = new Daemon($name);
            return   $daemon->init( $this,$file_out);

        }
        $this->doHandle( );
    }

    public function doHandle(  )
    {
        $connection = $this->option('c');
        $rpc_config      = $this->option('r');
        $rpc_driver = app( 'cjh_rpc')->getDriver($connection);
        $rpc_driver->AppServer($rpc_config)->startListen( );
    }

}