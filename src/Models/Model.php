<?php
namespace Framy\Models;

use Framy\MySQL\Database;

abstract class Model extends Builder {

    protected $tableName;

    public function __construct(Database $database) {
        parent::__construct($database, $this->tableName);
    }

    protected function table() {
        return $this->tableName;
    }
}