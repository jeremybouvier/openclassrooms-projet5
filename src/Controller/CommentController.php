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

/**
 * Class CommentController
 * @package Application\Controller
 */
class CommentController extends Controller
{
    /**récupère tous les commentaires d'un post
     * @param $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getAllComment($id)
    {
        $commentManager = $this->getManager( Comment::class, $this->database)->fetchAll(
            ['post_id'=>$id],
            ['update_date'],
            10, 0);
        $response = $this->render('post.twig', ['Comment'=> $commentManager]);
        return $response;
    }

    /**Permet de supprimer un commentaire
     * @param $id
     * @param $idComment
     * @return mixed
     */
    public function deleteComment($id,$idComment)
    {
        $this->getManager(Comment::class, $this->database)->delete(['id'=>$idComment], $this->database);
        $response = $this->redirect('onePostPage', 301, [$id]);
        return $response;
    }
}