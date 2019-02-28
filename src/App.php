<?php

namespace Application;

use \Application\Model\Database;

class App{

    const DB_NAME = 'blog';
    const DB_USER = 'admin';
    const DB_PWD  = 'admin';
    const DB_HOST = '127.0.0.1';

    private static $database;

    public static function getDB(){
        if (self::$database === null) {

            self::$database = new Database(self::DB_NAME, self::DB_USER, self::DB_PWD, self::DB_HOST);
        }

        return self::$database;
    }

}
?>