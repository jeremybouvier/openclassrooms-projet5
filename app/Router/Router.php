<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 27/02/19
 * Time: 22:09
 */

namespace Framework\Router;


use Framework\Request;

/**
 * Class Router
 * @package Framework\Router
 */
class Router
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var
     */
    private $urlParam;

    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var Request
     */
    private $request;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $request = new Request();
        $this->request = $request;
        $this->url = $request->getRequest()->getUri()->getPath();
    }

    /**Permet d'enregistrer les routes
     * @param $name
     * @param $path
     * @param $callable
     */
    public function  setRoute( $name, $path, $callable)
    {
        $route = new Route($path,$callable);
        $this->routes[$name] = $route;
    }

    /**Permet de lancer le router
     * @param $router
     * @return mixed
     * @throws RouterException
     */
    public function run($router)
    {
        foreach ($this->routes as $route ) {
            if ($route->match($this->url, $this->url)) {
                return $route->call($this->request, $router);
            }
        }
        throw new RouterException('no routes matches');
    }

    /**Renvoi l'url correspondant au nom de la route
     * @param $name
     * @param array $params
     * @return string
     * @throws RouterException
     */
    public function generateUrl($name, $params=[])
    {
        $this->urlParam = '';
        if ($params !==[]){
            foreach ($params as $param){
                $this->urlParam = '/' . $param . $this->urlParam;
            }
        }
        if(isset($name)){
            $path = explode(':', $this->routes[$name]->getPath());
            return '/' . trim( $path[0], '/') . $this->urlParam;
        }
        if ($name !==''){
            return '/' . $name . $this->urlParam;
        }
        throw new RouterException('no route name specify');
    }



}