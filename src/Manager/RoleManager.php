<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 16/04/19
 * Time: 21:38
 */

namespace Application\Manager;


use Framework\Manager;

/**
 * Class RoleManager
 * @package Application\Manager
 */
class RoleManager extends Manager
{
    /**Permet de récupérer tous les posts present dans la base de donnée
     * @return mixed
     */
    public function getAll()
    {
        $statement =  'SELECT * FROM ' . $this->table . ' ORDER BY id ASC';
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute();
        $data = $req->fetchAll(\PDO::FETCH_CLASS, get_class($this->model));
        return $data;
    }

}