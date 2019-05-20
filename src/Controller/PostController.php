<?php

namespace Application\Controller;


use Application\Model\Category;
use Application\Model\Post;
use Application\Model\Comment;
use Application\Model\User;
use Framework\Controller;

/**
 * Class PostController
 * @package Application\Controller
 */
class PostController extends Controller
{
    /**
     * @var
     */
    private $displayError ;

    /**
     * @var
     */
    private $response;

    /**Permet de récupérer les Posts et les affiches
     * @param $categoryId
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getAllPost($categoryId)
    {
        if (intval($categoryId) !== 0){
            $post = $this->getManager( Post::class)->fetchAll(['category_id' => $categoryId], ['update_date']);
        }
        else{
            $post = $this->getManager( Post::class)->getAll();
        }
        return $this->ticketVerify($this->render('listPost.twig', [
            'Post' => $post,
            'CategoryList' => $this->getManager( Category::class)->getAll(),
            'userList' => $this->getManager( User::class)->getAll(),
            'commentList' => $this->getManager( Comment::class)->getAll()
        ]));
    }

    /**Permet de récupérer un post et les commentaires associés
     * @param $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getSinglePost($id)
    {

        if ($this->request->getRequest()->getMethod() == "POST" AND $this->tokenVerify() AND isset($_SESSION['Auth']['login'])) {
            $comment = new Comment();
            $this->displayError = $comment->hydrate($this->request->getPost());
            $user = $this->getManager(User::class)->fetch(['login_name' => $comment->getAuthor()]);
            $author = $user->getFirstname() . ' ' . $user->getSurname();
            $comment->setAuthor($author);
            $comment->setPostId($id);
            $comment->setUpdateDate(date("Y-m-d H:i:s"));

            if ($this->checkError($this->displayError) == false){
                $this->getManager(Comment::class)->insert($comment);
                $this->response = $this->redirect('onePostPage', 302, ['id' => $id]);
            }
            else{
                $post = $this->getManager(Post::class)->fetch(['id' => $id]);
                $this->response = $this->displayPostPage($post, $id);
            }
        }
        else {
            $post = $this->getManager(Post::class)->fetch(['id' => $id]);
            if (!isset($_SESSION['Auth']['login'])){
                $this->displayError['notconnect'] = "Merci de vous identifier ici avant de laisser un commentaire";
            }
            $this->response = $this->displayPostPage($post, $id);
        }
        return $this->ticketVerify($this->response);
    }

    /**Permet d'editer un nouveau post
     * @param $id
     * @return string|\Zend\Diactoros\Response\RedirectResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function editPost($id)
    {
        $post = null;
        $category = null;
        $user = null;
        if ($this->request->getRequest()->getMethod() == "POST" AND $this->tokenVerify()){
            $post = new Post();
            $this->displayError = $post->hydrate($this->request->getPost());
            $post->setPrimaryKey($id);
            $post->setUpdateDate(date("Y-m-d H:i:s"));
            $this->response = $this->formControl($post, $id);
        }
        else {
            if ($id != 0){
                $post = $this->pre_filledForm($post, $id);
                $category = $this->getManager( Category::class)->fetch(['id'=>$post->getCategoryId()]);
                $user = $this->getManager( User::class)->fetch(['id'=>$post->getUserId()]);
            }
            $this->response = $this->displayEditPage($post, $category, $user);
        }
        return $this->ticketVerify($this->response);
    }

    /**Permet de supprimer un post
     * @param $id
     * @return mixed
     */
    public function deletePost($id)
    {
        $this->database->getManager(Post::class)->delete(['id'=>$id]);
        return $this->route->redirect('postsPage',302);
    }

    /**Permet l'edition d'un post s'il n'y a pas d'erreur sur le formulaire
     * @param $post
     * @param $id
     * @return string|\Zend\Diactoros\Response\HtmlResponse|\Zend\Diactoros\Response\RedirectResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function formControl($post, $id)
    {
        if ($this->checkError($this->displayError) == false){
            $this->getManager(Post::class)->edit($post, ['id' => $id]);

            return $this->redirect('administrationPage', 302);
        }
        $category = $this->getManager( Category::class)->fetch(['id'=>$post->getCategoryId()]);
        $user = $this->getManager( User::class)->fetch(['id'=>$post->getUserId()]);
        return $this->displayEditPage($post, $category, $user);
    }

    /**Pré-rempli le formulaire de modification d'un post
     * @param $post
     * @param $id
     * @return mixed
     */
    private function pre_filledForm($post, $id)
    {
        if ($post == null){
            $post = $this->getManager( Post::class)->fetch(['id'=>$id]);
        }
        return $post;
    }

    /**Créer l'affichage de la page d'edition du post
     * @param $post
     * @param $category
     * @param $user
     * @return string|\Zend\Diactoros\Response\HtmlResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function displayEditPage($post, $category, $user)
    {
        return $this->render('editPost.twig', ['Post'=> $post, 'Category' => $category,
            'CategoryList' => $this->getManager(Category::class)->getAll(), 'User' => $user,
            'UserList' => $this->getManager(User::class)->getAll(), 'displayError' => $this->displayError,
            'session' => $_SESSION
        ]);
    }

    /**Créer l'affichage de la page du post
     * @param $post
     * @param $id
     * @return string|\Zend\Diactoros\Response\HtmlResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function displayPostPage($post, $id)
    {
        return $this->render('post.twig',
            ['Post' => $post,
                'Comment' => $this->getManager(Comment::class)->fetchAll(['post_id' => $id, 'validation' => 1], ['update_date']),
                'User' => $this->getManager(User::class)->fetch(['id' => $post->getUserId()]),
                'Category' => $this->getManager(Category::class)->fetch(['id' => $post->getCategoryId()]),
                'CategoryList' => $this->getManager(Category::class)->getAll(),
                'displayError' => $this->displayError,
                'session' => $_SESSION
            ]);
    }

}