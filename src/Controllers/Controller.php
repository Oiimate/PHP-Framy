<?php
namespace Framy\Controllers;

use Twig_Environment;

abstract class Controller {

    private $twig;

    /**
     * @param Twig_Environment $twig
     */
    public function setTwig(Twig_Environment $twig) {
        $this->twig = $twig;
    }

    /**
     * @param $view
     * @param array $parameters
     */
    public function view($view, array $parameters = []) {
        echo $this->twig->render($view . '.twig', $parameters);
    }
}