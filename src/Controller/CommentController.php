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
        $comment = new Comment();
        $data = $comment->getAllByKeys(['post_id'=>$id], 'id', $this->database);
        return $data;
    }

    /**Permet d'ajouter un nouveau commentaire
     * @param $id
     * @return mixed
     */
    public function addComment($id)
    {
        $result = $this->request->getPost();
        $comment = new Comment();
        $comment->hydrate($result);
        $comment->setPostId($id);
        $comment->insertInto($this->database);

        $response = $this->route->redirect($this->route->getUrl(),302);
        return $response;
    }

    public function deleteComment($id,$idComment)
    {
        $comment = new Comment();
        $comment->delete(['id'=>$idComment], $this->database);

        $response = $this->route->redirect('/post/'.$id,302);
        return $response;
    }


}