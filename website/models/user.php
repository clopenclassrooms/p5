<?php

namespace models;
 
session_start();
 
class User
{
    private int $user_id;

    private string $firstname;
    private string $lastname;
    private string $login;
    private string $password;



    Public function __construct()
    {

    }

    public function To_array():array
    {
        $array = ['id' => $this->user_id, 'login' => $this->login];
        return $array;
    }

    // GETTERS //
    public function Get_id()
    {
        return $this->user_id;
    }
 
    public function Get_firstname()
    {
        return $this->firstname;
    }

    public function Get_lastname()
    {
        return $this->lastname;
    }

    public function Get_login()
    {
        return $this->login;
    }

    public function Get_password()
    {
        return $this->password;
    }
 
    // SETTERS //
    public function Set_id($user_id)
    {
        if (!is_integer($user_id)  || empty($user_id)) {
            throw new \RuntimeException('the variable id must be an integer and empty');
        }
 
        $this->user_id = $user_id;
    }

    public function Set_firstname(string $firstname)
    {
        if (!is_string($firstname) || empty($firstname)) {
            throw new \RuntimeException('the variable title must be an string and not empty');
        }
 
        $this->firstname = $firstname;
    }
    public function Set_lastname(string $lastname)
    {
        if (!is_string($lastname) || empty($lastname)) {
            throw new \RuntimeException('the variable title must be an string and not empty');
        }
 
        $this->lastname = $lastname;
    }
    public function Set_login($login)
    {
        if (!is_string($login) || empty($login)) {
            throw new \RuntimeException('the variable leadParagraph must be an string and not empty');
        }
 
        $this->login = $login;
    }

    public function Set_password($password)
    {
        if (!is_string($password) || empty($password)) {
            throw new \RuntimeException('the variable content must be an string and not empty');
        }
 
        $this->password = $password;
    }

}
