<?php

namespace Framy\DI;


class Container
{
    private $instances = [];
    private $reflection;

    public function __construct(Reflection $reflection) {
        $this->reflection = $reflection;
    }


    public function setInstance($name, $callback = null) {
        if ($callback && is_callable($callback)) {
            $this->instances[$name] = $callback;
        }
        $instance = new Instance();
        $instance->set($name);
        $this->instances[$name] = $instance;
    }


    public function getInstance($name) {
        if (!in_array($name, $this->instances)) {
            $this->setInstance($name);
        }

        $instance = $this->instances[$name];
        if (is_callable($instance)) {
            return $instance;
        }

        return $this->reflection;
    }
}