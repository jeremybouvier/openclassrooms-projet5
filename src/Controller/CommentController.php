<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 13/04/19
 * Time: 14:28
 */

namespace Application\Controller;


use Application\Model\Comment;
use Framework\Controller;

/**
 * Class CommentController
 * @package Application\Controller
 */
class CommentController extends Controller
{
    /**Permet de supprimer un commentaire
     * @param $id
     * @param $idComment
     * @return mixed
     */
    public function deleteComment($id,$idComment)
    {
        $this->getManager(Comment::class, $this->database)->delete(['id'=>$idComment], $this->database);
        $response = $this->redirect('onePostPage', 302, [$id]);
        return $response;
    }
}

