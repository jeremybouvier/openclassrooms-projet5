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
        return $this->render('listPost.twig', [
            'Post' => $post,
            'CategoryList' => $this->getManager( Category::class)->getAll(),
            'userList' => $this->getManager( User::class)->getAll(),
            'commentList' => $this->getManager( Comment::class)->getAll()
        ]);
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
            if ($this->request->getRequest()->getMethod() == "POST") {
                $comment = new Comment();
                $this->displayError = $comment->hydrate($this->request->getPost());
                $comment->setPostId($id);
                $comment->setUpdateDate(date("Y-m-d H:i:s"));

                if ($this->checkError($this->displayError) == false){
                    $this->getManager(Comment::class)->insert($comment);
                    return $this->redirect('onePostPage', 302, ['id' => $id]);
                }
            }
            $post = $this->getManager( Post::class)->fetch(['id'=>$id]);
            return $this->render('post.twig',
                ['Post'=>$post,
                 'Comment'=> $this->getManager( Comment::class)->fetchAll(['post_id'=>$id, 'validation'=> 1], ['update_date']),
                 'User' => $this->getManager(User::class)->fetch(['id' => $post->getUserId()]),
                 'Category' => $this->getManager(Category::class)->fetch(['id' => $post->getCategoryId()]),
                 'CategoryList' => $this->getManager(Category::class)->getAll(),
                  'displayError' => $this->displayError
                ]);
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
        if ($this->request->getRequest()->getMethod() == "POST"){
            $post = new Post();
            $this->displayError = $post->hydrate($this->request->getPost());
            $post->setPrimaryKey($id);
            $post->setUpdateDate(date("Y-m-d H:i:s"));
            $this->formControl($this->displayError, $post, $id);
        }
        if ($id != 0){
            $post = $this->pre_filledForm($post, $id);
            $category = $this->getManager( Category::class)->fetch(['id'=>$post->getCategoryId()]);
            $user = $this->getManager( User::class)->fetch(['id'=>$post->getUserId()]);
        }
        return $this->render('editPost.twig',
            [
                'Post'=> $post,
                'Category' => $category,
                'CategoryList' => $this->getManager(Category::class)->getAll(),
                'User' => $user,
                'UserList' => $this->getManager(User::class)->getAll(),
                'displayError' => $this->displayError,
                'session' => $_SESSION
            ]);
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

    private function formControl($displayError, $post, $id)
    {
        if ($this->checkError($displayError) == false){
            $this->getManager(Post::class)->edit($post, ['id' => $id]);
            return $this->redirect('administrationPage', 302);
        }
    }

    private function pre_filledForm($post, $id)
    {
        if ($post == null){
            $post = $this->getManager( Post::class)->fetch(['id'=>$id]);
        }
        return $post;
    }

}