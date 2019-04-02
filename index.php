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

$router->get('/', "Welcome#index");
$router->get('home', "Home#index");
$router->get('listPost', "Post#getAllPost");
$router->get('post/:id', "Post#getSinglePost");
$router->post('post/:id', "Comment#addComment");
$router->get('deleteComment/:id/:idComment', "Comment#deleteComment");
$router->get('test', "Test#test");
$response = $router->run();

$emitter = new SapiEmitter();
$emitter->emit($response);

?>