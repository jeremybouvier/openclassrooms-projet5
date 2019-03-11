<?php

require 'vendor/autoload.php';


use \Framework\Router\Router;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;


/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 18/02/19
 * Time: 22:53
 */


$request = ServerRequestFactory::fromGlobals();
$url = $request->getUri()->getPath();

$router = new Router($url);

$router->get('/', "Welcome#index");
$router->get('home', "Home#index");
$router->get('listpost', "Post#getAllPost");
$router->get('post/:id', "Post#getSingle");



$response = $router->run();

$emitter = new SapiEmitter();
$emitter->emit($response);







?>