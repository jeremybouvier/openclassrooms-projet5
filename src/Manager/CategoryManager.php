<?php

namespace Application\Manager;


use Framework\Manager;

/**
 * Class CategoryManager
 * @package Application\Manager
 */
class CategoryManager extends Manager
{
    /**Permet de récupérer un lot de donnée d'une table correspondant aux critères
     * @param $filters
     * @return mixed
     */
    public function fetch($filters)
    {
        $statement = 'SELECT * FROM ' . $this->table . $this->where($filters) . ' LIMIT 0,1';
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute($filters);
        $req->setFetchMode(\PDO::FETCH_CLASS, get_class($this->model));
        return $req->fetch();
    }

    /**Permet de récupérer tous les categories present dans la base de donnée
     * @return mixed
     */
    public function getAll()
    {
        $statement =  'SELECT * FROM ' . $this->table . ' ORDER BY id ASC';
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute();
        return $req->fetchAll(\PDO::FETCH_CLASS, get_class($this->model));
    }
}