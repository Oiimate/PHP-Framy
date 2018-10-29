<?php
namespace Framy\Models;

abstract class Model {

    protected $tableName;

    protected function table() {
        return $this->tableName;
    }

    public function builder() {
        return (new Builder($this->tableName));
    }
}