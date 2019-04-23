<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 18/02/19
 * Time: 14:19
 */

namespace Framework;


/**
 * Class Database
 * @package Framework
 */
class Database
{
    /**
     * @var
     */
    private $pdo;

    /**
     * @var
     */
    private static $databaseInstance;

    /**
     * renvoi l'instance de l'objet database
     */
    public static function getInstance()
    {
        if (self::$databaseInstance == null){
            self::$databaseInstance = new Database(
                'blog',
                'admin',
                'admin',
                '127.0.0.1'
            );
        }
        return self::$databaseInstance;
    }

    /**
     * Database constructor.
     * @param $dbName
     * @param string $dbUser
     * @param string $dbPwd
     * @param string $dbHost
     */
    public function __construct($dbName, $dbUser, $dbPwd, $dbHost)
    {
        $this->pdo = new \PDO('mysql:dbname='. $dbName .';host='. $dbHost, $dbUser, $dbPwd);
    }

    /**Connexion a la base de donnés
     * @return \PDO
     */
    public function getPDO()
    {
            return $this->pdo;
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
