<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 16/02/19
 * Time: 21:34
 */

namespace Application\Model;


use Application\Manager\UserManager;
use Framework\Model;

class User extends Model
{
    private $id;
    private $roleId;
    private $surname;
    private $firstname;
    private $email;
    private $loginName;
    private $password;


    public static function getColumn()
    {
        return [
            'table' => 'user',

            'manager'=>UserManager::class,

            'primaryKey'=> [
                'index' => 'id',
                'type'     => 'integer'],

            'column'=> [

                'role_id'=>[
                    'index' => 'roleId',
                    'type'     => 'integer',
                    'condition' => ['not null']],
                'surname'=>[
                    'index' => 'surname',
                    'type'     => 'string',
                    'condition' => ['not null', 'max char 30']],
                'first_name'=>[
                    'index' => 'firstname',
                    'type'     => 'string',
                    'condition' => ['not null', 'max char 30']],
                'email'=>[
                    'index' => 'email',
                    'type'     => 'string',
                    'condition' => ['not null']],
                'login_name'=>[
                    'index' => 'loginName',
                    'type'     => 'string',
                    'condition' => ['not null', 'max char 30']],
                'password'=>[
                    'index' => 'password',
                    'type'     => 'string',
                    'condition' => ['not null', 'max char 10']]
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
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
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
    public function getLoginName()
    {
        return $this->loginName;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $roleId
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $loginName
     */
    public function setLoginName($loginName)
    {
        $this->loginName = $loginName;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }


}