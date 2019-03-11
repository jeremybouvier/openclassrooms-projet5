<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 27/02/19
 * Time: 22:09
 */

namespace Framework\Router;

use Zend\Diactoros\ServerRequestFactory;


class Router
{

    private $url;
    private $routes = [];


    public function __construct()
    {
        $request = ServerRequestFactory::fromGlobals();
        $this->url = $request->getUri()->getPath();

    }


    public function  get($path, $callable)
    {

        $route = new Route($path,$callable);
        $this->routes['GET'][] = $route;
    }


    public function  post($path, $callable)
    {

        $route = new Route($path,$callable);
        $this->routes['POST'][] = $route;
    }


    public function run()
    {


        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouterException('Request_Method doesn\'t exist');
        }

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route ){
            if ($route->match($this->url)){
                return $route->call();
            }
        }

        throw new RouterException('no routes matches');
    }

}