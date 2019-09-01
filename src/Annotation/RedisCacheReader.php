<?php
/**
 * Created by PhpStorm.
 * User: chenjiahao
 * Date: 2019-08-31
 * Time: 14:11
 */


namespace RabbitMqRPC\Annotation;
use  Doctrine\Common\Annotations\Reader;

class RedisCacheReader implements Reader
{
    /**
     * @var Reader
     */
    private $reader;


    /**
     *
     */
    private  $redis;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @var array
     */
    private $loadedAnnotations = [];

    /**
     * @var array
     */
    private $classNameHashes = [];


    private  $redis_hash_key = '';



    /**
     * Constructor.
     *
     * @param Reader  $reader
     * @param string  $cacheDir
     * @param boolean $debug
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(Reader $reader, $redis ,$key ,$debug = false )
    {
        $this->reader = $reader;
        $this->redis = $redis;
        $this->debug = false;
        $this->redis_hash_key = $key;
    }

    public function cleanCache()
    {
        $this->redis->del( $this->redis_hash_key );
    }

    public function setDeBug($debug = true)
    {
           $this->debug = $debug;
    }

    /**
     * {@inheritDoc}
     */
    public function getClassAnnotations(\ReflectionClass $class)
    {
        if ( ! isset($this->classNameHashes[$class->name])) {
            $this->classNameHashes[$class->name] =   $class->name ;
        }
        $key = $this->classNameHashes[$class->name] ;

        if (isset($this->loadedAnnotations[$key])) {
            return $this->loadedAnnotations[$key];
        }

        $path = strtr($key, '\\', '-').'.cache.php';

        if ($this->debug){
            $annot = $this->reader->getClassAnnotations($class);
            $this->saveCacheFile($path, $annot);

            var_dump("dsadsadsdsdsadasdsa");
            return $this->loadedAnnotations[$key] = $annot;
        }

        $annot = $this->getCacheFile($path);


        if(empty($annot))
        {
            $annot = $this->reader->getClassAnnotations($class);
            $this->saveCacheFile($path, $annot);

        }
        return $this->loadedAnnotations[$key] = $annot;

    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyAnnotations(\ReflectionProperty $property)
    {
        $class = $property->getDeclaringClass();
        if ( ! isset($this->classNameHashes[$class->name])) {
            $this->classNameHashes[$class->name] =  $class->name ;
        }
        $key = $this->classNameHashes[$class->name] . '$'.$property->getName()  ;

        if (isset($this->loadedAnnotations[$key])) {
            return $this->loadedAnnotations[$key];
        }

        $path =  strtr($key, '\\', '-').'.cache.php';


        if ($this->debug) {
            $annot = $this->reader->getPropertyAnnotations($property);
            $this->saveCacheFile($path, $annot);
            return $this->loadedAnnotations[$key] = $annot;
        }

        $annot = $this->getCacheFile($path);
        if(empty($annot))
        {
            $annot = $this->reader->getPropertyAnnotations($property);
            $this->saveCacheFile($path, $annot);
        }

        return $this->loadedAnnotations[$key] = $annot;
    }

    /**
     * {@inheritDoc}
     */
    public function getMethodAnnotations(\ReflectionMethod $method)
    {
        $class = $method->getDeclaringClass();
        if ( ! isset($this->classNameHashes[$class->name])) {
            $this->classNameHashes[$class->name] =  $class->name ;
        }
        $key = $this->classNameHashes[$class->name]. '#'.$method->getName();

        if (isset($this->loadedAnnotations[$key])) {
            return $this->loadedAnnotations[$key];
        }

        $path =  strtr($key, '\\', '-').'.cache.php';


        if ($this->debug) {
            $annot = $this->reader->getMethodAnnotations($method);
            $this->saveCacheFile($path, $annot);
            return $this->loadedAnnotations[$key] = $annot;
        }


        $annot = $this->getCacheFile($path);

        if(empty($annot))
        {
            $annot = $this->reader->getMethodAnnotations($method);
            $this->saveCacheFile($path, $annot);
        }
        return $this->loadedAnnotations[$key] = $annot;
    }

    /**
     * Saves the cache file.
     *
     * @param string $path
     * @param mixed  $data
     *
     * @return void
     */
    private function saveCacheFile($path, $data)
    {
        if(!$this->redis->exists($this->redis_hash_key))
        {
            $this->redis->hset($this->redis_hash_key,'begin',date('Y-m-d h:i:s'));
            $this->redis->expire($this->redis_hash_key,30);
        }


        //$this->redis_hash_key;
    /// $written = file_put_contents($tempfile, '<?php return .unserialize('.var_export(serialize($data), true)');');

        $this->redis->hset($this->redis_hash_key,$path, serialize($data));
    }


    private function getCacheFile($path)
    {
      //  echo $path;
       // echo PHP_EOL;
       /// var_dump( $this->redis->hget($this->redis_hash_key,$path)) ;

      //  echo PHP_EOL;
       return unserialize($this->redis->hget($this->redis_hash_key,$path));
    }

    /**
     * {@inheritDoc}
     */
    public function getClassAnnotation(\ReflectionClass $class, $annotationName)
    {
        $annotations = $this->getClassAnnotations($class);

        foreach ($annotations as $annotation) {
            if ($annotation instanceof $annotationName) {
                return $annotation;
            }
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getMethodAnnotation(\ReflectionMethod $method, $annotationName)
    {
        $annotations = $this->getMethodAnnotations($method);

        foreach ($annotations as $annotation) {
            if ($annotation instanceof $annotationName) {
                return $annotation;
            }
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getPropertyAnnotation(\ReflectionProperty $property, $annotationName)
    {
        $annotations = $this->getPropertyAnnotations($property);

        foreach ($annotations as $annotation) {
            if ($annotation instanceof $annotationName) {
                return $annotation;
            }
        }

        return null;
    }

    /**
     * Clears loaded annotations.
     *
     * @return void
     */
    public function clearLoadedAnnotations()
    {
        $this->loadedAnnotations = [];
    }
}
