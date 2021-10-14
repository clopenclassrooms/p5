<?php

declare(strict_types=1);

namespace Models;

use Exception;

class UserManager
{
    private $superGlobal;
    private $PHPDataObject;

    public function __construct()
    {
        $this->superGlobal = new SuperGlobal;
        $database = new Database();
        $this->PHPDataObject = $database;
    }
    public function setUserRight($users_need_modify, $users_valided, $users_is_admin)
    {
        $sql = "UPDATE `user` SET `valided` = ?, `is_admin` = ? WHERE `user`.`id` = ?";
        $prepare = $this->PHPDataObject->prepare($sql);
        foreach ($users_need_modify as $user_need_modify) {
            $valided = 0;
            if (in_array($user_need_modify, $users_valided)) {
                $valided = 1;
            }
            $isAdmin = 0;
            if (in_array($user_need_modify, $users_is_admin)) {
                $isAdmin = 1;
            }
            $prepare->execute([$valided,$isAdmin,$user_need_modify]);
        }
    }
    public function getAllUsers()
    {
        $sql = "Select * FROM user";
        $users = [];
        try {
            $prepare = $this->PHPDataObject->prepare($sql);
            $prepare->execute();
            while ($fetch = $prepare->fetch()) {
                $user = new User();
                $user->setId((int)$fetch['id']);
                $user->setFirstname($fetch['firstname']);
                $user->setLastname($fetch['lastname']);
                $user->setLogin($fetch['login']);
                $user->setPassword($fetch['password']);
                $user->setValided((int)$fetch['valided']);
                $user->setIsAdmin((int)$fetch['is_admin']);
                array_push($users, $user->toArray());
            }
        } catch (Exception $e) {
            return false;
        }
        return $users;
    }
    public function createUser($firstname, $lastname, $login, $password):bool
    {
        $sql = "INSERT INTO `user` (`firstname`,`lastname`, `login`, `password`) VALUES (?,?, ?, ?) ";

        try {
            $this->PHPDataObject->beginTransaction();
            $prepare = $this->PHPDataObject->prepare($sql);
            $execute = $prepare->execute([$firstname,$lastname,$login,$password]);
            $this->PHPDataObject->commit();
        } catch (Exception $e) {
            $this->PHPDataObject->rollback();
            
            return false;
        }
        if ($execute) {
            return true;
        }
        return false;
    }
    public function getUser($login):?User
    {
        $sql = "Select * FROM user WHERE login = ?";
        $user = new User();
        try {
            $prepare = $this->PHPDataObject->prepare($sql);
            $prepare->execute([$login]);
            $fetch = $prepare->fetch();
            if($fetch){
                $user->setId((int)$fetch['id']);
                $user->setFirstname($fetch['firstname']);
                $user->setLastname($fetch['lastname']);
                $user->setLogin($fetch['login']);
                $user->setPassword($fetch['password']);
                $user->setIsAdmin((int)$fetch['is_admin']);
                $user->setValided((int)$fetch['valided']);
            }else{
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
        return $user;
    }
    public function loggingUser($login, $password)
    {
        $user = $this->getUser($login);
        if ($user != null and $user->getPassword() == $password and $user->getValided()) {
            $this->superGlobal->setKey('SESSION', 'isLog', true);
            $this->superGlobal->setKey('SESSION', 'user_id', $user->getId());
            $this->superGlobal->setKey('SESSION', 'firstname', $user->getFirstname());
            $this->superGlobal->setKey('SESSION', 'lastname', $user->getLastname());
            $this->superGlobal->setKey('SESSION', 'login', $user->getId());
            $this->superGlobal->setKey('SESSION', 'is_admin', $user->getIsAdmin());
            return true;
        }
        return false;
    }
}
