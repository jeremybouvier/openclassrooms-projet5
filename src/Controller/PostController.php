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

         $post = Post::getSingle($id);
         $id = $post->getCategoryId();
        echo "<pre>";
        print_r($id);
        print_r($post);

    }


}