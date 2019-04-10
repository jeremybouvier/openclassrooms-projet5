<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 08/04/19
 * Time: 21:49
 */

namespace Application\Manager;


use Framework\Manager;

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
        $data = $req->fetch();
        return $data;
    }

    /**Permet de récupérer tous les posts present dans la base de donnée
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