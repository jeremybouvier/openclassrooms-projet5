<?php

namespace Application\Controller;


use Application\Model\User;
use Framework\Controller;

class LoginController extends Controller
{
    /**
     * @var
     */
    private $displayError;

    /**
     * @var
     */
     private $response;

    /**Permet de contoler l'acces a la partie administration
     * @param $disconnect
     * @return string|\Zend\Diactoros\Response\RedirectResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function checkPassword($disconnect)
    {

        $this->disconnect($disconnect);
        if ($this->request->getRequest()->getMethod() == "POST" AND $this->tokenVerify()){
            $userConnect = new User();
            $this->displayError = $userConnect->hydrate($this->request->getPost());
            if ($this->checkError($this->displayError) == false){
                $this->response = $this->existingUser($userConnect);
            }
            else{
                $this->response = $this->render('login.twig', ['displayError' => $this->displayError,
                    'session' => $_SESSION]);
            }
        }
        $this->response = $this->userAlwaysConnected();
        return $this->response;
    }

    public function createUser()
    {

    }

    /**Détermine si un utilisateur est toujours connecté
     * @return mixed
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function userAlwaysConnected()
    {
        return $this->authCheck(
            $this->render('login.twig',['displayError' => $this->displayError, 'session' => $_SESSION]),
            $this->redirect('administrationPage', 301));
    }

    /**Permet de vérifier si l'utilisateur existe
     * @param $userConnect
     * @return string|\Zend\Diactoros\Response\HtmlResponse|\Zend\Diactoros\Response\RedirectResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function existingUser($userConnect)
    {
        $user = $this->getManager(User::class)->fetch(['login_name' => $userConnect->getLoginName()]);
        if ($user !== false){
            return $this->passwordVerify($userConnect, $user);
        }
        else{
            $this->displayError['loginName']= 'Identifiant incorrect';
            return $this->render('login.twig', ['displayError' => $this->displayError, 'session' => $_SESSION]);
        }
    }

    /**Permet de verifier le mot de passe de l'utilisateur et doone accès à l'administration
     * @param $userConnect
     * @param $user
     * @return string|\Zend\Diactoros\Response\HtmlResponse|\Zend\Diactoros\Response\RedirectResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function passwordVerify($userConnect, $user)
    {
        if (password_verify($userConnect->getPassword(), $user->getPassword()) == true){
            $_SESSION['Auth'] = ['login' => $user->getLoginName(), 'password' => $user->getPassword(),
                'role' => $user->getRoleId()];
            if ($user->getRoleId() == 1){
                return $this->redirect('administrationPage', 302);
            }
            else{
                return $this->redirect('homePage', 302);
            }

        }
        else{
            $this->displayError['loginName']= 'Identifiant incorrect';
            return $this->render('login.twig', ['displayError' => $this->displayError, 'session' => $_SESSION]);
        }
    }

    /**Permet la déconnection d'un utilisateur
     * @param $disconnect
     */
    private function disconnect($disconnect)
    {
        if ($disconnect == 'disconnect'){
            $_SESSION['Auth']['login'] = null;
        }
    }

}