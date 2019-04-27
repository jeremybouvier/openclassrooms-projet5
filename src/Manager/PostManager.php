<?php

namespace Application\Manager;


use Application\Model\Post;
use Framework\Manager;

/**
 * Class PostManager
 * @package Application\Manager
 */
class PostManager extends Manager
{

    /**Permet de récupérer tous les posts present dans la base de donnée
     * @return Post
     */
    public function getAll()
    {
        $statement =  'SELECT * FROM ' . $this->table . ' ORDER BY update_date DESC';
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute();
        return $req->fetchAll(\PDO::FETCH_CLASS, get_class($this->model));
    }

}