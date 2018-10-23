<?php
namespace Framy\DI;

use ReflectionClass;

class Reflection {

    private $reflector;

    public function __construct() {
    }


    /**
     * @param $name
     * @return Reflection
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function initReflection($name) {
        $this->reflector = new ReflectionClass($name);

        if (!$this->reflector->isInstantiable()) {
            throw new \Exception("Unable to instantiate" . $name);
        }
        return $this;
    }

    private function readConstructor() {
        $constructor = $this->reflector->getConstructor();
        if (!($constructor)) {
            return $this->reflector->newInstance();
        }
        return $constructor;
    }

    public function autoWire($name)
    {
        $constructor = $this->initReflection($name)->readConstructor();
        $params = $constructor->getParameters();
        return true;
    }
}