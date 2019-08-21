<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/22
 * Time: 0:32
 */

namespace RabbitMqRPC\App;
use Illuminate\Support\ServiceProvider;

class CjhRpcProvider  extends ServiceProvider
{
    /**
     * @var array
     */
    protected $commands = [
        CjhRpcCommand::class,
    ];


    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config' => config_path()], 'cjhrpc-config');
        }
        $this->app->singleton(
            'cjh_rpc',
            function (){
                return new AppRpc(config('cjh_rpc'));
            }
        );

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