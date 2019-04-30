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
        if ($this->request->getRequest()->getMethod() == "POST"){
            $userConnect = new User();
            $this->displayError = $userConnect->hydrate($this->request->getPost());
            if ($this->checkError($this->displayError) == false){
                $this->response = $this->existingUser($userConnect);
            }
            else{
                $this->response = $this->render('login.twig', ['displayError' => $this->displayError]);
            }
        }
        $this->response = $this->userAlwaysConnected();
        return $this->response;
    }

    private function userAlwaysConnected()
    {
        return $this->authCheck(
            $this->render('login.twig',['displayError' => $this->displayError]),
            $this->redirect('administrationPage', 301));
    }

    private function existingUser($userConnect)
    {
        $user = $this->getManager(User::class)->fetch(['login_name' => $userConnect->getLoginName()]);
        if ($user !== false){
            return $this->passwordVerify($userConnect, $user);
        }
        else{
            $this->displayError['loginName']= 'Identifiant incorrect';
            return $this->render('login.twig', ['displayError' => $this->displayError]);
        }
    }

    private function passwordVerify($userConnect, $user)
    {
        if (password_verify($userConnect->getPassword(), $user->getPassword()) == true){
            $_SESSION['Auth'] = ['login' => $user->getLoginName(), 'password' => $user->getPassword()];
            return $this->redirect('administrationPage', 302);
        }
        else{
            $this->displayError['loginName']= 'Identifiant incorrect';
            return $this->render('login.twig', ['displayError' => $this->displayError]);
        }
    }

    private function disconnect($disconnect)
    {
        if ($disconnect == 'disconnect'){
            $_SESSION['Auth']['login'] = null;
        }
    }
}