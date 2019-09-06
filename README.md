# rpc-rabbitmq
这里主要是laravel的使用方法

composer require chenjiahao/rpc-rabbitmq

'providers' => [
    RabbitMqRPC\App\CjhRpcProvider::class,
    
    .......
            .......
                    .......
                    
                            .......
                                    .......
                                            .......
                                                    .......
}


php artisan vendor:publish --provider="RabbitMqRPC\App\CjhRpcProvider::class"
或者

php artisan vendor:publish 之后选择 RabbitMqRPC\App\CjhRpcProvider::class



控制器 继承 RabbitMqRPC\App\AbstractCjhController
重写 before  after
    
    每一个方法执行前执行
    protected function before($name, $arguments , $options = [])

    每一个方法执行完后执行
    protected function after($name, $arguments ,$options = [], &$results )
    
    每一个对外提供的方法必须添加CallMethod注解
    use RabbitMqRPC\Annotation\CallMethod;
        /**
         * @CallMethod()
         *
         * */
         
         
         

