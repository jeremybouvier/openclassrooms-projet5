<?php

namespace Framework;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;


class Controller
{
    /**
     * @var
     */
    protected $request;
    /**
     * @var Database
     */
    protected $database;
    /**
     * @var Environment
     */
    protected $twig;
    /**
     * @var
     */
    protected $router;

    private $sessionStart =0;

    /**stockage de la requete de la connection a la base de donnée et de la route dans le controller
     * Controller constructor.
     * @param $request
     * @param $router
     */
    public function __construct($request, $router)
    {
        $this->router = $router;
        $this->request = $request;
        $loader = new FilesystemLoader('Templates');
        $this->twig = new Environment($loader, ['cache' => false]);
        if (!isset($this->database)){
            $this->database = Database::getInstance();
        }
        $this->setToken();
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
     * @param $redirect
     * @param $response
     * @return mixed
     */
    protected function authCheck($redirect, $response)
    {
        if (isset($_SESSION['Auth']['login']) && isset($_SESSION['Auth']['password'])){
            return $response;
        }
        return $redirect;
    }

    /**Permet de créer le jeton de securité
     *
     */
    private function setToken()
    {
        if (!isset($_SESSION['token']) OR empty($_SESSION['token'])){
            $_SESSION['token'] = md5(bin2hex(openssl_random_pseudo_bytes(6)));
        }
    }

    /**Permet de controler la validité du jeton de securité reçu
     * @return bool
     */
    protected function tokenVerify()
    {
        if ($this->request->getToken() == $_SESSION['token']){
            return true;
        }
        return false;
    }

    /**Permet de créer et d'enregistrer un nouveau ticket de securité
     *
     */
    protected  function setTicket()
    {
        $ticket = password_hash(openssl_random_pseudo_bytes(6), PASSWORD_DEFAULT);
        setcookie("ticket", $ticket, time() + (60 * 60));
        $_SESSION['ticket'] = $ticket;
    }

    private function updateTicket()
    {
        $ticket = password_hash(openssl_random_pseudo_bytes(6), PASSWORD_DEFAULT);
        setcookie("ticket", $ticket);
        $_SESSION['ticket'] = $ticket;
    }

    private function deleteTicket()
    {
        $_SESSION = array();
        session_destroy();
    }

    /**Permet de tester la validité du ticket et de le modifier
     * @param $response
     * @return RedirectResponse
     */
    protected function ticketVerify($response)
    {   
        if (isset($_COOKIE['ticket']) AND isset($_SESSION['ticket'])){
            if ($_COOKIE['ticket'] == $_SESSION['ticket']){
                $this->updateTicket();
                return $response;
            }
            $this->deleteTicket();
            return $this->redirect('homePage', 302);
        }
        else
        {
            $this->setTicket();
            return $response;
        }
    }
}