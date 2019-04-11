<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 16/02/19
 * Time: 21:48
 */

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



    /**Fournit les index de la table
     * @return array
     */
    public static function getColumn()
    {
        return [
            'table' => 'comment',

            'manager'=>CommentManager::class,

            'primaryKey'=> [
                'index' => 'id',
                'type'     => 'integer'],

            'column'=> [

                'post_id'=>[
                    'index' => 'postId',
                    'type'     => 'integer',
                    'condition' => ['not null']],

                'comment_text' =>[
                    'index' =>'commentText',
                    'type'     => 'string',
                    'condition' => ['not null']],

                'update_date' =>[
                    'index' =>'updateDate',
                    'type'     => 'datetime',
                    'condition' => []],
                'author' =>[
                    'index' =>'author',
                    'type'     => 'string',
                    'condition' => ['not null', 'max char 20']]
            ]];
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
     * @throws \Application\Controller\ControllerException
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
    public function setUpdateDate($updateDate): void
    {
        $this->updateDate = $updateDate;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }



}