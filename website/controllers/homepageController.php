<?php

namespace controllers;

use models\PostManager;
use models\SuperGlobal;

class HomepageController
{
    public function __construct()
    {
        $this->$superGlobal = new SuperGlobal;
    }
    public function Display_homepage($sign_out = 0,$admin_mod = 0,$user_mode = 0)
    {
        $isLog = $this->$SuperGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');

        if ($sign_out == 1)
        {
            $this->$superGlobal->set_key('SESSION','isLog',false);
            $this->$superGlobal->set_key('SESSION','is_admin',false);
            $this->$superGlobal->set_key('SESSION','admin_mode',false);
        }
        if ($isLog && $admin_mod == 1 && $is_admin )
        {
            $this->$superGlobal->set_key('SESSION','admin_mode',true);
        }
        if ($isLog && $user_mode == 1 && $is_admin )
        {
            $this->$superGlobal->set_key('SESSION','admin_mode',false);
        }
        if (!$isLog){
            $this->$superGlobal->set_key('SESSION','isLog',false);
            $this->$superGlobal->set_key('SESSION','is_admin',false);
            $this->$superGlobal->set_key('SESSION','admin_mode',false);
        }
        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');

        $postManager = new PostManager();
        $posts = $postManager->Get_Posts();

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
            'debug' => true,
        ]);
        echo $twig->render('homepage.twig',[
                                            'posts' => $posts,
                                            'admin_mode' => $admin_mode,
                                            'is_admin' => $is_admin,
                                            'isLog' => $isLog,
                                            'firstname' => $firstname,
                                           ]);
    }
}