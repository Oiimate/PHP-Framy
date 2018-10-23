<?php
namespace Framy\Models;

class Builder {

    private $select;
    private $from;
    private $where;

    public function __construct($tableName) {
        $this->from = $tableName;
    }

    public function select(... $select) {
        $this->select = implode(" ", $select);
    }

    public function where(array $where) {
        $this->where = $where;
    }

    public function query() {
    }
}