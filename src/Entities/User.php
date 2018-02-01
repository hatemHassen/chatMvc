<?php

namespace Chat\Entities;

class User extends Entity
{

    protected $username;
    protected $password;
    protected $confirmPassword;

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param string $confirmPassword
     * @return $this
     */
    public function setConfirmPassword($confirmPassword)
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    /**
     * @return $this
     */
    public function cryptPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        return $this;
    }

    public function toArray()
    {
        $attributes = get_object_vars($this);
        unset($attributes['confirmPassword']);

        return $attributes;
    }
}