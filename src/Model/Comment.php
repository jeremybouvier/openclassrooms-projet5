<?php

namespace Application\Model;


use Application\Manager\CommentManager;
use Framework\Model;


/**
 * Class Comment
 * @package Application\Model
 */
class Comment extends Model
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $postId;

    /**
     * @var
     */
    private $commentText;

    /**
     * @var
     */
    private $updateDate;

    /**
     * @var
     */
    private $author;

    /**
     * @var
     */
    private $validation = 0;



    /**Fournit les index de la table
     * @return array
     */
    public static function getColumn()
    {
        return ['table' => 'comment', 'manager'=>CommentManager::class,
            'primaryKey'=> ['index' => 'id', 'type' => 'integer'],
            'column'=> [
                'post_id' => ['index' => 'postId', 'type' => 'integer', 'condition' => ['notNull']],
                'comment_text' => ['index' =>'commentText', 'type' => 'string', 'condition' => ['notNull', 'maxChar250']],
                'update_date' => ['index' =>'updateDate', 'type' => 'datetime', 'condition' => ['notNull']],
                'author' => ['index' =>'author', 'type'  => 'string', 'condition' => ['notNull', 'maxChar30']],
                'validation' => ['index' => 'validation', 'type' => 'boolean', 'condition' => ['notNull']]]];
    }

    /**
     * @return mixed
     */
    public static function getManager()
    {
        return self::getColumn()['manager'] ;

    }


    /**Hydratation de la class par la méthode magique SET
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $data[$this::getColumn()['column'][$key]['index']] = $value;
        $this->hydrate($data);
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
     * @return mixed
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return mixed
     */
    public function getValidation()
    {
        return $this->validation;
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

    /**
     * @param mixed $updateDate
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @param mixed $validation
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    }



}