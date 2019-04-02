<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 16/02/19
 * Time: 21:48
 */

namespace Application\Model;


use Application\Manager\CommentManager;

/**
 * Class Comment
 * @package Application\Model
 */
class Comment extends Model//\Application\Manager\Manager
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
                    'type'     => 'string'],

                'update_date' =>[
                    'index' =>'updateDate',
                    'type'     => 'datetime']
            ]];
    }

    /**
     * @param $model
     * @param $database
     * @return CommentManager|mixed
     */
    public static function getManager($model, $database)
    {
        return new CommentManager($model, $database);
    }


    /** Hydratation de la class par la méthode magique SET
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



}