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
            echo "<br>utilisateur créé";
        }else{
            echo "<br>utilisateur NON créé";
        }

    }
    public function Get_user_creation_page()
    {
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        echo $twig->render('userCreationPage.twig'); 
    }

    public function Logging_user($login,$password)
    {
        $userManager = new Usermanager;
        $result = $userManager->Logging_user($login, $password);
        if ($result){
            echo "<br>utilisateur logué";
        }else{
            echo "<br>utilisateur NON logué";
        }
        ?><br><a href='/'>retour a l'accueil</a><?php
    }
}