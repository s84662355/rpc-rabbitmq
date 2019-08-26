<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-26
 * Time: 12:07
 */

namespace RabbitMqRPC\Annotation;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Annotation\Required;
/**
 * @Annotation
 * @Target("CLASS")
 */
class RPCConfig
{
    /**
     * @Required()
     * @var string
     */
    public $name = '';

}