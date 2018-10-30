<?php
namespace Framy\Controllers;

use Twig_Environment;

abstract class Controller {

    private $twig;

    public function setTwig(Twig_Environment $twig) {
        $this->twig = $twig;
    }

    public function view($view, array $parameters = []) {
        echo $this->twig->render($view . '.twig', $parameters);
    }
}