<?php

namespace Framework;


class App{

    const DB_NAME = 'blog';
    const DB_USER = 'admin';
    const DB_PWD  = 'admin';
    const DB_HOST = '127.0.0.1';

    private  $database;

    public function getDB(){
        if ($this->database === null) {

            $this->database = new Database(self::DB_NAME, self::DB_USER, self::DB_PWD, self::DB_HOST);
        }

        return $this->database;
    }

}
?>