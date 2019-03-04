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

$router->get('/', "Welcome#index");
$router->get('home', "Home#index");
$router->get('listpost', "Post#getListPost");
$router->get('post/:id', "#");



$router->run();



//$response = new HtmlResponse( );
//Response\send($response);





?>