<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 11/02/16
 * Time: 17:40
 */

namespace Application\Manager;


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
        $this->table = $this->getTable();
    }

    /**Permet de récupérer un lot de donnée d'une table correspondant aux critères
     * @param $filters
     * @return mixed
     */
    public function fetch($filters)
    {
        $statement = 'SELECT * FROM ' . $this->getTable() . $this->where($filters) . ' LIMIT 0,1';
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute($filters);
        $req->setFetchMode(\PDO::FETCH_CLASS, get_class($this->model));
        $data = $req->fetch();
        return $data;
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
        $statement = 'SELECT * FROM ' . $this->getTable() . $this->where($filters) . $this->order($orderKeys) .
            $this->limit($length, $start);
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute($filters);
        $req->setFetchMode(\PDO::FETCH_CLASS, get_class($this->model));
        $data = $req->fetchAll();
        return $data;
    }

    /**Permet d'inserer un lot de donnée dans une table
     * @return null
     */
    public function insert()
    {
        $pdoParam = [];
        $set = '';
        foreach ($this->indexColumn['column'] as $column => $value)
        {
            $sqlValue = $this->model->getColumnsData($column);
            $set = $column . '=:'. $column . ', ' . $set;
            $pdoParam[$column] = $sqlValue;
        }
        $statement = 'INSERT INTO ' . $this->getTable() . ' SET ' . substr($set, 0,-2);
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute($pdoParam);
    }

    /**Permet de mettre à jour un lot de donnée dans une table
     * @param $filters
     * @param $entry
     * @param $database
     * @return mixed
     */
    public function update($filters)
    {
        $pdoParam = [];
        $set = '';
        foreach ($this->indexColumn['column'] as $column => $value)
        {
            $sqlValue = $this->model->getColumnsData($column);
            $set = $column . '=:'. $column . ', ' . $set;
            $pdoParam[$column] = $sqlValue;
        }
        foreach ($filters as $key =>$value){
            $pdoParam[$key] = $value;
        }
        $statement = 'UPDATE ' . $this->getTable() . ' SET ' . substr($set, 0,-2) . $this->where($filters);
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute($pdoParam);
    }

    /**Supprime des données d'une table
     * @param $filters
     */
    public function delete($filters)
    {
        $statement = 'DELETE FROM ' . $this->getTable() . $this->where($filters);
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute($filters);
    }

    /**Renvoi l'écriture SQL pour une condition dans la requète
     * @param array $filters
     * @return string
     */
    private function where($filters = [])
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
     * @param array $orderkeys
     * @return string
     */
    private function order($orderkeys = [])
    {
        if (isset($orderkeys)){
            $string = '';
            foreach ($orderkeys as $key){
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
    private function limit($length, $start)
    {
        if ($length !== null){
            if ($start !== null){
                return ' LIMIT ' . $start . ', ' . $length;
            }
            return ' LIMIT ' . $length;
        }
        return '';
    }

    /**Permet de déduire le nom de la table d'après la class appelée
     * @return mixed
     */
    protected function getTable()
    {
        $className = explode('\\',get_class($this->model));
        $table = strtolower(end($className));
        return $table ;
    }

}