<?php

namespace Application\Controller;


use Application\Model\User;
use Application\Model\Role;
use Framework\Controller;

class UserController extends Controller
{
    /**
     * @var
     */
    private $displayError;

    /**
     * @var
     */
    private $response;

    /**Permet d'editer un nouveau post
     * @param $id
     * @return string|\Zend\Diactoros\Response\HtmlResponse|\Zend\Diactoros\Response\RedirectResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function editUser($id)
    {
        $user = null;
        $role = null;
        if ($this->request->getRequest()->getMethod() == "POST"){
            $user = new User();
            $this->displayError = $user->hydrate($this->request->getPost());
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_DEFAULT));
            $user->setPrimaryKey($id);
            $this->response = $this->formControl($user, $id);
        }
        else{
            if ($id != 0){
                $user = $this->pre_filledForm($user, $id);
                $role = $this->getManager( Role::class)->fetch(['id'=>$user->getRoleId()]);
            }
            $this->response = $this->displayPage($user, $role);
        }
        return $this->response;
    }

    /**Controle le remplissage du formulaire d'édition d'un utilisateur
     * @param $user
     * @param $id
     * @return string|\Zend\Diactoros\Response\HtmlResponse|\Zend\Diactoros\Response\RedirectResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function formControl($user, $id)
    {
        if ($this->checkError($this->displayError) == false){
            $this->getManager(User::class)->edit($user, ['id' => $id]);
            return $this->redirect('administrationPage', 302);
        }
        $role = $this->getManager( Role::class)->fetch(['id'=>$user->getRoleId()]);
        return $this->displayPage($user, $role);
    }

    /**Pré-rempli le formulaire de modification d'un utilisateur
     * @param $user
     * @param $id
     * @return mixed
     */
    private function pre_filledForm($user, $id)
    {
        if ($user == null){
            $user = $this->getManager( User::class)->fetch(['id'=>$id]);
        }
        return $user;
    }

    /**créer l'affichage de la page
     * @param $user
     * @param null $role
     * @return string|\Zend\Diactoros\Response\HtmlResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function displayPage($user, $role)
    {
        return $this->render('editUser.twig',
            [
                'User'=> $user,
                'Role' => $role,
                'roleList' => $this->getManager(Role::class)->getAll(),
                'displayError' => $this->displayError
            ]);
    }
}