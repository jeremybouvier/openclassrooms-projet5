<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 11/02/16
 * Time: 17:40
 */

namespace Application\Model;


class Manager
{
    private $table;
    private $indexColumn;
    private $columnsData;

    public function __construct()
    {
        $this->indexColumn = get_called_class()::getColumn();
    }

    /**Permet de récupérer tous les lots de donnée d'une table
     * @param $database
     * @return mixed
     */
    public function getAll($database)
    {
        $req = $database->getPDO()->query(
            'SELECT * FROM ' .
            $this->getTable() .
            $this->order($this->indexColumn['primaryKey']['index']));

        $data = $req->fetchall(\PDO::FETCH_CLASS, get_called_class());

        return $data;
    }

    /**Permet de récupérer un lot de donnée d'une table correspondant aux critères
     * @param $entry
     * @param $database
     * @return mixed
     */
    public function getOneByKeys($entry, $database)
    {
        $param =$this->where($entry);

        $req = $database->getPDO()->prepare(
            'SELECT * FROM ' .
            $this->getTable() .
            $param['statement']);

        $req->execute($param['pdoParam']);
        $req->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        $data = $req->fetch();

        return $data;
    }

    /**Permet de récupérer tous les lots de donnée d'une table correspondant aux critères
     * @param $filters
     * @param $database
     * @return mixed
     */
    public function getAllByKeys($filters, $database)
    {
        $param =$this->where($filters);

        $req = $database->getPDO()->prepare(
            'SELECT * FROM ' .
            $this->getTable() .
            $param['statement']);

        $req->execute($param['pdoParam']);
        $req->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        $data = $req->fetchAll();

        return $data;
    }

    /**Permet d'inserer un lot de donnée dans une table
     * @param $database
     * @return mixed
     */
    public function insertInto($database)
    {
        $req = $database->getPDO()->prepare(
            'INSERT INTO ' .
            $this->getTable() .
            $this->getInsertEntry() );

        $data = $req->execute($this->getColumnsData());

        return $data;
    }

    /**Permet de mettre à jour un lot de donnée dans une table
     * @param $filters
     * @param $entry
     * @param $database
     * @return mixed
     */
    public function update($filters, $entry, $database)
    {
        $setParam = $this->getSet($entry);
        $whereParam = $this->where($filters);
        $req = $database->getPDO()->prepare(
            'UPDATE ' .
            $this->getTable() .
            $setParam['statement']);

        $data = $req->execute($whereParam['pdoParam']);

        return $data;
    }



    /**Renvoi l'écriture SQL pour une condition dans la requète
     * @param $filters
     * @return array
     */
    private function where($filters)
    {
        $string = '';
        $param = [];

        foreach ($filters as $key => $value){
            $string = $key . '=:' . $key . ' AND ' . $string ;
        }

        foreach ($filters as $key => $value){
            $param[':' . $key] = $value;
        }

        return ['statement' => ' WHERE ' . substr($string,0,-5), 'pdoParam' => $param];
    }

    /**Renvoi l'écriture SQL pour une condition dans la requète
     * @param $entry
     * @return array
     */
    private function getSet($entry)
    {
        $statement = '';
        $param = [];

        foreach ($entry as $key =>$value) {
            $index = $this->getColumnIndex($key);
            $statement =  $index . '=:' . $index . ', ' . $statement;
            $param [':' . $index]= $value;
        }

        return ['statement' => ' SET ' . substr($statement,0,-2) ,'pdoParam' => $param ];
    }

    /**Renvoi l'écriture SQL pour l'organisation par ordre décroissant
     * @param $key
     * @return string
     */
    private function order($key)
    {
        if (isset($key)){
            return ' ORDER BY ' . $key . ' DESC ';
        }

        return '';
    }

    /**Renvoi l'écriture SQL des entrées de la table à inserer
     * @return string
     */
    private function getInsertEntry()
    {
        $statement = '';
        $bindParam = '';

        foreach ($this->indexColumn['column'] as $key =>$value){
            $statement = $key . ',' . $statement;
            $bindParam = ':' . $key . ',' . $bindParam;
        }
        $statement = ' (' . substr($statement,0,-1) . ')';
        $bindParam = '(' . substr($bindParam,0,-1) . ')';

        return $statement . ' VALUES ' . $bindParam;
    }

    /**Renvoi l'écriture SQL des données à inserer dans la table
     * @return mixed
     */
    private function getColumnsData()
    {
        foreach ($this->indexColumn['column'] as $key => $value){

            $method = 'get' . ucfirst($value['index']);
            $this->columnsData[ $key] =  $this->checkType($this->$method(), $value['type']);

        }

        return $this->columnsData;
    }

    private function checkType($columnData, $type)
    {
        switch ($type){
            case 'integer':
                return (int)$columnData;
                break;

            case 'string':
                return (string)$columnData;
                break;

        }
    }

    /**Permet de déduire le nom de la table d'après la class appelée
     * @return mixed
     */
    private function getTable()
    {
        $className = explode('\\',get_called_class());
        $this->table = strtolower(end($className));

        return $this->table ;
    }

    private function getColumnIndex($param)
    {

        foreach ($this->indexColumn['column'] as $key => $value){
            if ($value['index'] == $param){
                return $key;
            }
        }

    }
}