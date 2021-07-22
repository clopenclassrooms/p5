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
        ?><?= esc_html__($twig->render('comments_for_validation.twig',['comments' => $comments])); ?><?php
    }
    public function comment_validation($comments_valided)
    {
        $commentManager = new CommentManager;
        $check_validation = $commentManager->comment_validation($comments_valided);
        if ($check_validation) {
            return true;
        }
        return false;
    }
}