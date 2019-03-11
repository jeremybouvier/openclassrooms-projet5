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


    public static function getAll()
    {
        $className = get_called_class();
         return App::getDB()->query("SELECT * FROM " . static::getTable(), $className);

    }

    public static function getSingle($id)
    {
        $className = get_called_class();
        return App::getDB()->prepare("SELECT * FROM " . static::getTable(), [':id' => $id], $className);
    }

    private static function getTable()
    {
        if (static::$table === null){

            $className = explode('\\',get_called_class());

            static::$table = strtolower(end($className));

        }
        return static::$table;
    }


    public function __get($key)
    {
        $method = 'get'. ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }
}