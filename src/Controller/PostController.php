<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 26/02/19
 * Time: 23:03
 */

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
    private $displayError;
    /**Permet de récupérer les Posts et les affiches
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function getAllPost()
    {
        $post = $this->getManager( Post::class)->getAll();
        return $this->render('listPost.twig', ['Post'=> $post]);
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
                if ($this->displayError == null){
                    $this->getManager(Comment::class, $this->database)->insert($comment);
                }

            }

            $post = $this->getManager( Post::class)->fetch(['id'=>$id]);
            $comment = $this->getManager( Comment::class)
                ->fetchAll(['post_id'=>$id], ['update_date'], 10, 0);
            $category = $this->getManager(Category::class)->fetch(['id' => $post->getCategoryId()]);
            $user = $this->getManager(User::class)->fetch(['id' => $post->getUserId()]);
            $categoryList = $this->getManager(Category::class)->getAll();
            $data =  [  'Post'=>$post,
                        'Comment'=> $comment,
                        'User' => $user,
                        'Category' => $category,
                        'CategoryList' => $categoryList,
                        'displayError' => $this->displayError];

            return $this->render('post.twig', $data);
    }

    /**Permet d'ajouter un nouveau post
     * @param $id
     * @return string|\Zend\Diactoros\Response\RedirectResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function updatePost($id)
    {
        if ($this->request->getRequest()->getMethod() == "POST"){
            $post = new Post();
            $post->hydrate($this->request->getPost());
            $post->setUpdateDate(date("Y-m-d H:i:s"));
            $this->getManager(Post::class)->update($post, ['id' => $id]);
            return $this->redirect('postsPage',302);
        }
        else{
            $post = $this->getManager( Post::class)->fetch(['id'=>$id]);
            $category = $this->getManager( Category::class)->fetch(['id'=>$post->getCategoryId()]);
            $user = $this->getManager( User::class)->fetch(['id'=>$post->getUserId()]);
            $categoryList = $this->getManager(Category::class)->getAll();
            $userList = $this->getManager(User::class)->getAll();
            $data =  [  'Post'=> $post,
                'Category' => $category,
                'CategoryList' => $categoryList,
                'User' => $user,
                'UserList' => $userList];
            $response = $this->render('updatePost.twig', $data);
            return $response;
        }
    }

    /**Permet de supprimer un post
     * @param $id
     * @return mixed
     */
    public function deletePost($id)
    {
        $this->database->getManager(Post::class)->delete(['id'=>$id], $this->database);
        $response = $this->route->redirect('postsPage',302);
        return $response;
    }
}