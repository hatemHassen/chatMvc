<?php
/**
 * Created by PhpStorm.
 * User: hatem
 * Date: 31/01/18
 * Time: 15:59
 */

namespace Chat\Entities;


abstract class Entity
{
    protected $id;

    /**
     * Entity constructor.
     * @var array $data
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return  $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method))
            {

                $this->$method($value);
            }
        }
    }

}