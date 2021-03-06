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
        return ['table' => 'post', 'manager' => PostManager::class,
            'primaryKey'=> ['index' => 'id', 'type'  => 'integer'],
            'column'=> [
                'category_id' => ['index' => 'categoryId', 'type'  => 'integer', 'condition' => ['notNull']],
                'title' => ['index' => 'title', 'type' => 'string', 'condition' => ['notNull', 'maxChar50']],
                'content' => ['index' =>'content', 'type' => 'string', 'condition' => ['notNull']],
                'user_id' => ['index' =>'userId', 'type' => 'integer', 'condition' => ['notNull']],
                'update_date' => ['index' =>'updateDate', 'type' => 'datetime', 'condition' => ['notNull']],
                'preview_text' => ['index' =>'previewText', 'type' => 'string', 'condition' => ['notNull', 'maxChar300']]]];
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
     * @param $previewText
     */
    public function setPreviewText($previewText)
    {
        $this->previewText = $previewText;
    }

}



