<?php

namespace controllers;

use models\CommentManager;

session_start();

class CommentController
{
    public function Display_comments_for_validation()
    {
        $commentManager = new CommentManager;
        $comments = $commentManager->Display_comments_for_validation();
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
            'debug' => true,
        ]);
        echo $twig->render('comments_for_validation.twig',['comments' => $comments]); 
    }
    public function comment_validation($comments_valided)
    {
        $commentManager = new CommentManager;
        $check_validation = $commentManager->comment_validation($comments_valided);
        if ($check_validation) {
            echo "<br>commentaires validé";
        }else
        {
            echo "<br>erreur de validation de commentaires";
        }
    }
}