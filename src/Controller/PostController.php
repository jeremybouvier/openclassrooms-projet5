<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 26/02/19
 * Time: 23:03
 */

namespace Application\Controller;

use Application\Model\Post;
use Application\Model\Comment;
use Framework\Controller;

/**
 * Class PostController
 * @package Application\Controller
 */
class PostController extends Controller
{

    /**Permet de récupérer les Posts et les affiches
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getAllPost()
    {
        $post = $this->database->getManager( new Post(), $this->database)->getAll();
        return $this->render('listPost.twig', ['Post'=> $post]);
    }

    /**Permet de récupérer un post et les commentaires associés
     * @param $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getSinglePost($id)
    {
        $post = $this->database->getManager( new Post(), $this->database)->fetch(['id'=>$id]);
        $comment = $this->database->getManager( new Comment(), $this->database)
            ->fetchAll(['post_id'=>$id], ['update_date'], 10, 0);
        $data =  ['Post'=>$post, 'Comment'=> $comment];
        $response = $this->render('post.twig', $data);
        return $response;

    }

    /**Permet d'ajouter un nouveau post
     * @param $id
     * @return mixed
     */
    public function addPost()
    {
        $result = $this->request->getPost();
        $post = new Post();
        $post->hydrate($result);
        $post->setUserId('1');
        $post->setUpdateDate(date("Y-m-d H:i:s"));
        $this->database->getManager($post, $this->database)->insert();
        $response = $this->route->redirect($this->route->getUrl(),302);
        return $response;
    }

    public function deletePost($id)
    {
        $this->database->getManager(new Post(), $this->database)->delete(['id'=>$id], $this->database);
        $response = $this->route->redirect('/listpost',302);
        return $response;
    }
}