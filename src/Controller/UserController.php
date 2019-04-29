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
     * @return void|\Zend\Diactoros\Response\RedirectResponse
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
                if ($user == null){
                    $user = $this->getManager( User::class)->fetch(['id'=>$id]);
                }
                $role = $this->getManager( Role::class)->fetch(['id'=>$user->getRoleId()]);
            }
            $this->response = $this->displayPage($user,$role);
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