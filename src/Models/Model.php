<?php
namespace Framy\Models;

use Framy\Models\Builder;

abstract class Model {

    protected $tableName;

    protected function table() {
        return $this->tableName;
    }

    protected function builder() {
        return (new Builder($this->tableName));
    }
}