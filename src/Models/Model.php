<?php
namespace Framy\Models;

abstract class Model extends Builder {

    protected $tableName;

    public function __construct() {
        parent::__construct($this->tableName);
    }

    protected function table() {
        return $this->tableName;
    }
}