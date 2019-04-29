<?php

namespace Framework;


/**
 * Class Model
 * @package Application\Model
 */
abstract class Model
{
    /**
     * @return array
     */
    public abstract static function getColumn();

    /**
     * @return mixed
     */
    public abstract static function getManager();

    /**
     * @param array $data
     * @return mixed
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            if ($this->getColumnIndex($key) == 'id'){
                $this->setPrimaryKey($value);
            }
                $error[$key] = $this->validation($value, $key);
                $method = 'set' . ucfirst($this::getColumn()['column'][$this->getColumnIndex($key)]['index']);
                if (method_exists($this, $method)) {
                    $this->$method($this->formatData($value, $this::getColumn()['column'][$this->getColumnIndex($key)]['type']));
            }
        }
        return $error;
    }

    /**Permet de déterminer si la valeur remplie la conditions du champs de la table
     * @param $value
     * @param $key
     * @return mixed
     */
    public function validation($value, $key)
    {
        $indexTable = $this->getColumnIndex($key);
        $message = '';
        foreach ( $this::getColumn()['column'][$indexTable]['condition'] as $condition) {
            switch ($condition){
                case 'not null':
                    if ($value == null){
                        $message =  'Merci de remplir ce champ' . $message;
                    }
                    break;
                case 'max char 10':
                    if (strlen($value) > 10){
                        $message = $message . ' Maximum 10 charactères ';
                    }
                    break;
                case 'max char 30':
                    if (strlen($value) > 30){
                        $message = $message . ' Maximum 30 charactères ';
                    }
                    break;
                case 'max char 250':
                    if (strlen($value) > 250){
                        $message = $message . ' Maximum 250 charactères ';
                    }
                    break;
            }
        }
        return $message;
    }

    /**Formate les données dans le type correspondant à la colonne
     * @param $columnData
     * @param $type
     * @return \DateTime|false|int|string
     */
    protected function formatData($columnData, $type)
    {

        switch ($type){
            case 'integer':
                $columnData = (int)$columnData;
                break;
            case 'string':
                $columnData =  (string)$columnData;
                break;
            case 'boolean':
                if ($columnData !== 0 or $columnData !== 1){
                    $columnData = 0;
                }
                break;
        }
        return $columnData;
    }

    /**Permet de récupérer l'index de la colonne associé à la variable
     * @param $variable
     * @return int|string
     */
    public function getColumnIndex($variable)
    {
        foreach ($this::getColumn()['column'] as $key => $value)
        {
            if ($value['index'] == $variable ){
                return $key;
            }
        }
    }

    /**Permet de récupérer une donnée d'une column
     * @param $column
     * @return string
     */
    public function getColumnsData($column)
    {
        $method = 'get' . ucfirst($this::getColumn()['column'][$column]['index']);
        return $this->$method();
    }

    /**
     * @return mixed
     */
    public function getPrimaryKey()
    {
        $primaryKey = $this::getColumn()['primaryKey']['index'];
        $method = 'get' . ucfirst($primaryKey);
        return $this->$method();
    }

    /**
     * @param $value
     */
    public function setPrimaryKey($value)
    {
        $primaryKey = $this::getColumn()['primaryKey']['index'];
        $method = 'set' . ucfirst($primaryKey);
        $this->$method($this->formatData($value, $this::getColumn()['primaryKey']['type']));
    }
}