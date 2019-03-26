<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 04/03/19
 * Time: 21:07
 */

namespace Application\Model;


class Table
{
    protected $table;
    protected $indexColumn;
    private $columnsData;





    /**Permet de réupérer tous les éléments d'une table
     * @param $database
     * @return mixed
     */
    public function getAll($database)
    {

        return $database->query("SELECT * FROM " . $this->getTable(), get_called_class());

    }


    /**Permet récupérer un ou plusieurs éléments d'une table selon les paramètres
     * @param $param
     * @param $fetch
     * @return array|mixed
     */
    public function getSingle($param, $orderKey, $fetch, $database)
    {
        $key = key($param);


        return $database->prepare(
            "SELECT * FROM " . $this->getTable().
            " WHERE ". $key . "=:" . $key . $this->orderBy($orderKey), [':'.$key=>$param[$key]], $fetch, get_called_class());
    }

    /**Permet d'inserer un éléments dans la base de donnée
     * @param $param
     * @param $database
     * @return null
     */
    public function AddSingle( $fetch, $database)
    {

       $database->prepare("INSERT INTO " . $this->getTable() .  $this->getInsertEntry()
       , $this->getColumnsData() , $fetch);
       return null;
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


    private function getInsertEntry()
    {
        $statement = '';
        $bindParam = '';

        foreach ($this->indexColumn as $key =>$value){
            $statement = $key . ',' . $statement;
            $bindParam = ':' . $key . ',' . $bindParam;
        }
        $statement = ' (' . substr($statement,0,-1) . ')';
        $bindParam = '(' . substr($bindParam,0,-1) . ')';

        return $statement . ' VALUES ' . $bindParam;
    }

    private function getColumnsData()
    {
        foreach ($this->indexColumn as $key => $value){

            $method = 'get' . ucfirst($value['variable']);
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

    private function orderBy($orderKey)
    {
        if ($orderKey != null){
            return ' ORDER BY '. $orderKey .' DESC';
        }
        return null;
    }

    private function where($filter)
    {
        $condition ='';
        foreach ($filter as $key => $value){
                $index = $this-> getIndexColumn($key);
                $condition = $index . ':=' . $index . ' AND ';
        }
        var_dump($condition);
        return ' WHERE '. substr($condition, 0, -5);
    }

    private function getIndexColumn($variable)
    {

        foreach ($this->indexColumn as $key => $value){
            if ($value['variable'] == $variable){
                $result = $key;
            }
        }
        return $result;

    }

    private function getPdoParam($param)
    {
        foreach ($param as $key => $value){
            $index = $this-> getIndexColumn($key);
            $pdoParam[':'.$index] = $value;
        }

        return $pdoParam;
    }



}