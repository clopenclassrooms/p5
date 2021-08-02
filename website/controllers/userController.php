<?php

namespace controllers;

use models\UserManager;
use models\SuperGlobal;

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

        $firstname = $this->$superGlobal->get_key('SESSION','firstname');
        $users = $userManager->Get_All_Users(); 
        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);

        ?><?= $twig->render('Manage_user_right.twig',[
                                                    'admin_mode' => $admin_mode,
                                                    'is_admin' => $is_admin,
                                                    'isLog' => $isLog,
                                                    'firstname' => $firstname,
                                                    'users' => $users,
                                                    'change_right' => $change_right,
                                                    ]); ?><?php
    }

    public function Create_user($firstname, $lastname, $login, $password )
    {
        $userManager = new Usermanager;
        $result = $userManager->Create_user($firstname, $lastname, $login, $password);
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');
        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);

        ?><?= $twig->render('userCreation_result.twig',[
                                                    'admin_mode' => $admin_mode,
                                                    'is_admin' => $is_admin,
                                                    'isLog' => $isLog,
                                                    'firstname' => $firstname,
                                                    'result' => $result,
                                                    ]); ?><?php
    }
    public function Get_user_creation_page()
    {
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');
        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);

        ?><?= $twig->render('userCreationPage.twig',[
                                                    'admin_mode' => $admin_mode,
                                                    'is_admin' => $is_admin,
                                                    'isLog' => $isLog,
                                                    'firstname' => $firstname,
                                                    ]); ?><?php
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