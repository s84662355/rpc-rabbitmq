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

    public function __construct($class_name,$annotation_config = [])
    {
        $this->reflection_class = new ReflectionClass($class_name);
        $this->annotation_config = $annotation_config ;
        $this->annotation_reader = new AnnotationReader();
    }

    public function iniMethodAnnotations( )
    {
        $methods = $this->reflection_class->getMethods();
        foreach ($methods as $m)
        {
             $this->method[$m->name] = $this->getMethodAnnotations($m);
        }
    }

    public function initPropertyAnnotations( )
    {
        $methods = $this->reflection_class->getMethods();
        foreach ($methods as $m)
        {
            $this->method[$m->name] = $this->getMethodAnnotations($m);
        }
    }

    public function getMethodAnnotations(ReflectionMethod $method)  : array
    {
        $annotations = $this->annotation_reader->getMethodAnnotations($method);

        $methodAnnotations = $this->annotation_config['method'];

        $results = [];

        foreach ($methodAnnotations as $methodAnnotation)
        {
            foreach ($annotations as $annotation) {
                if ($annotation instanceof $methodAnnotation) {
                    $results[$methodAnnotation] = $annotation;
                    break;
                }
            }
        }
        return $results ;
    }


    public function getClassAnnotations()
    {
        $annotations =  $this->annotation_reader->getClassAnnotations($this->reflection_class);
        $classAnnotations = $this->annotation_config['class'];
        $results = [];

        foreach ($classAnnotations as $classAnnotation)
        {
            foreach ($annotations as $annotation) {
                if ($annotation instanceof $classAnnotation) {
                    $results[$classAnnotation] = $annotation;
                    break;
                }
            }
        }
        return $results ;
    }

    //ReflectionProperty
    public function getPropertyAnnotations(ReflectionProperty $property)
    {
        $annotations =  $this->annotation_reader->getPropertyAnnotations( $property);
        $propertyAnnotations = $this->annotation_config['property'];

        $results = [];
        foreach ($propertyAnnotations as $propertyAnnotation)
        {
            foreach ($annotations as $annotation) {
                if ($annotation instanceof $propertyAnnotation) {
                    $results[$propertyAnnotation] = $annotation;
                    break;
                }
            }
        }
        return $results ;
    }



}