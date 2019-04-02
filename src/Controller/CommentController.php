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

        $commentManager = $this->database->getManager( new Comment(), $this->database)->fetchAll(
            ['post_id'=>$id],
            ['update_date'],
            10, 0);
        $response = $this->render('post.twig', ['Comment'=> $commentManager]);
        return $response;
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
        $comment->setUpdateDate(date("Y-m-d H:i:s"));
        $this->database->getManager($comment, $this->database)->insert();

        $response = $this->route->redirect($this->route->getUrl(),302);
        return $response;
    }

    public function deleteComment($id,$idComment)
    {
        $this->database->getManager(new Comment(), $this->database)->delete(['id'=>$idComment], $this->database);
        $response = $this->route->redirect('/post/'.$id,302);
        return $response;
    }


}