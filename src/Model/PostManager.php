<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 26/02/19
 * Time: 22:40
 */

namespace model;

use \app\Post;
use Zend\Diactoros\ServerRequestFactory;

class PostManager
{

    public function getPosts()
    {
        foreach (\app\App::getDB()->query('SELECT * FROM post') as $req):
            $post = new Post();
            $post->hydrate($req);

        endforeach;
        $response = require 'view/listpost.php';
        return $response;


    }

    public function getPost()
    {
        $request = ServerRequestFactory::fromGlobals();
        $params = $request->getQueryParams();

        $post = new Post();
        $req = \app\App::getDB()->prepare('SELECT * FROM post WHERE id=?', [$params['id']]);
        $post->hydrate($req);
        return $post;
    }
}