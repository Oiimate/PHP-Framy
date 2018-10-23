<?php

namespace Framy\DI;


class Container
{
    private $instances = [];
    private $reflection;

    /**
     * Container constructor.
     * @param Reflection $reflection
     */
    public function __construct(Reflection $reflection) {
        $this->reflection = $reflection;
        $this->reflection->setContainer($this);
    }


    /**
     * @param $name
     * @param null $callback
     * @throws \Exception
     */
    public function setInstance($name, $callback = null) {
        if ($callback && is_callable($callback)) {
            $this->instances[$name] = $callback;
        }
        $instance = new Instance();
        $instance->set($name);
        $this->instances[$name] = $instance;
    }


    /**
     * @param $name
     * @return mixed
     * @throws \ReflectionException
     */
    public function getInstance($name) {
        if (!isset($this->instances[$name])) {
            $this->setInstance($name);
        }

        $instance = $this->instances[$name];
        if (is_callable($instance)) {
            return $instance;
        }
        return $this->reflection->autoWire($instance->get());
    }
}