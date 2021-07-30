<?php

declare(strict_types=1);

namespace models;

class UserManager
{
    private $PHPDataObject;

    public function __construct(){
        $database = new Database();
        $this->PHPDataObject = $database;
    }
    public function Set_user_right($users_need_modify,$users_valided,$users_is_admin)
    {
        $sql = "UPDATE `user` SET `valided` = ?, `is_admin` = ? WHERE `user`.`id` = ?"; 
        $prepare = $this->PHPDataObject->prepare($sql);
        foreach($users_need_modify as $user_need_modify)
        {
            if (in_array($user_need_modify, $users_valided))
            {$valided = 1;}else{$valided = 0;}
            if (in_array($user_need_modify, $users_is_admin))
            {$is_admin = 1;}else{$is_admin = 0;}
            $prepare->execute([$valided,$is_admin,$user_need_modify]);
        }
    }
    public function Get_All_Users()
    {
        $sql = "Select * FROM user";
        $users = [];
        try{
            $prepare = $this->PHPDataObject->prepare($sql);
            $prepare->execute();
            while ($fetch = $prepare->fetch()){
                $user = new User();
                $user->Set_id((int)$fetch['id']);
                $user->Set_firstname($fetch['firstname']);
                $user->Set_lastname($fetch['lastname']);
                $user->Set_login($fetch['login']);
                $user->Set_password($fetch['password']);
                $user->Set_valided((int)$fetch['valided']);
                $user->Set_is_admin((int)$fetch['is_admin']);
                array_push($users,$user->To_array());
            }

        }catch(Exception $e) {
            return false;
        }
        return $users;
    }

    public function Create_user($firstname, $lastname, $login, $password):bool
    {
        $sql = "INSERT INTO `user` (`firstname`,`lastname`, `login`, `password`) VALUES (?,?, ?, ?) ";

        try{
            $this->PHPDataObject->beginTransaction();
            $prepare = $this->PHPDataObject->prepare($sql);
            $execute = $prepare->execute([$firstname,$lastname,$login,$password]);
            $this->PHPDataObject->commit();
            
        }catch(Exception $e) {
            $this->PHPDataObject->rollback();
            
            return false;
        }
        if ($execute){
            return true;
        }
        return false;
        
        
    }
    public function Get_User($login):User
    {
        $sql = "Select * FROM user WHERE login = ?";
        $user = new User();
        try{
            $prepare = $this->PHPDataObject->prepare($sql);
            $prepare->execute([$login]);
            $fetch = $prepare->fetch();
            $user->Set_id((int)$fetch['id']);
            $user->Set_firstname($fetch['firstname']);
            $user->Set_lastname($fetch['lastname']);
            $user->Set_login($fetch['login']);
            $user->Set_password($fetch['password']);
        }catch(Exception $e) {
            return false;
        }
        return $user;
    }
    public function Logging_user($login,$password)
    {
        $user = $this->Get_User($login);
        if (!($user->Get_password()) == $password){
            return false;
        }else{
            $_SESSION['isLog'] = true;
            $_SESSION['user_id'] = $user->Get_id();
            $_SESSION['firstname'] = $user->Get_firstname();
            $_SESSION['lastname'] = $user->Get_lastname();
            $_SESSION['login'] = $user->Get_login();
        
            return true;
        }
    }

}
