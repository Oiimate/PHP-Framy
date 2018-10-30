<?php
namespace Framy\MySQL;

class Config {

    private $host;
    private $name;
    private $user;
    private $password;
    public function __construct() {

        $this->host = 'localhost';
        $this->name = '';
        $this->user = 'root';
        $this->password = '';
    }

    public function getHost() {
        return $this->host;
    }

    public function getName() {
        return $this->name;
    }

    public function getUser() {
        return $this->user;
    }

    public function getPassword() {
        return $this->password;
    }
}