<?php

namespace controllers;

use models\UserManager;
use models\SuperGlobal;
use views\DisplayHTML;

class UserController
{   
    private $superGlobal;
    private $displayHTML;

    public function __construct()
    {
        $this->superGlobal = new SuperGlobal;
        $this->displayHTML = new DisplayHTML;
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
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
            ];

        $this->displayHTML->displayHTML('Manage_user_right.twig',$values_send_to_twig);
    }

    public function Create_user($firstname, $lastname, $login, $password )
    {
        $userManager = new Usermanager;
        $result = $userManager->Create_user($firstname, $lastname, $login, $password);

        $values_send_to_twig = [
            'result' => $result,
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
            ];

        $this->displayHTML->displayHTML('userCreation_result.twig',$values_send_to_twig);
    }
    public function Get_user_creation_page()
    {
        $values_send_to_twig = [
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
            ];

        $this->displayHTML->displayHTML('userCreationPage.twig',$values_send_to_twig);
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