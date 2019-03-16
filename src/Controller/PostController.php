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
use Zend\Diactoros\Response\HtmlResponse;


class PostController extends Controller
{


    /**Permet de récupérer les Posts et les affiches
     * @return HtmlResponse
     */
    public function getAllPost()
    {
        $htmlContent =  $this->templates('listPost.twig', ['Post'=>Post::getAll('')]);

        $response = new HtmlResponse($htmlContent);

        return $response;

    }


    /**Permet de récupérer un post et les commentaires associés
     * @param $id
     * @return HtmlResponse
     */
    public function getSinglePost($id)
    {
        $data =  [
            'Post'=>Post::getSingle(['id'=>$id],'fetch'),
            'Comment'=> Comment::getSingle(['post_id'=>$id],'fetchAll')
        ];

        $htmlContent = $this->templates('post.twig', $data);

        $response = new HtmlResponse($htmlContent);

        return $response;

    }




}