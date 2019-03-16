<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 04/03/19
 * Time: 21:07
 */

namespace Application\Model;

use Framework\App;


class Table
{
    protected static $table;


    /**Permet de réupérer tous les éléments d'une table
     * @return array
     */
    public static function getAll()
    {
        $className = get_called_class();

        return App::getDB()->query("SELECT * FROM " . static ::getTable(), $className);

    }


    /**Permet récupérer un ou plusieurs éléments d'une table selon les paramètres
     * @param $param
     * @param $fetch
     * @return array|mixed
     */
    public static function getSingle($param,$fetch)
    {
        $key = key($param);
        $className = get_called_class();
        return App::getDB()->prepare(
            "SELECT * FROM " . static::getTable().
            " WHERE ". $key . "=:" . $key, [':'.$key=>$param[$key]], $className,$fetch);
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