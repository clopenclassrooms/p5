<?php

namespace controllers;

use models\CommentManager;
use models\SuperGlobal;
use views\DisplayHTML;

class CommentController
{
    public function Display_comments_for_validation()
    {
        $commentManager = new CommentManager;
        $values_send_to_twig = [
            'comments' => $commentManager->Display_comments_for_validation(),
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
            ];

        DisplayHTML::displayHTML('comments_for_validation.twig',$values_send_to_twig);
    }
    public function comment_validation($comments_valided)
    {
        $commentManager = new CommentManager;
        $values_send_to_twig = [
            'check_validation' => $commentManager->comment_validation($comments_valided),
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
            ];

        DisplayHTML::displayHTML('comment_validation_result.twig',$values_send_to_twig);
    }
}