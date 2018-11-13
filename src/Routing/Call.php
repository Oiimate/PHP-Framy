<?php
namespace Framy\Routing;

use Framy\DI\Container;
use Twig_Environment;

class Call
{

    private $container;
    private $callback;
    private $middleware;
    private $parameters;
    private $twig;

    public function __construct(Container $container, Twig_Environment $twig) {
        $this->container = $container;
        $this->twig = $twig;
    }

    /**
     * @param $callback
     * @param $middleware
     * @param $parameters
     */
    public function setCallProps($callback, $middleware, $parameters) {
        $this->callback = $callback;
        $this->middleware = $middleware;
        $this->parameters = $parameters;
    }

    public function execute() {
        if (is_string($this->callback)) {
            return $this->init();
        } else if (is_callable($this->callback)) {
            if (is_object($this->middleware)) {
                $this->middleware->run();
            }
            return call_user_func_array($this->callback, $this->parameters);
        }
        return false;
    }


    public function init() {
        list($controllerName, $methodName) = explode(':', $this->callback);
        $controller = "Framy\\Controllers\\" . $controllerName . "Controller";
        $request = "Framy\\Http\\Request";

        if (is_object($this->middleware)) {
            $this->middleware->run();
        }

        $controller = $this->container->getInstance($controller);
        $controller->setTwig($this->twig);
        $request = new $request();

        if ($this->parameters) {
            $request->setQueryParameters($this->parameters);
        }
        return $controller->$methodName($this->twig, $request);
    }
}