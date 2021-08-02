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
        $values_send_to_twig = [
                                'comments' => $commentManager->Display_comments_for_validation(),
                                'admin_mode' => $this->$superGlobal->get_key('SESSION','admin_mode'),
                                'is_admin' => $this->$superGlobal->get_key('SESSION','is_admin'),
                                'isLog' => $this->$superGlobal->get_key('SESSION','isLog'),
                                'firstname' => $this->$superGlobal->get_key('SESSION','firstname'),
                               ];

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
            'debug' => true,
        ]);
        $escaper = new \Twig\Extension\EscaperExtension('html');
        $twig->addExtension($escaper);

        ?><?= $twig->render('comments_for_validation.twig',$values_send_to_twig); ?><?php
    }
    public function comment_validation($comments_valided)
    {
        $commentManager = new CommentManager;
        $values_send_to_twig = [
                                'check_validation' => $commentManager->comment_validation($comments_valided),
                                'admin_mode' => $this->$superGlobal->get_key('SESSION','admin_mode'),
                                'is_admin' => $this->$superGlobal->get_key('SESSION','is_admin'),
                                'isLog' => $this->$superGlobal->get_key('SESSION','isLog'),
                                'firstname' => $this->$superGlobal->get_key('SESSION','firstname'),
                               ];

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
            'debug' => true,
        ]);
        $escaper = new \Twig\Extension\EscaperExtension('html');
        $twig->addExtension($escaper);
        ?><?= $twig->render('comment_validation_result.twig',$values_send_to_twig); ?><?php
    }
}