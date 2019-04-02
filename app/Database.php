<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 18/02/19
 * Time: 14:19
 */

namespace Framework;



class Database
{

    private $dbName;
    private $dbUser;
    private $dbPwd;
    private $dbHost;
    private $pdo;
    private $manager = [];

    /**
     * Database constructor.
     * @param $dbName
     * @param string $dbUser
     * @param string $dbPwd
     * @param string $dbHost
     */
    public function __construct($dbName, $dbUser = 'admin', $dbPwd ='admin', $dbHost='127.0.0.1')
    {

        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPwd = $dbPwd;
        $this->dbHost = $dbHost;

    }

    /**Connexion a la base de donnés
     * @return \PDO
     */
    public function getPDO()
    {

        if ($this->pdo === null) {

            $pdo = new \PDO('mysql:dbname='.$this->dbName.';host='.$this->dbHost, $this->dbUser, $this->dbPwd, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
            $this->pdo = $pdo;
            return $pdo;

        }
        else {

            return $this->pdo;
        }
    }

    public function getManager($model, $database)
    {
        $class = new $model();
        return $class->getManager($model, $database);


    }

}
