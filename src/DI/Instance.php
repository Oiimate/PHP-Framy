<?php
namespace Framy\DI;

class Instance {

    private $name;

    /**
     * @param $name
     * @throws \Exception
     */
    public function set($name) {
        if (!class_exists($name)) {
            throw new \Exception("(namespace) class does not exists");
        }
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function get() {
        return $this->name;
    }
}