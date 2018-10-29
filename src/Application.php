<?php

namespace Framy;

use Framy\Models\User;
use Framy\Routing\Router;
use Framy\DI\Container;
use Framy\DI\Reflection;

class Application {

    private $router;
    private $container;
    private $reflection;

    public function __construct() {
        $this->setupContainer();
        $this->setupRouting();
    }

    public function setupContainer() {
        $this->reflection = new Reflection();
        $this->container = new Container($this->reflection);
//        $test = $this->container->getInstance('Framy\Routing\Test');
        $model = new User();
        $builder = $model->builder();
        $builder->select('id, id2')->where(['id = 1', 'id2 > 2'])->get();

    }

    public function setupRouting() {
        $this->router = new Router($this->container);
    }

    public function getContainer() {
        return $this->container;
    }

    public function getRouter() {
        return $this->router;
    }

    public function getReflection() {
        return $this->reflection;
    }

    public function run() {
        session_start();
        $this->router->run();
    }
}