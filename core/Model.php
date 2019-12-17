<?php
namespace Core;

abstract class Model {
    protected static $tableName;
    protected static $primaryKeys;
    protected static $relations;

    public static function findBy($colNames, $values, $page, $withRelations = true) {
        if (!$colNames || is_array($values) && !$values) {
            return false;
        }
        if (!is_array($colNames)) {
            $colNames = array($colNames);
            $values = array($values);
        }
        $colNames = array_values($colNames);
        $className = get_called_class();

        $conn = DBManager::getConnection();
        $sql = 'SELECT * FROM ' . static::$tableName ;
        $sqlParams = [ ];

        $whereSql = '';
        foreach ($colNames as $key => $colName) {
            if (property_exists($className, $colName)) {
                if ($whereSql) {
                    $whereSql .= ' AND ';
                }
                if (is_array($values[$key])) {
                    $sql .= $colName . ' IN (';
                    $vars = [];
                    for ($i = 0; $i < count($values[$key]); $i++) {
                        $vars[] = '?';
                        $sqlParams[] = $values[$key][$i];
                    }
                    $whereSql .= implode(',', $vars) . ')';
                } else {
                    $whereSql .= $colName . ' = ?';
                    $sqlParams[] = $values[$key];
                }
            }
        }
        if ($whereSql) {
            $sql .= ' WHERE ' . $whereSql;
        }
        $count = DBManager::getPaginationCount();
        $page = intval($page);
        if ($page) {
            $sql .= ' LIMIT ' . $count . ' OFFSET ' . $count * ($page - 1);
        }

        $stmt = $conn->prepare($sql);

        foreach ($sqlParams as $key => $value) {
            $stmt->bindParam($key + 1, $value);
        }

        $result = $stmt->execute();
        if ($result === false) {
            return [ 'error' => 'Error handling SQL query' ];
        }

        $collection = [];
        while ($row = $stmt->fetchObject()) {
            $model = new $className();
            foreach ($row as $field => $value) {
                $model->{Utils::toCamelCase($field)} = $value;
            }
            $collection[] = $model;
        }
        if ($withRelations) {
            foreach ($collection as $model) {
                $model->loadRelations();
            }
        }
        return $collection;
    }

    protected static function findByTransition($modelName, $relation, $localValue) {
        $conn = DBManager::getConnection();

        $sql = 'SELECT ' . $modelName::$tableName . '.* FROM ' . $modelName::$tableName ;
        $transition = $relation['transition']['table'];
        $sql .= ' INNER JOIN ' . $transition . ' ON ' . $transition . '.' . $relation['to']['local'] . ' = ' . $modelName::$tableName . '.' . $relation['to']['foreign'];
        $sql .= ' WHERE ' . $transition . '.' . $relation['from']['foreign'] . ' = ?';

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(1, $localValue);

        $stmt->execute();

        $collection = [];
        while ($row = $stmt->fetchObject()) {
            $model = new $modelName();
            foreach ($row as $field => $value) {
                $model->{Utils::toCamelCase($field)} = $value;
            }
            $collection[] = $model;
        }
        return $collection;
    }

    protected function getTableFields() {
        $baseFields = array_keys(get_class_vars(self::class));
        $primaryKeys = static::$primaryKeys;
        $modelName = get_called_class();
        $relFields = array_keys($modelName::$relations);
        $modelFields = [];
        foreach(array_keys(get_class_vars($modelName)) as $name) {
            if (!in_array($name, array_merge($baseFields, $relFields, $primaryKeys))) {
                $modelFields[] = Utils::toSnakeCase($name);
            }
        }
        return $modelFields;
    }

    protected function loadRelations() {
        foreach (static::$relations as $name => $relation) {
            $relClass = $relation['namespace'] . $name;
            if ($relation['transition']) {
                $localField = $relation['from']['local'];
                $result = self::findByTransition($relClass, $relation, $this->{Utils::toCamelCase($localField)});
            } else {
                $localField = $relation['local'];
                $result = $relClass::findBy($relation['foreign'], $this->{Utils::toCamelCase($localField)}, 0, false);
            }
            if ($relation['has'] == "one" && is_array($result)) {
                $result = $result[0];
            }
            $this->$name = $result;
        }
    }

