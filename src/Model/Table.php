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
    protected static $table;


    /**Permet de réupérer tous les éléments d'une table
     * @param $database
     * @return mixed
     */
    public static function getAll($database)
    {
        $className = get_called_class();

        return $database->query("SELECT * FROM " . static ::getTable(), $className);

    }


    /**Permet récupérer un ou plusieurs éléments d'une table selon les paramètres
     * @param $param
     * @param $fetch
     * @return array|mixed
     */
    public static function getSingle($param, $order, $fetch, $database)
    {
        $key = key($param);
        $className = get_called_class();

        if ($order != null){
            $order = ' ORDER BY '. $order .' DESC';
        }

        return $database->prepare(
            "SELECT * FROM " . static::getTable().
            " WHERE ". $key . "=:" . $key . $order, [':'.$key=>$param[$key]], $className,$fetch);
    }

    /**Permet d'inserer un éléments dans la base de donnée
     * @param $param
     * @param $database
     * @return null
     */
    public static function AddSingle($param, $database)
    {
       $entry = '';
       $bindParam = '';

        foreach ($param as $key=>$value){

           $bindParam = ':'.$key. ','. $bindParam;
           $pdoParam[':'.$key] = $value;
           $entry = $key . ', ' . $entry  ;

       }
        $entry = '('. substr($entry,0,-2) . ')';
        $bindParam = substr($bindParam,0,-1);

       $database->insert(    "INSERT INTO " . static::getTable() ." ".  $entry
                                        ." VALUES (" . $bindParam .")", $pdoParam);
       return null;
    }


    /**Permet de déduire le nom de la table d'après la class appelée
     * @return mixed
     */
    private static function getTable()
    {
        $className = explode('\\',get_called_class());
        static::$table = strtolower(end($className));

        return static::$table;
    }


}