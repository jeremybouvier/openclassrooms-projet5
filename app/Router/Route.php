<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 27/02/19
 * Time: 22:19
 */

namespace Framework\Router;

use Zend\Diactoros\Response\RedirectResponse;



class Route
{
    private $path;
    private $callable;
    private $matches;
    private $url;

    /**
     * Route constructor.
     * @param $path
     * @param $callable
     */
    public function __construct($path, $callable)
    {
        $this->path = trim($path,'/');
        $this->callable = $callable;
    }

    /**Permet de récupérer les parametres passés dans la route
     * @param $route
     * @param $url
     * @return bool
     */
    public function match($route, $url)
    {
        $this->url = $url;
        $route = trim($route,'/');

        $path = preg_replace('#:([\w]+)#','([^/]+)',$this->path);

        $regex = "#^$path$#i";

        if (!preg_match($regex, $route,$matches)){
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;
        return true;

    }

    /**Permet d'appeler le contrôleur spécifier dans la route
     * @param $request
     * @param $route
     * @return mixed
     */
    public function call($request, $route)
    {

        if(is_string($this->callable)){

            $params = explode('#',$this->callable);
            $controller = "Application\\Controller\\".$params[0]."Controller";
            $controller = new $controller($request, $route);

            return call_user_func_array([$controller, $params[1]], $this->matches);

        }
        else{
            return call_user_func_array($this->callable, $this->matches);
        }

    }

    /**Permet la redirection vers une autre route
     * @param $url
     * @param $status
     * @return RedirectResponse
     */
    public function redirect($url, $status)
    {
        $response = new RedirectResponse($url,$status);
        return $response;
    }


    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return mixed
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * @return mixed
     */
    public function getCallable()
    {
        return $this->callable;
    }

}