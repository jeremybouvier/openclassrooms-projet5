<?php

require 'vendor/autoload.php';
use Zend\Diactoros\Response\HtmlResponse;
use \Http\Response;
use app\Router;

/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 18/02/19
 * Time: 22:53
 */


$request = \Zend\Diactoros\ServerRequestFactory::fromGlobals();
$path = $request->getQueryParams();


$root = new Router();



$response = new HtmlResponse( $root->route($path));
Response\send($response);





?>