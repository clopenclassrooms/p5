<?php

namespace controllers;

use models\UserManager;

session_start();

class UserController
{
    public function Create_user($firstname, $lastname, $login, $password )
    {
        $userManager = new Usermanager;
        $result = $userManager->Create_user($firstname, $lastname, $login, $password);
        if ($result){
            return true;
        }
        return false;

    }
    public function Get_user_creation_page()
    {
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        ?><?= esc_html__($twig->render('userCreationPage.twig')); ?><?php
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