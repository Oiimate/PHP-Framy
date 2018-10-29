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
    public function __construct(array $config)
    {
        $dbConfig = $config['db.options'];
        $this->host = $dbConfig['host'];
        $this->dbname = $dbConfig['dbname'];
        $this->user = $dbConfig['user'];
        $this->password = $dbConfig['password'];

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