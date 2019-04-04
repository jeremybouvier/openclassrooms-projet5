<?php

require 'vendor/autoload.php';


use \Framework\Router\Router;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;


/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 18/02/19
 * Time: 22:53
 */




$router = new Router();

$router->setRoute('welcome','/', "Welcome#index");
$router->setRoute('home','home', "Home#index");
$router->setRoute('postsPage','listPost', "Post#getAllPost");
$router->setRoute('onePostPage', 'post/:id', "Post#getSinglePost");

$router->setRoute('deleteComment','deleteComment/:id/:idComment', "Comment#deleteComment");
$router->setRoute('test','test', "Test#test");
$response = $router->run($router);

$emitter = new SapiEmitter();
$emitter->emit($response);

?>