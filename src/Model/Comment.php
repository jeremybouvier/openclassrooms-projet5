<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 16/02/19
 * Time: 21:48
 */

namespace Application\Model;



class Comment extends Table
{

    private $id;
    private $postId;
    private $commentText;

    /**
     * @param mixed $data
     */
    /**
     * hydratation de la class par la méthode magique SET
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $word = explode('_',$key);
        $key = $word[0] . ucfirst($word[1]);
        $method = 'set' .ucfirst($key);
        $this->$method($value);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * @return mixed
     */
    public function getCommentText()
    {
        return $this->commentText;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $postId
     */
    public function setPostId($postId)
    {
        $this->postId = $postId;
    }

    /**
     * @param mixed $commentText
     */
    public function setCommentText($commentText)
    {
        $this->commentText = $commentText;
    }

}