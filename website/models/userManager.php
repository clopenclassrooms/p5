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
            $user->Set_id(intval($fetch['id']));
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
