<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 26/02/19
 * Time: 23:03
 */

namespace Application\Controller;

use \controller\PostManager;

class PostController
{


    public function getHome()
    {
        $response = new Response();
        $response::setResponse( require 'public/home.php');
        return $response;

    }

    public function getListPost()
    {
        $listpost = new PostManager();
        $response = $listpost->getPosts();
        return $response;
    }

    public function getViewPost()
    {
        $listpost = new PostManager();
        $post = $listpost->getPost();
        $response = require '/view/post.php';


        return $response;
    }
}