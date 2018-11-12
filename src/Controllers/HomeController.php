<?php

namespace Framy\Controllers;

use Framy\Http\Request;
use Framy\Models\User;
use Framy\MySQL\Database;
use Twig_Environment;

class HomeController extends Controller {

    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function index(Twig_Environment $twig, Request $request) {
        echo $request->query('id');
        echo " Test from HomeController";
    }

    public function postView(Twig_Environment $twig, Request $request) {
        $user = new User($this->db);
        $user->name = "Test2";
        $user->id = 3;
        $saveUser = $user->edit($user);

        if ($saveUser) {
            echo "Added";
        } else {
            echo "Error";
        }
    }

    public function postTest(Twig_Environment $twig, Request $request) {
        $formValue = $request->input("testform");
        print_r($request->getInputs("username", "password"));
        echo " Test from POST";
    }
}