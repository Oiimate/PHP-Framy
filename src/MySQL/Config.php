<?php
namespace Framy\MySQL;

class Config {

    private $host;
    private $name;
    private $user;
    private $password;

    /**
     * Config constructor.
     */
    public function __construct() {

        $this->host = 'localhost';
        $this->name = '';
        $this->user = 'root';
        $this->password = '';
    }

    /**
     * @return string
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }
}