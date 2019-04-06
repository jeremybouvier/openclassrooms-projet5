<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 18/02/19
 * Time: 14:19
 */

namespace Framework;


use Application\Model;

/**
 * Class Database
 * @package Framework
 */
class Database
{
    /**
     * @var
     */
    private $dbName;

    /**
     * @var string
     */
    private $dbUser;

    /**
     * @var string
     */
    private $dbPwd;

    /**
     * @var string
     */
    private $dbHost;

    /**
     * @var
     */
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

    /**Permet de récupérer le manager associé au model
     * @param $model
     * @return mixed
     */
    public function getManager($model)
    {
        return $model::getManager();
    }

}
