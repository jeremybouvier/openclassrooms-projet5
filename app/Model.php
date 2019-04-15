<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 31/03/19
 * Time: 21:27
 */

namespace Framework;


use Application\Controller\ControllerException;

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
            $indexTable = $this->getColumnIndex($key);
            if ($indexTable == 'id'){
                $this->setPrimaryKey($value);
            }
            else{
                $error[$key] = $this->validation($value, $key);
                $type = $this::getColumn()['column'][$indexTable]['type'];
                $method = 'set' . ucfirst($this::getColumn()['column'][$indexTable]['index']);
                if (method_exists($this, $method)) {
                    $this->$method($this->formatData($value, $type));
                }
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
        foreach ( $this::getColumn()['column'][$indexTable]['condition'] as $condition) {
            switch ($condition){
                case 'not null':
                    if ($value == null){
                        return 'Merci de remplir ce champ';
                    }
                    break;
                case 'max char 20':
                    if (strlen($value) > 20){
                        return 'Max 20 charactères ';
                    }
                    break;
                case 'max char 250':
                    if (strlen($value) > 250){
                        return 'Max 250 charactères ';
                    }
                    break;
            }
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
                return (int)$columnData;
                break;
            case 'string':
                return (string)$columnData;
                break;
            case 'datetime' :
                return $columnData;
                break;
            case 'boolean':
                if ($columnData == 0 or $columnData == 1){
                    return $columnData;
                }

                return  $columnData = 0;
                break;
        }
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