<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-22
 * Time: 14:45
 */

namespace RabbitMqRPC\App;

use RabbitMqRPC\Annotation\AnnotationTrait;
use RabbitMqRPC\RPCNoMethodException;
use ReflectionClass;
abstract class AbstractCjhController extends AbstractController
{

    public function __construct()
    {
        $this->annotation_config = config('annotation_config');
        $this->redis = app('redis');
        $this->redis_key = config('annotation_config.redis_key');
        parent::__construct();
    }

}
