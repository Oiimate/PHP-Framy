<?php
namespace Framy\Models;

use Framy\MySQL\Database;

class Builder {

    public $select;
    private $from;
    private $where;
    private $db;
    private $update;
    private $join;

    public function __construct(Database $database, $tableName) {
        $this->db = $database->getConnection();
        $this->from = $tableName;
    }

    public function select(... $select) {
        $this->select = implode(", ", $select);
        return $this;
    }

    public function where(array $where, array $columns = []) {
        if ($columns) {
            $this->where = [implode(', ', $where), $columns];
            return $this;
        }
        $this->where = implode(', ', $where);
        return $this;
    }

    public function join($joinTable, $id, $joinId) {
        $this->join = "JOIN {$joinTable} ON {$this->from}.{$id} = {$joinTable}.{$joinId}";
        return $this;
    }

    public function insert($insertColumns, $values, array $columns = []) {
        $insert = "INSERT INTO {$this->from} ({$insertColumns})" . " VALUES ({$values})";
        return $this->rawSql($insert, $columns);
    }

    public function update($updateColumns, array $columns = []) {
        $update = "UPDATE {$this->from} SET {$updateColumns}";
        $this->update = $update;
        return $this;
    }

    public function query() {
        return $this->db;
    }

    public function rawSql($query, array $columns = []) {
        $result = $this->db->prepare($query);
        if ($columns) {
            $execute = $result->execute($columns);
            return $result;
        }
        $execute = $result->execute();
        return $result;
    }

    public function reset() {
        $this->select = null;
        $this->where = null;
        $this->update = null;
    }

    public function get() {
        $query = null;

        if ($this->update) {
            $query .= $this->update;
        }

        if ($this->select) {
            $query .= "SELECT " . $this->select . " FROM " . $this->from;
        }

        if ($this->join) {
            $query .= $this->join;
        }

        if (is_array($this->where)) {
            list($where, $columns) = $this->where;
            $query .= " WHERE " . $where;
            $this->reset();
            return $this->rawSql($query, $columns);
        } else if ($this->where) {
            $query .= " WHERE " . $this->where;
            print_r($query);
            $this->reset();
            return $this->rawSql($query);
        }

        if (!$query) {
            $query .= "SELECT * FROM " . $this->from;
        }
        $this->reset();
        return $this->rawSql($query);
    }
}