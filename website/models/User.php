<?php

namespace Models;
 
class User
{
    private int $userId;

    private string $firstname;
    private string $lastname;
    private string $login;
    private string $password;
    private string $valided;
    private string $isAdmin;


    public function toArray():array
    {
        $array = [
                    'user_id' => $this->userId, 
                    'firstname' => $this->firstname,
                    'lastname' => $this->lastname,
                    'login' => $this->login,
                    'valided' => $this->valided,
                    'is_admin' => $this->isAdmin,
                 ];
        return $array;
    }
    // GETTERS //
    public function getValided()
    {
        return $this->valided;
    }
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }
    public function getId()
    {
        return $this->userId;
    }
 
    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getPassword()
    {
        return $this->password;
    }
 
    // SETTERS //
    public function setValided($valided)
    {
        if (!is_integer($valided)) {
            throw new \RuntimeException('the variable valided must be an integer');
        }
 
        $this->valided = $valided;
    }
    public function setIsAdmin($isAdmin)
    {
        if (!is_integer($isAdmin)) {
            throw new \RuntimeException('the variable isAdmin must be an integer');
        }
 
        $this->isAdmin = $isAdmin;
    }
    public function setId($userId)
    {
        if (!is_integer($userId)) {
            throw new \RuntimeException('the variable userId must be an integer');
        }
 
        $this->userId = $userId;
    }

    public function setFirstname(string $firstname)
    {
        if (!is_string($firstname) || empty($firstname)) {
            throw new \RuntimeException('the variable title must be an string and not empty');
        }
 
        $this->firstname = $firstname;
    }
    public function setLastname(string $lastname)
    {
        if (!is_string($lastname) || empty($lastname)) {
            throw new \RuntimeException('the variable title must be an string and not empty');
        }
 
        $this->lastname = $lastname;
    }
    public function setLogin($login)
    {
        if (!is_string($login) || empty($login)) {
            throw new \RuntimeException('the variable leadParagraph must be an string and not empty');
        }
 
        $this->login = $login;
    }

    public function setPassword($password)
    {
        if (!is_string($password) || empty($password)) {
            throw new \RuntimeException('the variable content must be an string and not empty');
        }
 
        $this->password = $password;
    }

}
