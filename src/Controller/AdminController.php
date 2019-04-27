<?php

namespace Application\Controller;


use Application\Model\Comment;
use Application\Model\Post;
use Application\Model\User;
use Framework\Controller;

/**
 * Class AdminController
 * @package Application\Controller
 */
class AdminController extends Controller
{
    private $response;

    /**Gestion de la partie administration
     * @return string|\Zend\Diactoros\Response\RedirectResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function dashboard()
    {
        if ($this->authCheck($this->response)){
            if ($this->request->getRequest()->getMethod() == "POST"){
                foreach ( $this->request->getPost() as $key =>$id){
                    switch ($key){
                        case 'validComment':
                            $comment = $this->getManager(Comment::class)->fetch(['id' => $id]);
                            $comment->setValidation(1);
                            $this->getManager(Comment::class)->update($comment, ['id' => $id]);
                            break;
                        case 'deleteComment':
                            $this->getManager(Comment::class)->delete(['id'=>$id]);
                            break;
                        case 'updatePost':
                            return $this->redirect('editPostPage', 302, ['id' => $id]);
                            break;
                        case 'createPost':
                            return $this->redirect('editPostPage', 302, ['id' => 0]);
                            break;
                        case 'deletePost':
                            $this->getManager(Post::class)->delete(['id' => $id]);
                            $this->getManager(Comment::class)->delete(['post_id' => $id]);
                            break;
                        case 'updateUser':
                            return $this->redirect('editUserPage', 302, ['id' => $id]);
                            break;
                        case 'createUser':
                            return $this->redirect('editUserPage', 302, ['id' => 0]);
                            break;
                        case 'deleteUser':
                            $this->getManager(User::class)->delete(['id' => $id]);
                            break;
                    }
                }
            }
            return $this->render('admin.twig',
                [
                'Post' => $this->getManager( Post::class)->getAll(),
                'Comment' => $this->getManager( Comment::class)
                    ->fetchAll(['validation' => 0], ['update_date'], 100, 0),
                'User' => $this->getManager( User::class)->getAll(),
                'ConnectedUser' => $this->getManager(User::class)
                    ->fetch(['login_name' => $_SESSION['Auth']['login']])
            ]);
        }
        return $this->redirect('loginPage', 302, ['disconnect' => 'notconnected']);
    }
}