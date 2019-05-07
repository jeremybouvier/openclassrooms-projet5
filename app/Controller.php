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

    /**stockage de la requete de la connection a la base de donnée et de la route dans le controller
     * Controller constructor.
     * @param $request
     * @param $router
     */
    public function __construct($request, $router)
    {
        ini_set('session.use_only_cookie', true);
        session_start(['cookie_lifetime' => (60*20)]);
        $this->router = $router;
        $this->request = $request;
        $loader = new FilesystemLoader('Templates');
        $this->twig = new Environment($loader, ['cache' => false]);
        if (!isset($this->database)){
            $this->database = Database::getInstance();
        }
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
            if ($value !== '' ) {
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
        if (isset($_SESSION['Auth']['login']) && isset($_SESSION['Auth']['password'])) {
            return $response;
        }
        return $redirect;
    }

    /**Permet de créer le jeton de securité
     *
     */
    private function setToken()
    {
        if (!isset($_SESSION['token']) OR empty($_SESSION['token'])) {
            $_SESSION['token'] = md5(bin2hex(openssl_random_pseudo_bytes(6)));
        }
    }

    /**Permet de controler la validité du jeton de securité reçu
     * @return bool
     */
    protected function tokenVerify()
    {
        if (isset($_SESSION['token'])) {
            if ($this->request->getToken() == $_SESSION['token']){
                return true;
            }
        }
        return false;
    }

    /**Permet de demarrer un nouvelle session
     *
     */
    private function sessionStart()
    {
        if (!isset ($_SESSION['sessionId'])) {
            ini_set('session.use_only_cookie', true);
            if (session_status() !== PHP_SESSION_ACTIVE ) {
                session_start(['cookie_lifetime' => (60*20)]);
            }
            $_SESSION['sessionId'] = session_id();
            $_SESSION['lifeTime'] = time() + (60*15);
            $this->setToken();
        }
    }

    /**Permet de changer ID session
     *
     */
    private function regenerateIdSession()
    {
        $sessionData = $_SESSION;
        $new_session_id = session_create_id();
        session_commit();
        session_id($new_session_id);
        ini_set('session.use_only_cookie', true);
        ini_set('session.use_strict_mode', 0);
        session_start(['cookie_lifetime' => (60*20)]);
        $_SESSION = $sessionData;
        $_SESSION['sessionId'] = $new_session_id;
        $_SESSION['lifeTime'] = time() + (60*15);
    }

    /**Permet de tester la validité du ticket et de le modifier
     * @param $response
     * @return RedirectResponse
     */
    protected function ticketVerify($response)
    {
        $this->sessionStart();
        if ($_SESSION['sessionId'] == $_COOKIE['PHPSESSID'] AND $_SESSION['lifeTime'] > time()){
            $this->regenerateIdSession();
            return $response;
        }
        session_destroy();
        return $this->redirect('homePage', 301);
    }
}