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

    public function save($object) {
        $properties = get_object_vars($object);
        unset($properties['tableName']);

        $insertColumns = implode(", ", array_keys($properties));
        $values = array_keys($properties);

        foreach ($values as $key => $value) {
            $values[$key] = ':' . $value;
        }

        $formattedValues = implode(", ", $values);
        $insertExecute = $this->insert($insertColumns, $formattedValues, $properties);

        return $insertExecute;
    }
}