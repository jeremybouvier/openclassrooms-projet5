<?php
/**

 * User: jeremy
 * Date: 15/02/19
 * Time: 21:15
 */

namespace Application\Model;


class Post extends Table
{

    private $id;
    private $categoryId;
    private $title;
    private $content;
    private $userId;
    private $lastModifactionDate;
    private $previewText;

    /**
     * @param mixed $data
     */


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
    public function getLastModifactionDate()
    {
        return $this->lastModifactionDate;
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
        $this->previewText = substr($this->content, 0, 100);
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param mixed $lastModifactionDate
     */
    public function setLastModifactionDate($lastModifactionDate)
    {
        $this->lastModifactionDate = $lastModifactionDate;
    }

}



