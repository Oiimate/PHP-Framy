<?php
namespace Framy\Models;

use Framy\MySQL\Database;

abstract class Model extends Builder {

    protected $tableName;

    /**
     * Model constructor.
     * @param Database $database
     */
    public function __construct(Database $database) {
        parent::__construct($database, $this->tableName);
    }

    /**
     * @return mixed
     */
    protected function table() {
        return $this->tableName;
    }

    /**
     * @param $object
     * @return bool
     */
    public function save($object) {
        $values = $this->readFormatProps($object);
        list($columns, $formattedValues, $filteredProperties) = $values;

        $insertExecute = $this->insert($columns, $formattedValues, $filteredProperties);

        return $insertExecute;
    }

    /**
     * @param $object
     * @return bool|Model|null|string
     */
    public function edit($object) {
        $values = $this->readFormatProps($object);
        $filteredProperties = $values[2];
        $values = null;
        $model_id = null;
        $model_id_value = null;

        foreach ($filteredProperties as $key => $value) {
            if (strpos($key, 'id') !== false) {
                $model_id = $key;
                $model_id_value = $value;
            } else {
                if (is_string($value)) {
                    $value = '"' . $value . '"';
                }
                $values[] = $key . "=" . $value;
            }
        }

        $formattedValues = implode(", ", $values);
        if ($model_id && $model_id_value) {
            $updateExecute = $this->update($formattedValues)->where(["$model_id = $model_id_value"])->get();
            print_r($updateExecute);
            return $updateExecute;
        }
        $updateExecute = $this->update($formattedValues);
        return $updateExecute;
    }

    /**
     * @param $object
     * @return array
     */
    public function readFormatProps($object) {
        $properties = get_object_vars($object);
        unset($properties['tableName']);
        $filteredProperties = array_filter($properties);

        $columns = implode(", ", array_keys($filteredProperties));
        $values = array_keys($filteredProperties);
        foreach ($values as $key => $value) {
            $values[$key] = ':' . $value;
        }

        $formattedValues = implode(", ", $values);

        return [$columns, $formattedValues, $filteredProperties];
    }
}