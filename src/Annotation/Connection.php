<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-26
 * Time: 17:15
 */

namespace RabbitMqRPC\Annotation;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Annotation\Required;

/**
 * @Annotation
 * @Target("CLASS")
 */
class Connection
{
    /**
     * @Required()
     * @var string
     */
    public $name = '';

}