<?php

namespace Framy\Routing;

use Exception;
use Framy\DI\Container;
use Twig_Environment;

class Route {

    public $routePath;
    private $callback;
    private $parameters = [];
    private $middleware;
    private $container;
    private $twig;

    public function __construct(Container $container, Twig_Environment $twig) {
        $this->container = $container;
        $this->twig = $twig;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setPath(string $path) {
        $this->routePath = ltrim($path, '/');
        return $this;
    }

    /**
     * @param $callback
     * @return $this
     */
    public function setCallback($callback) {
        $this->callback = $callback;
        return $this;
    }

    /**
     * @param $middleware
     * @return $this
     */
    public function setMiddleware($middleware) {
        $this->middleware = $middleware;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoutePath() {
        return $this->routePath;
    }


    /**
     * @param $url
     * @return bool
     * @throws Exception
     */
    public function matchRoute(string $url) {
        $routePath = explode('/', $this->routePath);
        $requestUrl = explode('/', $url);

        if (count($routePath) != count($requestUrl)) {
            return false;
        }

        foreach ($routePath as $key => $route) {
            if (strpos($route, ':') !== false) {
                $value = $this->checkValue($route, $requestUrl[$key]);
                if (!$value) {
                    return false;
                }
                $this->parameters[$value] = $requestUrl[$key];
            } else {
                if ($requestUrl[$key] != $route) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @param string $route
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function checkValue(string $route, $id) {
        if (strpos($route, '[i]') !== false) {
            if (filter_var($id, FILTER_VALIDATE_INT)) {
                return $this->formatRoute($route, '[i]');
            }
            throw new Exception("Route parameter does not contain integers only");
        }
        if (strpos($route, '[s]') !== false) {
            if (preg_match('/[^A-Za-z0-9]/', $id) === 0) {
                return $this->formatRoute($route, '[s]');
            }
            throw new Exception("Route parameter does not contain a string");
        }
        return $this->formatRoute($route);
    }

    /**
     * @param $route
     * @param bool $input
     * @return string
     */
    public function formatRoute($route, $input = false) {
        if ($input) {
            $formattedRoute = trim($route, $input);
            return trim($formattedRoute, ':');
        }
        return trim($route, ':');
    }

    /**
     * @return bool|mixed
     */
    public function call() {
        $call = new Call($this->container, $this->twig);
        $call->setCallProps($this->callback, $this->middleware, $this->parameters);
        return $call->execute();
    }
}