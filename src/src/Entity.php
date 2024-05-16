<?php

declare(strict_types=1);

namespace src;

use Exception;

abstract class Entity
{
    protected $db_conn;
    protected $tableName;
    protected $fields;
    protected $primaryKeys = ['id'];
    public $lastInsertedId;

    abstract protected function initFields();

    protected function __construct($connection, $tableName)
    {
        $this->db_conn = $connection;
        $this->tableName = $tableName;
        $this->initFields();
    }

    function getAll($fieldName = '', $fieldValue = '')
    {
        if ($fieldName && $fieldValue) {
            $data = $this->getData($fieldName, $fieldValue);
        } else {
            $data = $this->getData();
        }

        $objects = [];
        $className = $this::class;
        while ($objectData = $data->fetch_assoc()) {
            $object = new $className($this->db_conn);
            $object->setValues($objectData);
            $objects[] = $object;
        }

        return $objects;
    }

    function getByField($fieldName, $fieldValue)
    {
        $data = $this->getData($fieldName, $fieldValue);

        if ($objectData = $data->fetch_assoc()) {
            $this->setValues($objectData);
        }
    }

    function insert(): void
    {
        $parameterValues = [];
        $parameterTypes = '';
        foreach ($this->fields as $field) {
            $parameterValues[] = $this->$field;
            $parameterTypes .= self::getType($this->$field);
        }

        $fieldNamesString = implode(', ', $this->fields);
        $parameters = implode(', ', array_fill(0, count($this->fields), '?'));
        $sql = "INSERT INTO $this->tableName ($fieldNamesString) VALUES ($parameters)";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->bind_param($parameterTypes, ...$parameterValues);
        $stmt->execute();
        $this->lastInsertedId = $this->db_conn->insert_id;
    }

    function update()
    {
        $fieldBindings = [];
        $keyBindings = [];
        $parameterValues = [];
        $parameterTypes = '';

        foreach ($this->fields as $field) {
            $fieldBindings[] = $field . ' = ?';
            $parameterValues[] = $this->$field;
            $parameterTypes .= self::getType($this->$field);
        }

        foreach ($this->primaryKeys as $key) {
            $keyBindings[] = $key . ' = ?';
            $parameterValues[] = $this->$key;
            $parameterTypes .= self::getType($this->$key);
        }

        $fieldBindingsString = join(', ', $fieldBindings);
        $keyBindingsString = join(', ', $keyBindings);
        $sql = "UPDATE $this->tableName SET $fieldBindingsString WHERE $keyBindingsString";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->bind_param($parameterTypes, ...$parameterValues);
        $stmt->execute();
    }

    function delete(): void
    {
        $keyBindings = [];
        $parameterValues = [];
        $parameterTypes = '';

        foreach ($this->primaryKeys as $key) {
            $keyBindings[] = $key . ' = ?';
            $parameterValues[] = $this->$key;
            $parameterTypes .= self::getType($this->$key);
        }

        $keyBindingsString = join(' AND ', $keyBindings);
        $sql = "DELETE FROM $this->tableName WHERE $keyBindingsString";
        $stmt = $this->db_conn->prepare($sql);
        $stmt->bind_param($parameterTypes, ...$parameterValues);
        $stmt->execute();
    }

    function filter($fields)
    {
        throw new Exception('Not implemented');
    }

    private function getData($fieldName = '', $fieldValue = '')
    {
        $sql = "SELECT * FROM $this->tableName";

        if ($fieldName) {
            $sql .= " WHERE $fieldName = ?";
        }

        $stmt = $this->db_conn->prepare($sql);

        if ($fieldValue) {
            $stmt->bind_param("s", $fieldValue);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function setValues($values, $object = null)
    {
        if ($object === null) {
            $object = $this;
        }

        foreach ($object->primaryKeys as $keyName) {
            if (isset($values[$keyName])) {
                $object->$keyName = $values[$keyName];
            }
        }

        foreach ($object->fields as $fieldName) {
            if (isset($values[$fieldName])) {
                $object->$fieldName = $values[$fieldName];
            }
        }
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->fields) || in_array($name, $this->primaryKeys)) {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        if (in_array($name, $this->fields) && isset($this->$name)) {
            return $this->$name;
        }
        return null;
    }

    private static function getType($value)
    {
        if (is_int($value)) {
            return 'i';
        } elseif (is_float($value)) {
            return 'd';
        } elseif (is_string($value)) {
            return 's';
        } else {
            return 'b';
        }
    }
}
