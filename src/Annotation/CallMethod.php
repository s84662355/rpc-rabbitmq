<?php
namespace RabbitMqRPC\Annotation;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

 /**
 * @Annotation
 */
final  class  CallMethod
{
    /**
     * @var string
     */
	public $handle ;
}