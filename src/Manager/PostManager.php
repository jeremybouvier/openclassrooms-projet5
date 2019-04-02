<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 01/04/19
 * Time: 21:29
 */

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
        $statement =  'SELECT * FROM ' . $this->getTable() . ' ORDER BY update_date DESC';
        $req = $this->database->getPDO()->prepare($statement);
        $req->execute();
        $data = $req->fetchAll(\PDO::FETCH_CLASS, get_class($this->model));
        return $data;
    }

}