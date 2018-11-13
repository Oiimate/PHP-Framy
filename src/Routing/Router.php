<?php

namespace Framy\Routing;

use Exception;
use Framy\DI\Container;
use Framy\Middleware\MiddlewareInterface;
use Twig_Environment;

class Router {

    private $url;
    private $routes = [];
    private $middleware = [];
    private $currentRoute;
    private $container;
    private $twig;

    /**
     * Router constructor.
     * @param Container $container
     * @param Twig_Environment $twig
     */
    public function __construct(Container $container, Twig_Environment $twig) {
        $this->container = $container;
        $this->twig = $twig;

        if (isset($_GET['url'])) {
            $this->url = $_GET['url'];
        }
    }


    /**
     * @param string $path
     * @param $callback
     * @return $this
     */
    public function get(string $path, $callback) {
        $this->currentRoute = $this->add($path, $callback, 'GET');
        return $this;
    }

    /**
     * @param $middlewareName
     * @throws Exception
     */
    public function addMiddleware($middlewareName) {
        $middleware = $this->registerMiddleware($middlewareName);
        $this->currentRoute->setMiddleware($middleware);
    }


    /**
     * @param string $path
     * @param $callback
     * @return $this
     */
    public function post(string $path, $callback) {
        $this->currentRoute = $this->add($path, $callback, 'POST');
        return $this;
    }


    /**
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function registerMiddleware($name) {
        if (array_key_exists($name, $this->middleware)) {
            return $this->middleware[$name];
        }

        $middleware = "Framy\\Middleware\\" . $name . 'Middleware';
        if (!class_exists($middleware)) {
            throw new Exception("Middleware does not exist");
        }

        $middlewareObj = new $middleware;
        if (!$middlewareObj instanceof MiddlewareInterface) {
            throw new Exception('Middleware class does not implement MiddlewareInterface');
        }
        $this->middleware[$name] = $middlewareObj;
        return $this->middleware[$name];
    }


    /**
     * @param string $path
     * @param $callback
     * @param string $method
     * @return Route
     */
    private function add(string $path, $callback, string $method) {
        $route = (new Route($this->container, $this->twig))
            ->setPath($path)
            ->setCallback($callback);

        $this->routes[$method][] = $route;
        return $route;
    }


    /**
     * @return mixed
     * @throws Exception
     */
    public function run() {
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new Exception("Method does not exist");
        }

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($route->matchRoute($this->url)) {
                    return $route->call();
                }
            }
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if ($route->matchRoute($this->url)) {
                    return $route->call();
                }
            }
        }
        throw new Exception("No route found for this path");
    }
}