<?php

require 'vendor/autoload.php';

use \Http\Response;
use \Application\Router\Router;


/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 18/02/19
 * Time: 22:53
 */


$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();
$url = $request->getUri()->getPath();

$router = new Router($url);

$router->get('/', "Welcome#index");
$router->get('home', "Home#index");
$router->get('listpost', "Post#getAllPost");
$router->get('post/:id', "#");



$response = $router->run();

$emitter = new \Zend\HttpHandlerRunner\Emitter\SapiEmitter();
$emitter->emit($response);







?>