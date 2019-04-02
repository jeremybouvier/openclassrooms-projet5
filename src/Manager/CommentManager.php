<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 02/04/19
 * Time: 15:20
 */

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
        $statement = 'SELECT * FROM ' . $this->getTable() . ' ORDER BY update_date DESC';
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute();
        $data = $req->fetchall(\PDO::FETCH_CLASS, get_class($this->model));
        return $data;
    }
}