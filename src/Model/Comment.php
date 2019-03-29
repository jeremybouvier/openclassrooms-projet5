<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 16/02/19
 * Time: 21:48
 */

namespace Application\Model;



class Comment extends Manager
{

    private $id;
    private $postId;
    private $commentText;

    public function __construct()
    {
        $this->getModelColumn();
    }

    /**Fournit les index de la table
     * @return array
     */
    public static function getColumn()
    {

        return [
            'primaryKey'=> [
                'index' => 'id',
                'type'     => 'integer'],

            'column'=> [

                'post_id'=>[
                    'index' => 'postId',
                    'type'     => 'integer'],

                'comment_text' =>[
                    'index' =>'commentText',
                    'type'     => 'string']
            ]];
    }

    /**Hydration de la class
     * @param array $data
     */
    public function hydrate(array $data)

    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }


    }

    /** Hydratation de la class par la méthode magique SET
     * @param mixed $data
     *
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
        $this->indexColumn['id'] = $id;
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