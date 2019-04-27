<?php

namespace Application\Manager;


use Framework\Manager;

/**
 * Class CategoryManager
 * @package Application\Manager
 */
class CategoryManager extends Manager
{
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