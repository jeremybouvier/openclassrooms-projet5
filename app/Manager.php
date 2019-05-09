<?php

namespace Framework;


/**
 * Class Manager
 * @package Application\Manager
 */
abstract class Manager
{
    /**
     * @var mixed
     */
    protected $table;

    /**
     * @var
     */
    protected $database;

    /**
     * @var
     */
    protected $model;

    /**
     * @var
     */
    protected $indexColumn;

    /**
     * @var
     */
    protected $columnsData;

    /**
     * Manager constructor.
     * @param $model
     * @param $database
     */
    public function __construct($model, $database)
    {
        $this->database = $database;
        $this->indexColumn = $model::getColumn();
        $this->model = $model;
        $this->table = $this->model::getColumn()['table'];
    }

    /**Permet de récupérer un lot de donnée d'une table correspondant aux critères
     * @param $filters
     * @return mixed
     */
    public function fetch($filters)
    {
        $statement = 'SELECT * FROM ' . $this->table . $this->where($filters) . ' LIMIT 0,1';
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute($filters);
        $req->setFetchMode(\PDO::FETCH_CLASS, get_class($this->model));
        return $req->fetch();
    }

    /**Permet de récupérer tous les lots de donnée d'une table correspondant aux critères
     * @param $filters
     * @param $orderKeys
     * @param null $length
     * @param null $start
     * @return mixed
     */
    public function fetchAll($filters, $orderKeys, $length = null, $start = null)
    {
        $statement = 'SELECT * FROM ' . $this->table . $this->where($filters) . $this->order($orderKeys) .
            $this->limit($length, $start);
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute($filters);
        $req->setFetchMode(\PDO::FETCH_CLASS, get_class($this->model));
        return $req->fetchAll();
    }

    public function edit($model, $filter){
        if($model->getPrimaryKey()) {
            $this->update($model, $filter);
        }else{
            $this->insert($model);
        }
    }

    /**Permet d'inserer un lot de donnée dans une table
     * @param $model
     */
    public function insert($model)
    {
        $pdoParam = [];
        $set = '';
        foreach ($model::getColumn()['column'] as $column => $value)
        {
            $sqlValue = $model->getColumnsData($column);
            $set = $column . '=:'. $column . ', ' . $set;
            $pdoParam[$column] = $sqlValue;
        }
        $statement = 'INSERT INTO ' . $this->table . ' SET ' . substr($set, 0,-2);
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute($pdoParam);
    }

    /**Permet de mettre à jour un lot de donnée dans une table
     * @param $model
     * @param $filters
     */
    public function update($model, $filters)
    {
        $pdoParam = [];
        $set = '';
        foreach ($model::getColumn()['column'] as $column => $value)
        {
            $sqlValue = $model->getColumnsData($column);
            $set = $column . '=:'. $column . ', ' . $set;
            $pdoParam[$column] = $sqlValue;
        }
        foreach ($filters as $key =>$value){
            $pdoParam[$key] = $value;
        }
        $statement = 'UPDATE ' . $this->table . ' SET ' . substr($set, 0,-2) . $this->where($filters);
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute($pdoParam);
    }

    /**Supprime des données d'une table
     * @param $filters
     */
    public function delete($filters)
    {
        $statement = 'DELETE FROM ' . $this->table . $this->where($filters);
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute($filters);
    }

    /**Renvoi l'écriture SQL pour une condition dans la requète
     * @param array $filters
     * @return string
     */
    protected function where($filters = [])
    {
        if (!empty($filters)){
            $string = '';
            foreach ($filters as $key => $value){
                $string = $key . '=:' . $key . ' AND ' . $string ;
            }
            return ' WHERE ' . substr($string,0,-5) ;
        }
        return '';
    }

    /**Renvoi l'écriture SQL pour l'organisation par ordre décroissant
     * @param array $orderKeys
     * @return string
     */
    protected function order($orderKeys = [])
    {
        if (isset($orderKeys)){
            $string = '';
            foreach ($orderKeys as $key){
                $string = $key . ', ' . $string ;
            }
            return ' ORDER BY ' . substr($string,0,-2) . ' DESC ';
        }
        return '';
    }

    /**Renvoi l'ecriture sql de la limit de donnée à recupérer
     * @param $length
     * @param $start
     * @return string
     */
    protected function limit($length, $start)
    {
        if ($length !== null){
            if ($start !== null){
                return ' LIMIT ' . $start . ', ' . $length;
            }
            return ' LIMIT ' . $length;
        }
        return '';
    }

}