<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 26/02/19
 * Time: 23:03
 */

namespace Application\Controller;


use \Application\Model\PostManager;

class PostController
{


    public function getListPost()
    {
        ob_start();
        foreach (\Application\Model\Post::getAll() as $post) {


            require 'public/listpost.php';
        }
        $body = ob_get_clean();
        require 'public/templates/default.php';

    }

    public function getViewPost()
    {

    }


}