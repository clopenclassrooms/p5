<?php

namespace controllers;

use models\UserManager;

session_start();

class UserController
{
    public function Manage_user_right($change_right = 0,$users_from_post = [],$user_valided = [],$user_is_admin = [])
    {
        $userManager = new Usermanager;
        if ($change_right)
        {
            $userManager->Set_user_right($users_from_post,$user_valided,$user_is_admin);
        }
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        $users = $userManager->Get_All_Users(); 
        $is_log = $_SESSION['isLog'];
        ?><?= $twig->render('Manage_user_right.twig',[
                                                    'isLog' => $is_log,
                                                    'firstname' => $_SESSION['firstname'],
                                                    'users' => $users,
                                                    'change_right' => $change_right,
                                                    ]); ?><?php
    }

    public function Create_user($firstname, $lastname, $login, $password )
    {
        $userManager = new Usermanager;
        $result = $userManager->Create_user($firstname, $lastname, $login, $password);

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        $is_log = $_SESSION['isLog'];
        ?><?= $twig->render('userCreation_result.twig',[
                                                    'isLog' => $is_log,
                                                    'firstname' => $_SESSION['firstname'],
                                                    'result' => $result,
                                                    ]); ?><?php
    }
    public function Get_user_creation_page()
    {
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        $is_log = $_SESSION['isLog'];
        ?><?= $twig->render('userCreationPage.twig',[
                                                    'isLog' => $is_log,
                                                    'firstname' => $_SESSION['firstname'],
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