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
    /**
     * @var
     */
    private $response;

    /**Gestion de la partie administration
     * @return mixed
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function dashboard()
    {
        if ($this->request->getRequest()->getMethod() == "POST" AND $this->tokenVerify()){
            foreach ( $this->request->getPost() as $key =>$id){
                $this->$key($id);
            }
        }
        else{
            $this->pageDisplay();
        }
        return $this->response;
    }

    /**Affichage de la page
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function pageDisplay()
    {

        $this->response =  $this->render('admin.twig',
            [
                'Post' => $this->getManager( Post::class)->getAll(),
                'Comment' => $this->getManager( Comment::class)
                    ->fetchAll(['validation' => 0], ['update_date'], 100, 0),
                'User' => $this->getManager( User::class)->getAll(),
                'ConnectedUser' => $this->getManager(User::class)
                    ->fetch(['login_name' => $_SESSION['Auth']['login']]),
                'session' => ['token' => $_SESSION['token']]
            ]);
    }

    /**Permet de valider d'un commentaire
     * @param $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function validComment($id)
    {
        $comment = $this->getManager(Comment::class)->fetch(['id' => $id]);
        $comment->setValidation(1);
        $this->getManager(Comment::class)->update($comment, ['id' => $id]);
        $this->pageDisplay();
    }

    /**Permet de suprimer un commentaire non validé
     * @param $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function deleteComment($id)
    {
        $this->getManager(Comment::class)->delete(['id'=>$id]);
        $this->pageDisplay();
    }

    /**Permet de modifier un post
     * @param $id
     */
    private function updatePost($id)
    {
        $this->response = $this->redirect('editPostPage', 302, ['id' => $id]);
    }

    /**Permet de créer un post
     * @param $id
     */
    private function createPost($id)
    {
        $this->response = $this->redirect('editPostPage', 302, ['id' => 0]);
    }

    /**Suppression d'un post
     * @param $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function deletePost($id)
    {
        $this->getManager(Post::class)->delete(['id' => $id]);
        $this->getManager(Comment::class)->delete(['post_id' => $id]);
        $this->pageDisplay();
    }

    /**Premet de modifier un utilisateur
     * @param $id
     */
    private function updateUser($id)
    {
        $this->response = $this->redirect('editUserPage', 302, ['id' => $id]);
    }

    /**Permet de créer un utilisateur
     * @param $id
     */
    private function createUser($id)
    {
        $this->response = $this->redirect('editUserPage', 302, ['id' => 0]);
    }

    /**Suppression d'un utlisateur
     * @param $id
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function deleteUser($id)
    {
        $this->getManager(User::class)->delete(['id' => $id]);
        $this->pageDisplay();
    }

}