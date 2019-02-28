<?php

require 'vendor/autoload.php';
use Zend\Diactoros\Response\HtmlResponse;
use \Http\Response;
use \Application\Router\Router;


/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 18/02/19
 * Time: 22:53
 */


$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();
$url = $request->getQueryParams();

$router = new Router($url['url']);

$router->get('home', function (){ require 'public/home.php';});
$router->get('listpost', function (){ require 'public/listpost.php';});
$router->get('post/:id', function ($id){ require 'public/post.php';});
$router->post('addpost/:id', function ($id){ echo 'addpost'.$id.' page';});

$router->run();



//$response = new HtmlResponse( );
//Response\send($response);





?>