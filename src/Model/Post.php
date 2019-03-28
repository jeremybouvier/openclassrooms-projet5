<?php
/**

 * User: jeremy
 * Date: 15/02/19
 * Time: 21:15
 */

namespace Application\Model;


class Post extends Manager
{

    private $id;
    private $categoryId;
    private $title;
    private $content;
    private $userId;
    private $updateDate;
    private $previewText;

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

                'category_id'=>[
                    'index' => 'categoryId',
                    'type'     => 'integer'],

                'title' =>[
                    'index' =>'title',
                    'type'     => 'string'],

                'content' =>[
                    'index' =>'content',
                    'type'     => 'string'],

                'user_id' =>[
                    'index' =>'userId',
                    'type'     => 'integer'],

                'update_date' =>[
                    'index' =>'updateDate',
                    'type'     => 'date'],

                'preview_text' =>[
                    'index' =>'previewText',
                    'type'     => 'string'],


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
     * @param mixed $previewText
     */
    public function setPreviewText($previewText)
    {
        $this->previewText = $previewText;
    }

}



