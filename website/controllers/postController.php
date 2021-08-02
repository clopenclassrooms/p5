<?php

namespace controllers;

use models\PostManager;
use models\CommentManager;
use models\SuperGlobal;

class PostController
{
    Public function __construct()
    {
        $this->$superGlobal = new SuperGlobal;
    }
    public function delete_posts($posts_id)
    {
        $postManager = new PostManager($posts_id);
        $result = $postManager->Delete_Posts($posts_id);
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
        ]);
        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');
        ?><?=  $twig->render('delete_posts_result.twig',[
                                              'result' => $result,
                                              'admin_mode' => $admin_mode,
                                              'is_admin' => $is_admin,
                                              'isLog' => $isLog,
                                              'firstname' => $firstname,
                                              ]); ?><?php
    }

    public function Display_post_delete_page()
    {
        $postManager = new PostManager();
        $posts = $postManager->Get_Posts();
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
        ]);
        ?><?=  esc_html__($twig->render('Display_post_delete_page.twig',['posts' => $posts])); ?><?php
    }
    public function Modify_post($post_id,$post_title,$post_leadParagraph,$post_content)
    {
        $postManager = new PostManager();
        $post_modificationDate = date("Y-m-d H:i:s");
        $result = $postManager->Modify_post($post_title,$post_leadParagraph,$post_content,$post_modificationDate, $post_id);

        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        ?><?=  $twig->render('editpost_result.twig',[
                                                'admin_mode' => $admin_mode,
                                                'is_admin' => $is_admin,
                                                'isLog' => $isLog,
                                                'firstname' => $firstname,
                                                'result' => $result,
                                                ]); ?><?php
    }
    public function Edit_post($post_id)
    {
        $postManager = new PostManager();
        $post = $postManager->Get_Post($post_id);
        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        ?><?=  $twig->render('editpost.twig',[
                                                'admin_mode' => $admin_mode,
                                                'is_admin' => $is_admin,
                                                'isLog' => $isLog,
                                                'firstname' => $firstname,
                                                'post' => $post->To_array()
                                                ]); ?><?php
    }
    public function Add_post($title,$leadParagraph,$content)
    {
        $author_id_user = $this->$superGlobal->get_key('SESSION','user_id');
        date_default_timezone_set('UTC');
        $creationDate = date("Y-m-d H:i:s");  
        $modificationDate = date("Y-m-d H:i:s");
        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');

        $postManager = new Postmanager;
        $result = $postManager->Add_post($title,$leadParagraph,$content,$author_id_user,$creationDate,$modificationDate);
        
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        ?><?= $twig->render('create_new_poste_result.twig',[
                                                            'admin_mode' => $admin_mode,
                                                            'is_admin' => $is_admin,
                                                            'isLog' => $isLog,
                                                            'firstname' => $firstname,
                                                          'result' => $result,
                                                         ]); ?><?php
    }

    public function Get_create_new_poste_page()
    {
        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        ?><?= $twig->render('create_new_poste_page.twig',[
                                                            'admin_mode' => $admin_mode,
                                                            'is_admin' => $is_admin,
                                                            'isLog' => $isLog,
                                                            'firstname' => $firstname,
        ]); ?><?php
    }

    public function DisplayPost(int $post_id, ?bool $add_comment, ?string $comment, ?int $author_id_user)
    {
        $postManager = new PostManager();
        $post = $postManager->Get_Post($post_id);


        if ($add_comment == true)
        {
            $commentManager = new CommentManager;
            $add_comment_result = $commentManager->add_comment($comment, $author_id_user,$post_id);
        }


        $commentManager = new CommentManager();
        $comments = $commentManager->Get_Comments($post_id);

        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');
        
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        ?><?= $twig->render('diplayOnePost.twig',[
                                                    'post' => $post->To_array(),
                                                    'comments' => $comments,
                                                    'add_comment' => $add_comment,
                                                    'add_comment_result' => $add_comment_result,
                                                    'admin_mode' => $admin_mode,
                                                    'is_admin' => $is_admin,
                                                    'isLog' => $isLog,
                                                    'firstname' => $firstname,
                                                ]); ?><?php
    }
    public function DisplayAllPosts(bool $admin = false)
    {
        if ($admin && $this->$superGlobal->get_key('SESSION','isLog')){
            $admin = 1;
        }else{
            $admin = 0;
        }
        $postManager = new PostManager();
        $posts = $postManager->Get_Posts();
        $firstname = $this->$superGlobal->get_key('SESSION','firstname');

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
        ]);
        
        $isLog = $this->$superGlobal->get_key('SESSION','isLog');
        $is_admin = $this->$superGlobal->get_key('SESSION','is_admin');
        $admin_mode = $this->$superGlobal->get_key('SESSION','admin_mode');

        ?><?= $twig->render('DisplayAllPosts.twig',
                            [
                                'admin_mode' => $admin_mode,
                                'is_admin' => $is_admin,
                                'isLog' => $isLog,
                                'firstname' => $firstname,
                                'posts' => $posts,
                                'admin' => $admin,
                            ]); 
        ?><?php
        
    }
}