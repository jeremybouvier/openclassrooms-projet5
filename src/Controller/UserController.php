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

    /**Permet d'editer un nouveau post
     * @param $id
     * @return string|\Zend\Diactoros\Response\RedirectResponse
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
            if ($this->checkError($this->displayError) == false){
                $this->getManager(User::class)->edit($user, ['id' => $id]);
                return $this->redirect('administrationPage', 302);
            }
        }
        if ($id != 0){
            if ($user == null){
                $user = $this->getManager( User::class)->fetch(['id'=>$id]);
            }
            $role = $this->getManager( Role::class)->fetch(['id'=>$user->getRoleId()]);
        }
        return $this->render('editUser.twig',
            [
            'User'=> $user,
            'Role' => $role,
            'roleList' => $this->getManager(Role::class)->getAll(),
            'displayError' => $this->displayError
            ]);
    }
}