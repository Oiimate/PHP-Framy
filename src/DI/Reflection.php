<?php
namespace Framy\DI;

use ReflectionClass;

class Reflection {

    private $container;

    public function __construct() {
    }


    /**
     * @param Container $container
     */
    public function setContainer(Container $container) {
        $this->container = $container;
    }

    /**
     * @param $name
     * @return ReflectionClass
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function initReflection($name) {
        $reflector = new ReflectionClass($name);

        if (!$reflector->isInstantiable()) {
            throw new \Exception("Unable to instantiate" . $name);
        }
        return $reflector;
    }

    /**
     * @param $reflector
     * @return mixed
     */
    private function readConstructor($reflector) {
        $constructor = $reflector->getConstructor();
        if (!($constructor)) {
            return $reflector->newInstance();
        }
        return $constructor;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function autoWire($name)
    {
        $reflector = $this->initReflection($name);
        $constructor = $this->readConstructor($reflector);
        $params = $constructor->getParameters();
        $classes = $this->getClasses($params);

        return $reflector->newInstanceArgs($classes);
    }


    /**
     * @param $class
     * @param $param
     * @return mixed
     * @throws \Exception
     */
    private function checkParameters($class, $param) {
        if (!$class) {
            if (!$param->isDefaultValueAvailable()) {
                throw new \Exception("Can not resolve parameter");
            }
            return $param->getDefaultValue();
        }
        return $this->container->getInstance($class->name);
    }


    /**
     * @param $params
     * @return array
     * @throws \Exception
     */
    public function getClasses($params)
    {
        $classes = [];
        foreach ($params as $param) {
            $class = $param->getClass();
            $classes[] = $this->checkParameters($class, $param);
        }
        return $classes;
    }
}