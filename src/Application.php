<?php
namespace Framy;
use Framy\Models\User;
use Framy\MySQL\Database;
use Framy\Routing\Router;
use Framy\DI\Container;
use Framy\DI\Reflection;

class Application {

    private $config;
    private $router;
    private $container;
    private $reflection;
    private $mysql;

    /**
     * Application constructor.
     * @param array $config
     * @throws \Exception
     */
    public function __construct(array $config) {
        $this->config = $config;
        $this->setupContainer();
        $this->setupRouting();
        $this->setupMySQL();
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

    /**
     * @throws \Exception
     */
    public function setupMySQL() {
        $this->mysql = new Database($this->config);
        $this->mysql->createConnection();
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