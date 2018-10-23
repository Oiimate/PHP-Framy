<?php
namespace Framy\DI;

use ReflectionClass;

class Reflection {

    public function __construct() {
    }


    /**
     * @param $name
     * @return ReflectionClass
     * @throws \ReflectionException
     * @throws \Exception
     */
    private function initReflection($name) {
        $reflection = new ReflectionClass($name);

        if (!$reflection->isInstantiable()) {
            throw new \Exception("Unable to instantiate" . $name);
        }
        return $reflection;
    }

    public function autoWire($name)
    {
        $reflector = $this->initReflection($name);

        $constructor = $reflector->getConstructor();

        return true;
    }
}