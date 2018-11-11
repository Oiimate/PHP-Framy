<?php
namespace Framy\Routing;

use Framy\Application;

class Call
{

    private $app;
    private $callback;
    private $middleware;
    private $parameters;

    public function __construct(Application $app, $callback, $middleware, $parameters) {
        $this->app = $app;
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

        $controller = $this->app->getContainer()->getInstance($controller);
        $twig = $this->app->getTwig();
        $controller->setTwig($twig);
        $request = new $request();

        if ($this->parameters) {
            $request->setQueryParameters($this->parameters);
        }
        return $controller->$methodName($twig, $request);
    }
}