<?php

namespace Application\Model ;


use Application\Manager\RoleManager;
use Framework\Model;

class Role extends Model
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
     * @return array
     */
    public static function getColumn()
    {
        return ['table' => 'role', 'manager' => RoleManager::class,
            'primaryKey' => ['index' => 'id', 'type' => 'integer'],
            'column' => [
                'name' => ['index' => 'name', 'type' => 'string', 'condition' => ['not null', 'max char 30']]]];
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
}