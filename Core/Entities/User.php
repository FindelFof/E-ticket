<?php

namespace App\Core\Entities;


class User
{
    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct($id,$name,$email, $password)
    {

        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    // Getters and setters...

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name ;
    }

    public function getEmail()
    {
        return $this->email ;
    }
    public function getPassword()
    {
        return $this->password;
    }

    // Other getters and setters...
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setId($id)
    {
        $this->id =$id;
    }



}
