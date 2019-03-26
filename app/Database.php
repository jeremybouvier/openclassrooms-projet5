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
    private function getPDO()
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


    /**Envoi d'une requète simple vers la base de donnée
     * @param $statement
     * @param $className
     * @return array
     */
    public function query($statement, $className = '')
    {

        $req = $this->getPDO()->query($statement);
        $data = $req->fetchall(\PDO::FETCH_CLASS,$className);
        return $data;
    }


    /**Envoi d'une requète préparée vers la base de donnée
     * @param $statement
     * @param $param
     * @param $className
     * @param $fetch
     * @return array|mixed
     */

    public function prepare($statement, $param, $fetch, $className = '')
    {

        $req = $this->getPDO()->prepare($statement);
        $req->execute($param);
        $req->setFetchMode(\PDO::FETCH_CLASS,$className);

        switch ($fetch){
            case 'fetchAll':
                $data = $req->fetchAll();
                return $data;
            break;
            case 'fetch':
                $data = $req->fetch();
                return $data;
            break;
            case '':
                return null;
            break;

        }


    }


}
