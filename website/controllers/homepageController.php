<?php

namespace controllers;

use models\PostManager;

session_start();

class HomepageController
{
    public function Display_homepage()
    {
        $postManager = new PostManager();
        $posts = $postManager->Get_Posts();

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
            'debug' => true,
        ]);
        echo $twig->render('homepage.twig',[
                                            'isLog' => $_SESSION['isLog'],
                                            'firstname' => $_SESSION['firstname'],
                                            'posts' => $posts
                                           ]);
    }
}