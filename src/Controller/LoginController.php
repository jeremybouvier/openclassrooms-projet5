<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 15/04/19
 * Time: 23:31
 */

namespace Application\Controller;


use Application\Model\User;
use Framework\Controller;

class LoginController extends Controller
{
    /**
     * @var
     */
    private $displayError;

    /**Permet de contoler l'acces a la partie administration
     * @param $disconnect
     * @return string|\Zend\Diactoros\Response\RedirectResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function checkPassword($disconnect)
    {
        if ($disconnect=='disconnect'){
            $_SESSION['Auth']['login'] = null;
        }
        if ($this->authCheck()){
            return $this->redirect('administrationPage', 302);
        }
        if ($this->request->getRequest()->getMethod() == "POST"){
            $userConnect = new User();
            $this->displayError = $userConnect->hydrate($this->request->getPost());
            if ($this->checkError($this->displayError) == false){
                $user = $this->getManager(User::class)->fetch(['login_name' => $userConnect->getLoginName()]);
                if ($user!==false){
                    if (password_verify($userConnect->getPassword(), $user->getPassword()) == true){
                        $_SESSION['Auth'] = ['login' => $user->getLoginName(), 'password' => $user->getPassword()];
                        return $this->redirect('administrationPage', 302);
                    }
                    else{
                        return $this->render('login.twig', ['displayError' => ['loginName'=> 'Identifiants incorrect']]);
                    }
                }
                else{
                    return $this->render('login.twig', ['displayError' => ['loginName'=> 'Identifiants incorrect']]);
                }
            }
        }
        return $this->render('login.twig', ['displayError' => $this->displayError]);
    }
}