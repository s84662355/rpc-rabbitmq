<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/22
 * Time: 0:32
 */

namespace RabbitMqRPC\App;
use Illuminate\Support\ServiceProvider;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

class CjhRpcProvider  extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        CjhRpcCommand::class,
        \RabbitMqRPC\Annotation\CjhCacheCommand::class,
    ];


    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../../config' => config_path()], 'cjhrpc-config');
        }

        $this->app->singleton(
            'cjh_rpc',
            function (){
                $loader =  require  dirname(dirname(  dirname( dirname(  __dir__ ) )      )   )     . '/autoload.php';

                AnnotationRegistry::registerLoader(array($loader, "loadClass"));
                return new AppRpc(config('cjh_rpc'),config('rpc_handle'));
            }
        );

        if(config('cjh_rpc.debug'))
        {

            Route::prefix('rabbitmq/rpc')->post('test',function(Request $request){
                $cjh_rpc = config('cjh_rpc');
                $connection =  $request->input('c',$cjh_rpc['default']);
                $r =  $request->input('r',$cjh_rpc['driver']['rpc_driver']['default']);
                $rpc_config = $cjh_rpc['driver']['rpc_driver']['config'][$r];
                $controller = new $rpc_config['controller']();
                $request_method = $request->input('method');
                $body = $request->input('body');
                $options = $request->input('options',[]);
                $response = call_user_func_array([$controller ,'callMethod'],[$request_method,  $body , $options ]);
                return $response ;
            });
        }


    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);



    }
}
