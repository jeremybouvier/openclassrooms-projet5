<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 24/04/19
 * Time: 22:51
 */

namespace Application\Model;


use Framework\Model;

class Mail extends Model
{
    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $name;

    /**
     * @var
     */
    private $email;

    /**
     * @var
     */
    private $subject;

    /**
     * @var
     */
    private $message;

    /**Fournit les index de la table
     * @return array
     */
    public static function getColumn()
    {
        return [
            'table' => null,

            'manager'=>null,

            'primaryKey'=> [
                'index' => 'id',
                'type'     => 'integer'],

            'column'=> [

                'name'=>[
                    'index' => 'name',
                    'type'     => 'string',
                    'condition' => ['not null', 'max char 30']],
                'email'=>[
                    'index' => 'email',
                    'type'     => 'string',
                    'condition' => ['not null', 'max char 30']],
                'subject'=>[
                    'index' => 'subject',
                    'type'     => 'string',
                    'condition' => ['not null', 'max char 30']],
                'message'=>[
                    'index' => 'message',
                    'type'     => 'string',
                    'condition' => ['not null']]
            ]];
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }
}