<?php
namespace Framy\Models;

use Framy\MySQL\Database;

class Builder {

    public $select;
    private $from;
    private $where;
    private $db;

    public function __construct(Database $database, $tableName) {
        $this->db = $database;
        $this->from = $tableName;

        print_r($this->db->getConnection());
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
        return $query;
    }
}