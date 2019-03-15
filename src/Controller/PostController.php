<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 26/02/19
 * Time: 23:03
 */

namespace Application\Controller;


use Application\Model\Post;
use Zend\Diactoros\Response\HtmlResponse;


class PostController extends Controller
{


    /**
     * @return HtmlResponse
     */
    public function getAllPost()
    {
        $htmlContent =  $this->templates('listpost.php', Post::getAll(),'Post');

        $response = new HtmlResponse($htmlContent);
        return $response;



    }


    /**
     * @param $id
     * @return HtmlResponse
     */
    public function getSinglePost($id)
    {
        $htmlContent = $this->templates('post.php',  Post::getSingle($id),'Post');

        $response = new HtmlResponse($htmlContent);
        return $response;

    }


}