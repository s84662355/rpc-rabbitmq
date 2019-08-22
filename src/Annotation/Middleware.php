<?php
namespace RabbitMqRPC\Annotation;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

 /**
 * @Annotation
 * @Target("METHOD")
 */
class  Middleware
{
	public $class ;
}