<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 27/02/19
 * Time: 22:09
 */

namespace Application\Router;




class Router
{

    private $url;
    private $routes = [];


    public function __construct($url)
    {
        $this->url = $url;
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