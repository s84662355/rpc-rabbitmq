<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-23
 * Time: 14:26
 */

namespace RabbitMqRPC\Annotation;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\FileCacheReader;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;


/*
 *
 * const integer IS_STATIC = 1 ;
const integer IS_PUBLIC = 256 ;
const integer IS_PROTECTED = 512 ;
const integer IS_PRIVATE = 1024 ;
const integer IS_ABSTRACT = 2 ;
const integer IS_FINAL = 4 ;
 *
 *
 * */



class AnnotationParase
{
    private $reflection_class = null;
    private $annotation_config = [];
    private $annotation_reader = null;
    private $method = [];
    private $property = [];

    public function __construct($class_name,$redis,$key,$annotation_config = [])
    {
        $this->reflection_class = new ReflectionClass($class_name);
        $this->annotation_config = $annotation_config ;


        $this->annotation_reader =   new RedisCacheReader( new AnnotationReader(),$redis,$key);


/*
        if(!empty($this->annotation_config['cache'])) {
            $this->annotation_reader = new FileCacheReader(
                new AnnotationReader(),
                $this->annotation_config['cache']);
        }else{
            $this->annotation_reader = new AnnotationReader();
        }
*/

    }


    protected function getMethodAnnotations(ReflectionMethod $method)  : array
    {
        $methodAnnotations = $this->annotation_config['method'];
        $results = [];
        foreach ($methodAnnotations as  $key =>   $methodAnnotation)
        {
            $annotation = $this->annotation_reader->getMethodAnnotation($method,  $methodAnnotation);
            $results[$key] = $annotation;
        }
        return $results ;
    }


    protected function getClassAnnotations()
    {
        $annotations =  $this->annotation_reader->getClassAnnotations($this->reflection_class);
        $classAnnotations = $this->annotation_config['class'];
        $results = [];

        foreach ($classAnnotations as  $key =>   $classAnnotation)
        {
            $annotation = $this->annotation_reader->getClassAnnotation($this->reflection_class, $classAnnotation);
            $results[$key] = $annotation;
        }
        return $results ;
    }

    //ReflectionProperty
    protected function getPropertyAnnotations(ReflectionProperty $property)
    {
        $propertyAnnotations = $this->annotation_config['property'];
        $results = [];
        foreach ($propertyAnnotations as  $key =>  $propertyAnnotation)
        {
            $annotation = $this->annotation_reader->getPropertyAnnotation($property , $propertyAnnotation);
            $results[$key] = $annotation;
        }
        return $results ;
    }

    public function getClassAnnotationParase()
    {
        return [
            'reflection' =>  $this->reflection_class,
            'parase'     =>  $this->getClassAnnotations(),
        ];
    }

    public function getMethodAnnotationParase()
    {
        $methods = $this->reflection_class->getMethods();
        foreach ($methods as $m)
        {
            $this->method[$m->name] = [
                'reflection' => $m,
                'parase' => $this->getMethodAnnotations($m),
            ];
        }
        return   $this->method;
    }

    public function getPropertyAnnotationParase()
    {
        $propertys = $this->reflection_class->getProperties();
        foreach ($propertys as $p)
        {
            $this->property[$p->name] = [
                'reflection' => $p,
                'parase' => $this->getPropertyAnnotations($p),
            ];
        }
        return $this->property;
    }


}