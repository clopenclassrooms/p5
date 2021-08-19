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
    public function Display_homepage($sign_out = 0,$admin_mod = 0,$user_mode = 0)
    {
        $isLog = $this->superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->superGlobal->get_key('SESSION','is_admin');

        if ($sign_out == 1)
        {
            $this->superGlobal->set_key('SESSION','isLog',false);
            $this->superGlobal->set_key('SESSION','is_admin',false);
            $this->superGlobal->set_key('SESSION','admin_mode',false);
        }
        if ($isLog && $admin_mod == 1 && $is_admin )
        {
            $this->superGlobal->set_key('SESSION','admin_mode',true);
        }
        if ($isLog && $user_mode == 1 && $is_admin )
        {
            $this->superGlobal->set_key('SESSION','admin_mode',false);
        }
        if (!$isLog){
            $this->superGlobal->set_key('SESSION','isLog',false);
            $this->superGlobal->set_key('SESSION','is_admin',false);
            $this->superGlobal->set_key('SESSION','admin_mode',false);
        }

        $values_send_to_twig = [
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
           ];

        $this->displayHTML->displayHTML('homepage.twig',$values_send_to_twig);

    }
}