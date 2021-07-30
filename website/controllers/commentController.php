<?php

namespace controllers;

use models\CommentManager;

class CommentController
{
    public function Display_comments_for_validation()
    {
        $commentManager = new CommentManager;
        $comments = $commentManager->Display_comments_for_validation();
        $is_log = $_SESSION['isLog'];
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
            'debug' => true,
        ]);

        ?><?= $twig->render('comments_for_validation.twig',[
                                                            'comments' => $comments,
                                                            'isLog' => $is_log,
                                                            'firstname' => $_SESSION['firstname'],
                                                           ]); ?><?php
    }
    public function comment_validation($comments_valided)
    {
        $commentManager = new CommentManager;
        $check_validation = $commentManager->comment_validation($comments_valided);
        $is_log = $_SESSION['isLog'];
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
            'debug' => true,
        ]);
        ?><?= $twig->render('comment_validation_result.twig',[
                                                            'check_validation' => $check_validation,
                                                            'isLog' => $is_log,
                                                            'firstname' => $_SESSION['firstname'],
                                                            ]); ?><?php
    }
}