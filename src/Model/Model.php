<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 31/03/19
 * Time: 21:27
 */

namespace Application\Model;


/**
 * Class Model
 * @package Application\Model
 */
abstract class Model
{
    /**
     * @var
     */
    public $originalData;

    /**
     * @return array
     */
    public abstract static function getColumn();

    /**
     * @param $model
     * @return mixed
     */
    public abstract static function getManager();

    /**Hydration de la class
     * @param array $data
     */
    public function hydrate(array $data)
    {
        $this->originalData = $data;


        foreach ($data as $key => $value) {

            $indexTable = $this->getColumnIndex($key);
            if ($indexTable == 'id'){
                $this->setPrimaryKey($value);
            }
            else{
                $type = $this::getColumn()['column'][$indexTable]['type'];
                $method = 'set' . ucfirst($this::getColumn()['column'][$indexTable]['index']);
                if (method_exists($this, $method)) {
                    $this->$method($this->formatData($value, $type));
                }
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

        }
    }

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

    public function getPrimaryKey()
    {
        $primaryKey = $this::getColumn()['primaryKey']['index'];
        $method = 'get' . ucfirst($primaryKey);
        return $method();
    }

    public function setPrimaryKey($value)
    {
        $primaryKey = $this::getColumn()['primaryKey']['index'];
        $method = 'set' . ucfirst($primaryKey);
        $this->$method($this->formatData($value, $this::getColumn()['primaryKey']['type']));
    }
}