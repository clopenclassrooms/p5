<?php

namespace Controllers;

use Models\CommentManager;
use Models\SuperGlobal;
use Views\DisplayHTML;

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
    public function displayCommentsForValidation()
    {
        $isAdmin = $this->superGlobal->getKey('SESSION','is_admin');
        if ($isAdmin){
            $valuesSendToTwig = [
                'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
                'is_admin' => $isAdmin,
                'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
                'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
                'comments' => $this->commentManager->displayCommentsForValidation(),
                ];
            $this->displayHTML->displayHTML('comments_for_validation.twig',$valuesSendToTwig);
        }else{
            $this->superGlobal->destroy('SESSION');
            $controler = new HomepageController;
            $controler->displayHomepage();
        }
        
    }
    public function commentValidation($commentsValided)
    {
        $isAdmin = $this->superGlobal->getKey('SESSION','is_admin');
        if ($isAdmin){
            $valuesSendToTwig = [
                'check_validation' => $this->commentManager->commentValidation($commentsValided),
                'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
                'is_admin' => $isAdmin,
                'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
                'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
                ];
            $this->displayHTML->displayHTML('comment_validation_result.twig',$valuesSendToTwig);
        }else{
            $this->superGlobal->destroy('SESSION');
            $controler = new HomepageController;
            $controler->displayHomepage();
        }
    }
}