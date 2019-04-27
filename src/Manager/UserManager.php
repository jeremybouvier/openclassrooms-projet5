<?php

namespace Application\Manager;


use Framework\Manager;

/**
 * Class UserManager
 * @package Application\Manager
 */
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
        return $req->fetchAll(\PDO::FETCH_CLASS, get_class($this->model));
    }

    /**Permet de récupérer un lot de donnée d'une table correspondant aux critères
     * @param $filters
     * @return mixed
     */
    public function getOneBy($filters)
    {
        $statement = 'SELECT * FROM ' . $this->table . $this->where($filters) . ' LIMIT 0,1';
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute($filters);
        $req->setFetchMode(\PDO::FETCH_CLASS, get_class($this->model));
        return $req->fetch();
    }
}