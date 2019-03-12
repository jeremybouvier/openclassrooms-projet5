<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 26/02/19
 * Time: 23:03
 */

namespace Application\Controller;


use Application\Model\Post;
use Zend\Diactoros\Response\HtmlResponse;

class PostController
{


    public function getAllPost()
    {
        ob_start();
        foreach (Post::getAll() as $post) {
            require 'src/public/listpost.php';
        }
        $body = ob_get_clean();

        ob_start();
        require 'src/public/templates/default.php';
        $htmlContent = ob_get_clean();

        $response = new HtmlResponse($htmlContent);
        return $response;
    }

    public function getSinglePost($id)
    {
        ob_start();
         $post = Post::getSingle($id);
         require 'src/public/post.php';
         $body = ob_get_clean();

         ob_start();
        require 'src/public/templates/default.php';
         $htmlContent = ob_get_clean();
         $response = new HtmlResponse($htmlContent);


        return $response;



    }


}