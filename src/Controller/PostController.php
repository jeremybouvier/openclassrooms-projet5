<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 26/02/19
 * Time: 23:03
 */

namespace Application\Controller;


use Zend\Diactoros\Response\HtmlResponse;

class PostController
{


    public function getAllPost()
    {
        ob_start();
        foreach (\Application\Model\Post::getAll() as $post) {
            require 'public/listpost.php';
        }
        $body = ob_get_clean();

        ob_start();
        require 'public/templates/default.php';
        $htmlContent = ob_get_clean();

        $response = new HtmlResponse($htmlContent);
        return $response;
    }

    public function getSinglePost()
    {

    }


}