<?php

namespace Framy\Http;

class Response {

    private $body = null;
    private $responseCode = 200;

    /**
     * Response constructor.
     * @param null $body
     * @param int $responseCode
     */
    public function __construct($body = null, $responseCode = 200) {
        $this->body = $body;
        $this->responseCode = $responseCode;
    }

    /**
     * @return null
     */
    public function get() {
        http_response_code($this->responseCode);
        return $this->body;
    }

    /**
     * @param $location
     */
    public function redirect($location) {
        return header("Location: " . $location);
    }
}