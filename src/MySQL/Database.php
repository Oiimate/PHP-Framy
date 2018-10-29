<?php
namespace Framy\MySQL;

use Exception;
use PDO;

class Database
{
    private $config;
    private $connection;

    /**
     * MySQL constructor.
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config)
    {
        $this->config = $config['db.options'];
        $this->checkConfig();
    }

    /**
     * @throws Exception
     */
    private function checkConfig() {
        if (!isset($this->config['host'])) {
            throw new Exception("There is no host defined in the config");
        }

        if (!isset($this->config['dbname'])) {
            throw new Exception("There is no database name defined in the config");
        }

        if (!isset($this->config['user'])) {
            throw new Exception("There is no user defined in the config");
        }

        if (!isset($this->config['password'])) {
            throw new Exception("There is no host defined in the config");
        }
    }

    public function createConnection() {
        $connection = new PDO("mysql:host={$this->config['host']};dbname={$this->config['dbname']}", $this->config['user'], $this->config['password']);
        $this->connection = $connection;
    }

    /**
     * Get Connection.
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}