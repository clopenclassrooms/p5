<?php

namespace controllers;

use models\PostManager;
use models\SuperGlobal;
use views\DisplayHTML;

class HomepageController
{
    public function Display_homepage($sign_out = 0,$admin_mod = 0,$user_mode = 0)
    {
        $isLog = SuperGlobal::get_key('SESSION','isLog');
        $is_admin = SuperGlobal::get_key('SESSION','is_admin');

        if ($sign_out == 1)
        {
            SuperGlobal::set_key('SESSION','isLog',false);
            SuperGlobal::set_key('SESSION','is_admin',false);
            SuperGlobal::set_key('SESSION','admin_mode',false);
        }
        if ($isLog && $admin_mod == 1 && $is_admin )
        {
            SuperGlobal::set_key('SESSION','admin_mode',true);
        }
        if ($isLog && $user_mode == 1 && $is_admin )
        {
            SuperGlobal::set_key('SESSION','admin_mode',false);
        }
        if (!$isLog){
            SuperGlobal::set_key('SESSION','isLog',false);
            SuperGlobal::set_key('SESSION','is_admin',false);
            SuperGlobal::set_key('SESSION','admin_mode',false);
        }

        $postManager = new PostManager();
        $values_send_to_twig = [
            'posts' => $postManager->Get_Posts(),
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
           ];

        DisplayHTML::displayHTML('homepage.twig',$values_send_to_twig);

    }
}