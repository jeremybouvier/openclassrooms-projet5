<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 18/03/19
 * Time: 13:54
 */

namespace Application\Controller;

use Application\Model\Comment;
use Framework\Controller;


class CommentController extends Controller
{
    /**récupère tous les commentaires d'un post
     * @param $id
     * @return array|mixed
     */
    public function getAllComment($id)
    {
        $data = Comment::getSingle(['post_id'=>$id],'id','fetchAll', $this->database);
        return $data;
    }

    /**Permet d'ajouter un nouveau commentaire
     * @param $id
     * @return mixed
     */
    public function addComment($id)
    {
        $pdoParam = $this->request->getPost();
        $pdoParam['post_id'] = (int)$id;
        Comment::addSingle($pdoParam, $this->database);

        $response = $this->route->redirect($this->route->getUrl(),302);
        return $response;
    }
}