    public function getFieldType($fieldName) {
        $reflection = new \ReflectionClass(get_class($this));
        $classDocs = $reflection->getDocComment();

        if (preg_match('/@var ([\w]+) \$' . $fieldName . '/', $classDocs, $varDocs)) {
            return $varDocs[1];
        } else {
            return null;
        }
    }

    public function fromJson($data) {
        $relations = array_keys(static::$relations);
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
                $fieldType = $this->getFieldType($key);
                if ($fieldType) {
                    settype($this->$key, $fieldType);
                }
                if (in_array($key, $relations)) {
                    if (static::$relations[$key]['has'] == 'many') {
                        $this->$key = [];
                        foreach ($value as $object) {
                            $this->$key[] = $this->relFromJson(static::$relations[$key]['namespace'] . $key, $object);
                        }
                    } else {
                        $this->$key = $this->relFromJson(static::$relations[$key]['namespace'] . $key, $value);
                    }
                }
            }
        }
    }

    public function relFromJson($modelName, $data) {
        $model = new $modelName();
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $model;
    }

    public function insert() {
        $conn = DBManager::getConnection();
        $sql = "INSERT INTO " . static::$tableName;
        $columns = $this->getTableFields();
        $insertCols = [];
        $insertSql = '';
        $insertParams = [];
        foreach ($columns as $column) {
            $insertCols[] = "`".$column."`";
            if ($insertSql) {
                $insertSql .= ',';
            }
            $insertSql .= '?';
            $insertParams[] = $this->$column;
        }
        $sql .= " (" . implode(", ",$insertCols).") VALUES ($insertSql)";

        $stmt = $conn->prepare($sql);

        foreach ($insertParams as $key => $value) {
            $stmt->bindParam($key + 1, $value);
        }

        $result = $stmt->execute();
        if ($result === false) {
            return [ 'error' => 'Error handling SQL query' ];
        }

        return $result;
    }

    public function update() {
        $conn = DBManager::getConnection();
        $ids = static::$primaryKeys;
        foreach ($ids as $id) {
            if (!isset($this->$id) || empty($this->$id)) {
                return [ 'error' => 'Update error: missing primary key ' . $id ];
            }
        }

        $sql = "UPDATE " . static::$tableName . " SET ";
        $columns = $this->getTableFields();
        $updateSql = [];
        $updateParams = [];

        foreach ($columns as $column) {
            $updateSql[] = "`" . $column . "` = ?";
            $updateParams[] = $this->$column;
        }
        $whereSql = [];
        $whereParams = [];
        foreach ($ids as $id) {
            $whereSql[] = "`" . $id . "` = ?";
            $whereParams[] = $this->$id;
        }
        $sql .= implode(", ", $updateSql);
        $sql .= ' WHERE ' . implode(", ", $whereSql);

        $stmt = $conn->prepare($sql);

        foreach (array_merge($updateParams, $whereParams) as $key => $value) {
            $stmt->bindParam($key + 1, $value);
        }

        $result = $stmt->execute();
        if ($result === false) {
            return [ 'error' => 'Error handling SQL query' ];
        }
        return $result;
    }

    public function delete() {
        $conn = DBManager::getConnection();

        $ids = static::$primaryKeys;
        foreach ($ids as $id) {
            if (!isset($this->$id) || empty($this->$id)) {
                return [ 'error' => 'Delete error: missing primary key ' . $id ];
            }
        }

        $sql = "DELETE FROM " . static::$tableName;
        $whereSql = [];
        $whereParams = [];

        foreach ($ids as $id) {
            $whereSql[] = "`" . $id . "` = ?";
            $whereParams[] = $this->$id;
        }

        $sql .= ' WHERE ' . implode(", ", $whereSql);

        $stmt = $conn->prepare($sql);
        foreach ($whereParams as $key => $value) {
            $stmt->bindParam($key + 1, $value);
        }

        $result = $stmt->execute();
        if ($result === false) {
            return [ 'error' => 'Error handling SQL query' ];
        }
    }
}