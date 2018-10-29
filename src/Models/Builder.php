<?php
namespace Framy\Models;

class Builder {

    public $select;
    private $from;
    private $where;

    public function __construct($tableName) {
        $this->from = $tableName;
    }

    public function select(... $select) {
        $this->select = implode(", ", $select);
        return $this;
    }

    public function where(array $where) {
        $this->where = implode(', ', $where);
        return $this;
    }

    public function rawSql($query) {
    }

    public function get() {
        $query = null;

        if ($this->select) {
            $query .= "SELECT " . $this->select . " FROM " . $this->from;
        }

        if ($this->where) {
            $query .= " WHERE " . $this->where;
        }

        if (!$query) {
            $query .= "SELECT * FROM " . $this->from;
        }
        print_r("<br/>");
        print_r($query);
    }
}