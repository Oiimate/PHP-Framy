<?php

namespace Framy\Controllers;

use Framy\Http\Request;
use Framy\Models\User;

class HomeController {

    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function index(Request $request) {
        echo $request->query('id');
        echo " Test from HomeController";
    }

    public function postView(Request $request) {
        print_r($this->user->select('id, id2')->where(['id = 1', 'id2 > 2'])->get());
        echo '<form method=\'POST\' action=\'./test\'><input name=\'testform\'><input name=\'testform2\'><button type=\'submit\'>Submit</button></form>';
    }

    public function postTest(Request $request) {
        $formValue = $request->input("testform");
        print_r($request->getInputs("username", "password"));
        echo " Test from POST";
    }
}