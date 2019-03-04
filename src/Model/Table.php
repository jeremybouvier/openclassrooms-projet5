<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 04/03/19
 * Time: 21:07
 */

namespace Application\Model;

use Application\App;


class Table
{
    protected static $table;


    public function getAll()
    {

         return App::getDB()->query("SELECT * FROM " . self::getTable(),__CLASS__);

    }

    private static function getTable()
    {
        if (self::$table === null){

            $className = explode('\\',get_called_class());

            self::$table = strtolower(end($className));

        }
        return self::$table;
    }


    public function __get($key)
    {
        $method = 'get'. ucfirst($key);
        $this->$key = $this->$method();
        return $this->$key;
    }
}