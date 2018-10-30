<?php
namespace Framy;
use Framy\Models\User;
use Framy\MySQL\Config;
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
     * @param Config $config
     * @throws \Exception
     */
    public function __construct(Config $config) {
        $this->config = $config;
        $this->setupContainer();
        $this->setupRouting();
        $this->setupMySQL();
    }

    private function setupContainer() {
        $this->reflection = new Reflection();
        $this->container = new Container($this->reflection);
    }

    private function setupRouting() {
        $this->router = new Router($this);
    }

    /**
     * @throws \Exception
     */
    private function setupMySQL() {
        $this->mysql = new Database($this->config);
        $this->mysql->createConnection();
    }

    public function getMySQL() {
        return $this->mysql;
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