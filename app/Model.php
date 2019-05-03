<?php

namespace Framework;


/**
 * Class Model
 * @package Application\Model
 */
abstract class Model
{
    private $message;
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
        $this->message = '';
        foreach ( $this::getColumn()['column'][$indexTable]['condition'] as $condition) {
            $this->$condition($value);
        }
        return $this->message;
    }

    /**Permet d'enregistrer le message d'erreur pour notNull
     * @param $value
     */
    private  function notNull($value)
    {
        if ($value == null){
            $this->message =  'Merci de remplir ce champ' . $this->message;
        }
    }

    /**Permet d'enregistrer le message d'erreur pour maxChar10
     * @param $value
     */
    private  function maxChar10($value)
    {
        if (strlen($value) > 10){
            $this->message = $this->message . ' Maximum 10 charactères ';
        }
    }

    /**Permet d'enregistrer le message d'erreur pour maxChar30
     * @param $value
     */
    private  function maxChar30($value)
    {
        if (strlen($value) > 30){
            $this->message = $this->message . ' Maximum 30 charactères ';
        }
    }

    /**Permet d'enregistrer le message d'erreur pour maxChar300
     * @param $value
     */
    private  function maxChar300($value)
    {
        if (strlen($value) > 300){
            $this->message = $this->message . ' Maximum 300 charactères ';
        }
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