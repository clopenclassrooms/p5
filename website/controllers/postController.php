<?php

namespace controllers;

use models\PostManager;
use models\CommentManager;

class PostController
{
    public function delete_posts($posts_id)
    {
        $postManager = new PostManager($posts_id);
        $result = $postManager->Delete_Posts($posts_id);
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
        ]);
        $is_log = $_SESSION['isLog'];
        ?><?=  $twig->render('delete_posts_result.twig',[
                                              'isLog' => $is_log,
                                              'firstname' => $_SESSION['firstname'],
                                              'result' => $result,
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

        $is_log = $_SESSION['isLog'];

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        ?><?=  $twig->render('editpost_result.twig',[
                                                'isLog' => $is_log,
                                                'firstname' => $_SESSION['firstname'],
                                                'result' => $result,
                                                ]); ?><?php
    }
    public function Edit_post($post_id)
    {
        $postManager = new PostManager();
        $post = $postManager->Get_Post($post_id);
        $is_log = $_SESSION['isLog'];

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        ?><?=  $twig->render('editpost.twig',[
                                                'isLog' => $is_log,
                                                'firstname' => $_SESSION['firstname'],
                                                'post' => $post->To_array()
                                                ]); ?><?php
    }
    public function Add_post($title,$leadParagraph,$content)
    {
        $author_id_user = $_SESSION['user_id'];
        date_default_timezone_set('UTC');
        $creationDate = date("Y-m-d H:i:s");  
        $modificationDate = date("Y-m-d H:i:s");
        $is_log = $_SESSION['isLog'];

        $postManager = new Postmanager;
        $result = $postManager->Add_post($title,$leadParagraph,$content,$author_id_user,$creationDate,$modificationDate);
        
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        ?><?= $twig->render('create_new_poste_result.twig',[
                                                          'isLog' => $is_log,
                                                          'firstname' => $_SESSION['firstname'],
                                                          'result' => $result,
                                                         ]); ?><?php
    }

    public function Get_create_new_poste_page()
    {
        $is_log = $_SESSION['isLog'];

        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        ?><?= $twig->render('create_new_poste_page.twig',[
                                                          'isLog' => $is_log,
                                                          'firstname' => $_SESSION['firstname'],
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

        $is_log = $_SESSION['isLog'];
        
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false //'/tmp',
        ]);
        ?><?= $twig->render('diplayOnePost.twig',[
                                                    'post' => $post->To_array(),
                                                    'comments' => $comments,
                                                    'add_comment' => $add_comment,
                                                    'add_comment_result' => $add_comment_result,
                                                    'isLog' => $is_log,
                                                    'firstname' => $_SESSION['firstname'],
                                                ]); ?><?php
    }
    public function DisplayAllPosts(bool $admin = false)
    {
        if ($admin && $_SESSION['isLog']){
            $admin = 1;
        }else{
            $admin = 0;
        }
        $postManager = new PostManager();
        $posts = $postManager->Get_Posts();
        $loader = new \Twig\Loader\FilesystemLoader('/app/views');
        $twig = new \Twig\Environment($loader, [
            'cache' => false, //'/tmp',
        ]);
        ?><?= $twig->render('DisplayAllPosts.twig',
                            [
                                'isLog' => $_SESSION['isLog'],
                                'firstname' => $_SESSION['firstname'],
                                'posts' => $posts,
                                'admin' => $admin,
                            ]); 
        ?><?php
        
    }
}