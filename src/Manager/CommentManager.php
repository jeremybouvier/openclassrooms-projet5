<?php

namespace Application\Manager;

use Framework\Manager;

/**
 * Class CommentManager
 * @package Application\Manager
 */
class CommentManager extends Manager
{
    /**Permet de récupérer tous les posts present dans la base de donnée
     * @return Post
     */
    public function getAll()
    {
        $statement = 'SELECT * FROM ' . $this->table . ' ORDER BY update_date DESC';
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute();
        return $req->fetchall(\PDO::FETCH_CLASS, get_class($this->model));
    }
}