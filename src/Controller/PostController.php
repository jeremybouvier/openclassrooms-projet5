<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 26/02/19
 * Time: 23:03
 */

namespace Application\Controller;

use Application\Model\Post;
use Framework\Controller;




class PostController extends Controller
{


    /**Permet de récupérer les Posts et les affiches
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getAllPost()
    {
        $post = new Post();
        $data = ['Post'=>$post->getAll($this->database)];

        $response = $this->render('listPost.twig', $data);
        return $response;
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
        $post = new Post();
        $commentData = new CommentController($this->request, $this->route);

        $data =  [
            'Post'=>$post->getSingle(['id'=>$id],'','fetch', $this->database),
            'Comment'=> $commentData->getAllComment($id)
        ];

        $response = $this->render('post.twig', $data);
        return $response;

    }




}