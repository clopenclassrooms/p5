<?php

namespace controllers;

use models\CommentManager;
use models\SuperGlobal;
use views\DisplayHTML;

class CommentController
{
    private $superGlobal;
    private $displayHTML;
    private $commentManager;

    public function __construct()
    {
        $this->superGlobal = new SuperGlobal;
        $this->displayHTML = new DisplayHTML;
        $this->commentManager = new CommentManager;
        
    }
    public function Display_comments_for_validation()
    {
        $is_admin = $this->superGlobal->get_key('SESSION','is_admin');
        if ($is_admin){
            $values_send_to_twig = [
                'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
                'is_admin' => $is_admin,
                'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
                'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
                'comments' => $this->commentManager->Display_comments_for_validation(),
                ];
            $this->displayHTML->displayHTML('comments_for_validation.twig',$values_send_to_twig);
        }else{
            $this->superGlobal->destroy('SESSION');
            $controler = new HomepageController;
            $controler->Display_homepage();
        }
        
    }
    public function comment_validation($comments_valided)
    {
        $is_admin = $this->superGlobal->get_key('SESSION','is_admin');
        if ($is_admin){
            $values_send_to_twig = [
                'check_validation' => $this->commentManager->comment_validation($comments_valided),
                'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
                'is_admin' => $is_admin,
                'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
                'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
                ];
            $this->displayHTML->displayHTML('comment_validation_result.twig',$values_send_to_twig);
        }else{
            $this->superGlobal->destroy('SESSION');
            $controler = new HomepageController;
            $controler->Display_homepage();
        }
    }
}