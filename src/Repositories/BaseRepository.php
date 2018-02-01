<?php

namespace Chat\Repositories;

use Chat\Entities\Entity;

abstract class BaseRepository
{
    /** @var null|\PDO $connection */
    protected static $connection = null;
    /** @var string $table */
    protected $table;
    /** @var string $class */
    protected $class;

    public function __construct($class)
    {
        self::getDBInstance();
        $this->table = $this->getTableName();
        $this->class = $class;
    }

    /**
     * @return \PDO
     */
    public static function getDBInstance()
    {
        if (!isset(self::$connection)) {
            try {
                $config = \Config::getDbConfig();
                self::$connection = new \PDO($config['db_dsn'], $config['db_user'], $config['db_pwd']);

            } catch (\PDOException $e) {

                echo 'Connection failed: '.$e->getMessage();
                die;
            }
        }

        return self::$connection;
    }

    public function add(Entity $entity)
    {
        $statement = "INSERT INTO {$this->table}(";
        $statementValues = [];
        $statementNames = [];
        $values = [];

        foreach ($entity->toArray() as $fieldName => $fieldValue) {
            $statementNames[] = $fieldName;
            $statementValues[] = "?";
            $values[] = $fieldValue;
        }

        $statement .= implode(',', $statementNames).') VALUES('.implode(',', $statementValues).')';
        $query = self::getDBInstance()->prepare($statement);
        $result = $query->execute($values);

        if ($result) {
            $id = self::getDBInstance()->lastInsertId();
            $entity->setId($id);

            return $id;
        } else {
            var_dump( $query->errorInfo());
            die;
        }

    }

    public function delete(Entity $entity)
    {
        $statement = "DELETE FROM {$this->table} WHERE id = ?";
        $query = self::getDBInstance()->prepare($statement);
        $query->execute($entity->getId());
    }

    public function update(Entity $entity)
    {
        $statement = "UPDATE {$this->table} SET (";
        $values = [];

        if (!empty($entity->toArray())) {
            $statementPieces = [];
            foreach ($entity->toArray() as $fieldName => $fieldValue) {
                $statementPieces = "$fieldName = ? ";
                $values[] = $fieldValue;
            }
            $statement .= implode(',', $statementPieces);
        }

        $statement .= " WHERE id = ?";
        $query = self::getDBInstance()->prepare($statement);
        $query->execute($values);
    }

    public function findOne(array $fields = [],$sort=['id'=>'desc'])
    {
        $query = $this->findBy($fields,$sort);
        $result = $query->fetch();
        if($result){
            $entity="Chat\Entities\\".ucfirst($this->class);
            /**@var Entity $entity */
            $entity = new $entity($result);

            return $entity;
        }
        return null;

    }

    public function findAll(array $fields = [],$sort=['id'=>'desc'],$type='object')
    {
        $arrayResult = [];

        $query = $this->findBy($fields,$sort);
        $result = $query->fetchAll();

        if('object'===$type){
            // hydrate the result to an array //
            foreach ($result as $element) {
                $entity="Chat\Entities\\".ucfirst($this->class);
                $arrayResult[] = new $entity($element);
            }
            $result=$arrayResult;
        }

        return $result;
    }

    protected function findBy(array $fields = [],$sort=['id'=>'desc'])
    {
        $searchValues = [];

        $statement = "SELECT * FROM {$this->table}";

        if (!empty($fields)) {
            $statement .= ' where 1=1 ';
            foreach ($fields as $fieldName => $fieldValue) {
                $statement .= "AND $fieldName = ? ";
                $searchValues[] = $fieldValue;
            }
        }
        if(!empty($sort)){
            $statement .= ' order by  ';
            foreach ($sort as $key=>$value){

                $statement.="$key $value";
            }
        }

        $query = self::getDBInstance()->prepare($statement);
        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $result=$query->execute($searchValues);

        if ($result) {
            return $query;
        } else {
            var_dump( $query->errorInfo());
            die;
        }

    }

    public abstract function getTableName();

}