<?php

namespace Framy\Http;

class Request {

    private $parameters;

    /**
     * @param array $params
     */
    public function setQueryParameters(array $params) {
        $this->parameters = $params;
    }

    /**
     * @param $parameterId
     * @return bool
     */
    public function query($parameterId) {
        if (!array_key_exists($parameterId, $this->parameters)) {
            return false;
        }
        return $this->parameters[$parameterId];
    }


    /**
     * @param $name
     * @return bool
     */
    public function input($name) {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }
        return false;
    }

    /**
     * @param mixed ...$names
     * @return array|bool
     */
    public function getInputs(... $names) {
        foreach ($names as $key => $name) {
            if (!$this->input($name)) {
                return false;
            }
            $names[$key] = $this->input($name);
        }
        return $names;
    }

    /**
     * @param $name
     * @return bool|string
     */
    public function filter($name) {
        $input = $this->input($name);
        if ($input) {
            return htmlspecialchars($input);
        }
        return false;
    }

    /**
     * @param array $names
     * @return array|bool
     */
    public function filterAll(array $names) {
        foreach ($names as $key => $name) {
            if (!$this->input($name)) {
                return false;
            }
            $names[$key] = $this->filter($name);
        }
        return $names;
    }
}