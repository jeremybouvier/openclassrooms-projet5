<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 18/03/19
 * Time: 13:54
 */

namespace Application\Controller;

use Application\Model\Comment;


class CommentController extends Controller
{
    /**récupère tous les commentaires d'un post
     * @param $id
     * @return array|mixed
     */
    public function getAllComment($id)
    {
        $data = Comment::getSingle(['post_id'=>$id],'id','fetchAll');
        return $data;
    }

    /**Permet d'ajouter un nouveau commentaire
     * @param $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function AddComment($id)
    {
        $pdoParam = $_POST;
        $pdoParam['post_id'] = (int)$id;
        Comment::AddSingle($pdoParam);

        $post = new PostController();
        $response = $post->getSinglePost($id);
        return $response;
    }
}