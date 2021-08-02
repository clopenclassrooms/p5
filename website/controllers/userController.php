<?php

namespace controllers;

use models\UserManager;
use models\SuperGlobal;
use views\DisplayHTML;

session_start();

class UserController
{    Public function __construct()
    {
        $this->$superGlobal = new SuperGlobal;
    }
    public function Manage_user_right($change_right = 0,$users_from_post = [],$user_valided = [],$user_is_admin = [])
    {
        $userManager = new Usermanager;
        if ($change_right)
        {
            $userManager->Set_user_right($users_from_post,$user_valided,$user_is_admin);
        }

        $users = $userManager->Get_All_Users(); 

        $values_send_to_twig = [
            'users' => $users,
            'change_right' => $change_right,
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
            ];

        DisplayHTML::displayHTML('Manage_user_right.twig',$values_send_to_twig);
    }

    public function Create_user($firstname, $lastname, $login, $password )
    {
        $userManager = new Usermanager;
        $result = $userManager->Create_user($firstname, $lastname, $login, $password);

        $values_send_to_twig = [
            'result' => $result,
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
            ];

        DisplayHTML::displayHTML('userCreation_result.twig',$values_send_to_twig);
    }
    public function Get_user_creation_page()
    {
        $values_send_to_twig = [
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
            ];

        DisplayHTML::displayHTML('userCreationPage.twig',$values_send_to_twig);
    }

    public function Logging_user($login,$password)
    {
        $userManager = new Usermanager;
        $result = $userManager->Logging_user($login, $password);
        if ($result){
            return true;
        }
        return false;
    }
}