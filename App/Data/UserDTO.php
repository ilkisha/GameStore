<?php

namespace App\Data;


class UserDTO
{
    private $id;
    private $email;
    private $password;
    private $fullName;
    private $isAdmin;

    public static function create(
        $email, $password, $fullName, $isAdmin ,$id = null
    )
    {
        return (new self())
            ->setEmail($email)
            ->setPassword($password)
            ->setFullName($fullName)
            ->setIsAdmin($isAdmin)
            ->setId($id);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return UserDTO
     */
    public function setId($id): UserDTO
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return UserDTO
     */
    public function setEmail($email): UserDTO
    {
        $this->email = $email;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return UserDTO
     */
    public function setPassword($password): UserDTO
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param mixed $fullName
     * @return UserDTO
     */
    public function setFullName($fullName): UserDTO
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param mixed $isAdmin
     * @return UserDTO
     */
    public function setIsAdmin($isAdmin): UserDTO
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }
}