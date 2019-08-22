<?php
require_once  dirname(__DIR__ ). '/vendor/autoload.php';

 use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;


 /**
 * @Annotation
 */
final class MyAnnotation
{
    public $myProperty;
}

class Foo
{
    /**
     * @MyAnnotation(myProperty="2121value")
     */
    private $bar;

    /**
     * @MyAnnotation(myProperty="2121sfsdfsdfvalue")
     */
    private  function FunctionName($value='')
    {
        # code...
    }
}


$reflectionClass = new ReflectionClass(Foo::class);
//$property = $reflectionClass->getProperty('bar');

$method = $reflectionClass->getMethod('FunctionName');

/*
$reader = new AnnotationReader();
$myAnnotation = $reader->getPropertyAnnotation(
    $property,
    MyAnnotation::class
);

echo $myAnnotation->myProperty; // result: "value"
 */

$reader = new AnnotationReader();
$myAnnotation = $reader-> getMethodAnnotation(
    $method,
    MyAnnotation::class
);

echo $myAnnotation->myProperty;
 
