<?php

namespace Application\Model;


use Application\Manager\PostManager;
use Framework\Model;

/**
 * Class Post
 * @package Application\Model
 */
class Post extends Model
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $categoryId;

    /**
     * @var
     */
    private $title;

    /**
     * @var
     */
    private $content;

    /**
     * @var
     */
    private $userId;

    /**
     * @var
     */
    private $updateDate;

    /**
     * @var
     */
    private $previewText;

    /** Hydratation de la class par la méthode magique SET
     * @param $key
     * @param $value
     * @throws \Application\Controller\ControllerException
     */
    public function __set($key, $value)
    {
        $data[$this::getColumn()['column'][$key]['index']] = $value;
        $this->hydrate($data);
    }

    /**Fournit les index de la table
     * @return array
     */
    public static function getColumn()
    {
        return [
            'table' => 'post',

            'manager'=>PostManager::class,

            'primaryKey'=> [
                'index' => 'id',
                'type'     => 'integer'],

            'column'=> [

                'category_id'=>[
                    'index' => 'categoryId',
                    'type'     => 'integer',
                    'condition' => ['not null']],

                'title' =>[
                    'index' =>'title',
                    'type'     => 'string',
                    'condition' => ['not null', 'max char 30']],

                'content' =>[
                    'index' =>'content',
                    'type'     => 'string',
                    'condition' => ['not null']],

                'user_id' =>[
                    'index' =>'userId',
                    'type'     => 'integer',
                    'condition' => ['not null']],

                'update_date' =>[
                    'index' =>'updateDate',
                    'type'     => 'datetime',
                    'condition' => []],

                'preview_text' =>[
                    'index' =>'previewText',
                    'type'     => 'string',
                    'condition' => ['not null']]
            ]];
    }

    /**
     * @return PostManager|mixed
     */
    public static function getManager()
    {
        return self::getColumn()['manager'];
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
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
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
    public function getPreviewText()
    {
        return $this->previewText;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        $this->setPreviewText();

    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param $updateDate
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;
    }

    /**
     *
     */
    public function setPreviewText()
    {
        $this->previewText = substr($this->content, 0, 300 - strlen($this->content));
    }
}



