<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 11/04/19
 * Time: 22:56
 */

namespace Application\Controller;


use Application\Model\Comment;
use Application\Model\Post;

use Framework\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {

        if ($this->request->getRequest()->getMethod() == "POST"){

            foreach ( $this->request->getPost() as $key =>$id){
                switch ($key){
                    case 'validComment':
                        $comment = $this->getManager(Comment::class)->fetch(['id'=>$id]);
                        $comment->setValidation(1);
                        $this->getManager(Comment::class)->update($comment, ['id'=>$id]);
                        break;
                    case 'deleteComment':
                        $this->getManager(Comment::class)->delete(['id'=>$id]);
                        break;
                    case 'updatePost':
                        return $this->redirect('editPostPage', 302, ['id'=>$id]);
                        break;
                    case 'createPost':
                        return $this->redirect('editPostPage', 302, ['id'=>$id]);
                        break;
                    case 'deletePost':
                        $this->getManager(Post::class)->delete(['id' => $id]);
                        $this->getManager(Comment::class)->delete(['post_id' => $id]);
                        break;
                }
            }

        }
        $post = $this->getManager( Post::class)->getAll();
        $comment = $this->getManager( Comment::class)
            ->fetchAll(['validation' => 0], ['update_date'], 100, 0);

        $data = [  'Post'=>$post,
                    'Comment'=> $comment
                ];
        return $this->render('admin.twig', $data);
    }


}