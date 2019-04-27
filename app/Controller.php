<?php

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
            $this->database = Database::getInstance();
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
    public function render($page, $data): HtmlResponse
    {
        $htmlContent = $this->twig->render($page, $data);
        return new HtmlResponse($htmlContent);
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
        return new RedirectResponse($url, $status);
    }

    /**verifie la presence d'erreurs
     * @param $displayError
     * @return bool
     */
    protected function checkError($displayError)
    {
        foreach ($displayError as $key => $value) {
            if ($value !== '' ){
                return true;
            }
        }
        return false;
    }

    /**Verifie si un utilisateur est déjà identifié
     * @return bool
     */
    protected function authCheck($response)
    {
        if (isset($_SESSION['Auth']['login']) && isset($_SESSION['Auth']['password'])){
            return $this->redirect('administrationPage', 302);;
        }
        return $response;
    }
}