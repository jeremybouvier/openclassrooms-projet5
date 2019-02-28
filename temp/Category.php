<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 16/02/19
 * Time: 21:46
 */

namespace app;


class Category
{

    private $id;
    private $name;

    /**
     * @param mixed $data
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