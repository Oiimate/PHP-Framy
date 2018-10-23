<?php

namespace Framy\Controllers;

use Framy\Http\Request;

class HomeController {

    public function index(Request $request) {
        echo $request->query('id');
        echo " Test from HomeController";
    }

    public function postView(Request $request) {
        echo '<form method=\'POST\' action=\'./test\'><input name=\'testform\'><input name=\'testform2\'><button type=\'submit\'>Submit</button></form>';
    }

    public function postTest(Request $request) {
        $formValue = $request->input("testform");
        print_r($request->getInputs("username", "password"));
        echo " Test from POST";
    }
}