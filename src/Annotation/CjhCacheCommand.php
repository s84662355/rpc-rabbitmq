<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/01
 * Time: 21:31
 */
namespace RabbitMqRPC\Annotation;
use  Illuminate\Console\Command;
 

class CjhCacheCommand  extends Command
{
    ///php artisan CjhCacheCommand 
    protected $signature = '  CjhCacheCommand  ';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
         app('redis')->del(config('annotation_config.redis_key'));
    }

  

}