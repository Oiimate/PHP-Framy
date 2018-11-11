<?php

namespace Framy\Controllers;

use Framy\Http\Request;
use Framy\Models\User;
use Twig_Environment;

class HomeController extends Controller {

    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function index(Twig_Environment $twig, Request $request) {
        echo $request->query('id');
        echo " Test from HomeController";
    }

    public function postView(Twig_Environment $twig, Request $request) {
        $user = $this->user;
        $user->name = "yo";

        $user->save($user);
    }

    public function postTest(Twig_Environment $twig, Request $request) {
        $formValue = $request->input("testform");
        print_r($request->getInputs("username", "password"));
        echo " Test from POST";
    }
}