<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 09/04/19
 * Time: 13:49
 */

namespace Application\Manager;


use Framework\Manager;

class UserManager extends Manager
{

    /**Permet de récupérer tous les utilisateur present dans la base de donnée
     * @return Post
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