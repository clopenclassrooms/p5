<?php

namespace controllers;

use models\PostManager;
use models\CommentManager;
use models\SuperGlobal;
use views\DisplayHTML;

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

        $values_send_to_twig = [
            'result' => $result,
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
            ];

        DisplayHTML::displayHTML('delete_posts_result.twig',$values_send_to_twig);
    }

    public function Display_post_delete_page()
    {
        $postManager = new PostManager();

        $values_send_to_twig = [
            'posts' => $postManager->Get_Posts(),
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
            ];

        DisplayHTML::displayHTML('Display_post_delete_page.twig',$values_send_to_twig);
    }
    public function Modify_post($post_id,$post_title,$post_leadParagraph,$post_content)
    {
        $postManager = new PostManager();
        $post_modificationDate = date("Y-m-d H:i:s");
        $result = $postManager->Modify_post($post_title,$post_leadParagraph,$post_content,$post_modificationDate, $post_id);
        
        $values_send_to_twig = [
            'result' => $result,
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
            ];

        DisplayHTML::displayHTML('editpost_result.twig',$values_send_to_twig);
    }
    public function Edit_post($post_id)
    {
        $postManager = new PostManager();
        $post = $postManager->Get_Post($post_id);

        $values_send_to_twig = [
            'post' => $post->To_array(),
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
            ];

        DisplayHTML::displayHTML('editpost.twig',$values_send_to_twig);
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
        
        $values_send_to_twig = [
            'result' => $result,
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
        ];

        DisplayHTML::displayHTML('create_new_poste_result.twig',$values_send_to_twig);
    }

    public function Get_create_new_poste_page()
    {
        $values_send_to_twig = [
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
        ];

        DisplayHTML::displayHTML('create_new_poste_page.twig',$values_send_to_twig);
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

        $values_send_to_twig = [
            'post' => $post->To_array(),
            'comments' => $comments,
            'add_comment' => $add_comment,
            'add_comment_result' => $add_comment_result,
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
        ];

        DisplayHTML::displayHTML('diplayOnePost.twig',$values_send_to_twig);
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

        $values_send_to_twig = [
            'posts' => $posts,
            'admin' => $admin,
            'admin_mode' => SuperGlobal::get_key('SESSION','admin_mode'),
            'is_admin' => SuperGlobal::get_key('SESSION','is_admin'),
            'isLog' => SuperGlobal::get_key('SESSION','isLog'),
            'firstname' => SuperGlobal::get_key('SESSION','firstname'),
        ];

        DisplayHTML::displayHTML('DisplayAllPosts.twig',$values_send_to_twig);
        
    }
}