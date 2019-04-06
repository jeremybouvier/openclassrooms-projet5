<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 26/02/19
 * Time: 23:03
 */

namespace Application\Controller;


use Application\Model\Post;
use Application\Model\Comment;
use Framework\Controller;
use Application\Controller\ControllerException;

/**
 * Class PostController
 * @package Application\Controller
 */
class PostController extends Controller
{

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
        try
        {
            if ($this->request->getRequest()->getMethod() == "POST") {
                $comment = new Comment();
                $comment->hydrate($this->request->getPost());
                $comment->setPostId($id);
                $comment->setUpdateDate(date("Y-m-d H:i:s"));
                $this->getManager(Comment::class, $this->database)->insert($comment);
                return $this->redirect('onePostPage', 301, [$id]);
            }
            $post = $this->getManager( Post::class)->fetch(['id'=>$id]);
            $comment = $this->getManager( Comment::class)
                ->fetchAll(['post_id'=>$id], ['update_date'], 10, 0);
            $data =  ['Post'=>$post, 'Comment'=> $comment];

            $response = $this->render('post.twig', $data);
            return $response;
        }
        catch (ControllerException $e) {
            $post = $this->getManager( Post::class)->fetch(['id'=>$id]);
            $comment = $this->getManager( Comment::class)
                ->fetchAll(['post_id'=>$id], ['update_date'], 10, 0);
            $data =  ['Post'=>$post, 'Comment'=> $comment, 'messageException'=> [$e->getMessage() => $e->getUserMessage()] ];

            $response = $this->render('post.twig', $data);
            return $response;

        }



    }



    /**Permet d'ajouter un nouveau post
     * @return mixed
     */
    public function addPost()
    {
        $result = $this->request->getPost();
        $post = new Post();
        $post->hydrate($result);
        $post->setUserId('1');
        $post->setUpdateDate(date("Y-m-d H:i:s"));
        $this->getManager(Post::class)->insert();
        $response = $this->route->redirect('createPost',302);
        return $response;
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