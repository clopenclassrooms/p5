<?php

namespace controllers;

use models\CommentManager;
use models\SuperGlobal;

class CommentController
{
    Public function __construct()
    {
        $this->$superGlobal = new SuperGlobal;
    }
    public function Display_comments_for_validation()
    {
        $commentManager = new CommentManager;
        $comments = $commentManager->Display_comments_for_validation();
        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
            'debug' => true,
        ]);

        ?><?= $twig->render('comments_for_validation.twig',[
                                                            'comments' => $comments,
                                                            'admin_mode' => $admin_mode,
                                                            'is_admin' => $is_admin,
                                                            'isLog' => $isLog,
                                                            'firstname' => $firstname,
                                                           ]); ?><?php
    }
    public function comment_validation($comments_valided)
    {
        $commentManager = new CommentManager;
        $check_validation = $commentManager->comment_validation($comments_valided);
        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
            'debug' => true,
        ]);
        ?><?= $twig->render('comment_validation_result.twig',[
                                                            'check_validation' => $check_validation,
                                                            'admin_mode' => $admin_mode,
                                                            'is_admin' => $is_admin,
                                                            'isLog' => $isLog,
                                                            'firstname' => $firstname,
                                                            ]); ?><?php
    }
}