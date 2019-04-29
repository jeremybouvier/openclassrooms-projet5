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
            $this->response = $this->formControl($this->displayError, $user, $id);
        }
        else{
            if ($id != 0){
                $user = $this->prefillForm($user);
                $role = $this->getManager( Role::class)->fetch(['id'=>$user->getRoleId()]);
            }
            $this->response = $this->render('editUser.twig',
                [
                    'User'=> $user,
                    'Role' => $role,
                    'roleList' => $this->getManager(Role::class)->getAll(),
                    'displayError' => $this->displayError
                ]);
        }
        return $this->response;
    }

    private function formControl($displayError, $user, $id)
    {
        if ($this->checkError($displayError) == false){
            $this->getManager(User::class)->edit($user, ['id' => $id]);
            return $this->redirect('administrationPage', 302);
        }
    }

    private function prefillForm($user)
    {
        if ($user == null){
            $user = $this->getManager( User::class)->fetch(['id'=>$id]);
        }
        return $user;
    }
}