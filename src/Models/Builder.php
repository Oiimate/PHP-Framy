<?php
namespace Framy\Models;

use Framy\MySQL\Database;

class Builder {

    private $select;
    private $from;
    private $where;
    private $db;
    private $update;
    private $join;

    /**
     * Builder constructor.
     * @param Database $database
     * @param $tableName
     */
    public function __construct(Database $database, $tableName) {
        $this->db = $database->getConnection();
        $this->from = $tableName;
    }

    /**
     * @param mixed ...$select
     * @return $this
     */
    public function select(... $select) {
        $this->select = implode(", ", $select);
        return $this;
    }

    /**
     * @param array $where
     * @param array $columns
     * @return $this
     */
    public function where(array $where, array $columns = []) {
        if ($columns) {
            $this->where = [implode(', ', $where), $columns];
            return $this;
        }
        $this->where = implode(', ', $where);
        return $this;
    }

    /**
     * @param $joinTable
     * @param $id
     * @param $joinId
     * @return $this
     */
    public function join($joinTable, $id, $joinId) {
        $this->join = "JOIN {$joinTable} ON {$this->from}.{$id} = {$joinTable}.{$joinId}";
        return $this;
    }

    /**
     * @param $insertColumns
     * @param $values
     * @param array $columns
     * @return bool
     */
    public function insert($insertColumns, $values, array $columns = []) {
        $insert = "INSERT INTO {$this->from} ({$insertColumns})" . " VALUES ({$values})";
        return $this->rawSql($insert, $columns);
    }

    /**
     * @param $updateColumns
     * @return $this
     */
    public function update($updateColumns) {
        $update = "UPDATE {$this->from} SET {$updateColumns}";
        $this->update = $update;
        return $this;
    }

    /**
     * @return \PDO
     */
    public function query() {
        return $this->db;
    }

    /**
     * @param $query
     * @param array $columns
     * @return bool
     */
    public function rawSql($query, array $columns = []) {
        $result = $this->db->prepare($query);
        if ($columns) {
            $execute = $result->execute($columns);
            return $execute;
        }

        $execute = $result->execute();
        return $execute;
    }

    /**
     * @return bool
     */
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
            return $this->rawSql($query, $columns);
        } else if ($this->where) {
            $query .= " WHERE " . $this->where;
            return $this->rawSql($query);
        }

        if (!$query) {
            $query .= "SELECT * FROM " . $this->from;
        }
        return $this->rawSql($query);
    }
}