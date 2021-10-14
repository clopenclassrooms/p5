<?php

namespace Controllers;

use Models\PostManager;
use Models\SuperGlobal;
use Views\DisplayHTML;

class HomepageController
{
    private $superGlobal;
    private $displayHTML;

    public function __construct()
    {
        $this->superGlobal = new SuperGlobal;
        $this->displayHTML = new DisplayHTML;
    }
    public function displayHomepage($sign_out = 0,$adminMode = 0,$userMode = 0)
    {
        $isLog = $this->superGlobal->getKey('SESSION','isLog');
        $isAdmin = $this->superGlobal->getKey('SESSION','is_admin');

        if ($sign_out == 1)
        {
            $this->superGlobal->setKey('SESSION','isLog',false);
            $this->superGlobal->setKey('SESSION','is_admin',false);
            $this->superGlobal->setKey('SESSION','admin_mode',false);
        }
        if ($isLog && $adminMode == 1 && $isAdmin )
        {
            $this->superGlobal->setKey('SESSION','admin_mode',true);
        }
        if ($isLog && $userMode == 1 && $isAdmin )
        {
            $this->superGlobal->setKey('SESSION','admin_mode',false);
        }
        if (!$isLog){
            $this->superGlobal->setKey('SESSION','isLog',false);
            $this->superGlobal->setKey('SESSION','is_admin',false);
            $this->superGlobal->setKey('SESSION','admin_mode',false);
        }

        $valuesSendToTwig = [
            'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->getKey('SESSION','is_admin'),
            'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
            'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
           ];

        $this->displayHTML->displayHTML('homepage.twig',$valuesSendToTwig);

    }
}