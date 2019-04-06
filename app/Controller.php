<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 15/03/19
 * Time: 13:23
 */

namespace Framework;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;


class Controller
{
    protected $request;
    protected $database;
    protected $twig;
    protected $router;

    /**stockage de la requete de la connection a la base de donnée et de la route dans le controller
     * Controller constructor.
     * @param $request
     * @param $router
     */
    public function __construct($request, $router)
    {
        $this->request = $request;
        $this->router = $router;
        if (!isset($this->database)){
            $database = new App();
            $this->database = $database->getDB();
        }
            $loader = new FilesystemLoader('Templates');
            $this->twig = new Environment($loader, ['cache' => false]);
    }

    /**Initialisation de l'environement de Twig
     * @param $page
     * @param $data
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render($page, $data)
    {
        $htmlContent = $this->twig->render($page, $data);
        $response = new HtmlResponse($htmlContent);
        return $response;
    }

    public function getManager($model)
    {
        $managerName = $this->database->getManager($model);
        return new $managerName(new $model(), $this->database);
    }

    /**Permet la redirection vers une autre route
     * @param $name
     * @param $status
     * @param array $param
     * @return RedirectResponse
     */
    public function redirect($name, $status, $param = [])
    {
        $url = $this->router->generateUrl($name, $param);
        $response = new RedirectResponse($url, $status);
        return $response;
    }

}