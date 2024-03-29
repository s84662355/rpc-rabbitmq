<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/25
 * Time: 2:32
 */

namespace RabbitMqRPC\Annotation;


trait AnnotationTrait
{
    protected $annotation_parase = null;
    protected $class_parase = [];
    protected $method_parase = [];
    protected $property_parase = [];

    protected function getAnnotationParase() : AnnotationParase
    {
        if(empty($this->annotation_parase))
        {
          ////  $config = include 'annotation.config.php';
            ///
            $config = $this->annotation_config;

            $redis = $this->redis;

            $key = $this->redis_key;

            $this->annotation_parase = new AnnotationParase(static::class, $redis ,$key,$config);

            if(isset($this->cleanCache))
            {
                $this->annotation_parase->cleanCache();
            }

            if(!empty($this->annotation_config['debug']))
            {
                $this->annotation_parase->setDeBug();
            }

        }
        return   $this->annotation_parase ;
    }

    protected function initAnnotationParase()
    {
        $annotation_parase = $this->getAnnotationParase();
        $this->class_parase  =  $annotation_parase->getClassAnnotationParase();
        $this->method_parase = $annotation_parase->getMethodAnnotationParase();
        $this->property_parase = $annotation_parase->getPropertyAnnotationParase();
    }
}
