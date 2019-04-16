<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 16/04/19
 * Time: 21:43
 */

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
            $user->setPassword(sha1($user->getPassword()));
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
        $roleList = $this->getManager(Role::class)->getAll();
        $data =  [
            'User'=> $user,
            'Role' => $role,
            'roleList' => $roleList,
            'displayError' => $this->displayError
            ];
        $response = $this->render('editUser.twig', $data);
        return $response;
    }

    /**Permet de supprimer un post
     * @param $id
     * @return mixed
     */
    public function deletePost($id)
    {
        $this->database->getManager(User::class)->delete(['id'=>$id]);
        return $this->route->redirect('postsPage',302);
    }
}