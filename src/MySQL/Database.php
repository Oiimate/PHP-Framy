<?php
namespace Framy\MySQL;

use Exception;
use PDO;

class Database
{
    private $connection;
    private $host;
    private $dbname;
    private $user;
    private $password;

    /**
     * MySQL constructor.
     * @param array $config
     * @throws Exception
     */
    public function __construct(Config $config)
    {
        $this->host = $config->getHost();
        $this->dbname = $config->getName();
        $this->user = $config->getUser();
        $this->password = $config->getPassword();

        $this->checkConfig();
    }

    /**
     * @throws Exception
     */
    private function checkConfig() {
        if (!isset($this->host)) {
            throw new Exception("There is no host defined in the config");
        }

        if (!isset($this->dbname)) {
            throw new Exception("There is no database name defined in the config");
        }

        if (!isset($this->user)) {
            throw new Exception("There is no user defined in the config");
        }

        if (!isset($this->password)) {
            throw new Exception("There is no host defined in the config");
        }
    }

    public function createConnection() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
        $connection = new PDO($dsn, $this->user, $this->password);
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