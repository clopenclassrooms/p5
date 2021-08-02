<?php

namespace controllers;

use models\PostManager;
use models\CommentManager;
use models\SuperGlobal;
use views\DisplayHTML;

class PostController
{
    private $superGlobal;
    private $displayHTML;
    private $postManager;

    public function __construct()
    {
        $this->superGlobal = new SuperGlobal;
        $this->displayHTML = new DisplayHTML;
        $this->postManager = new PostManager;
    }
    public function delete_posts($posts_id)
    {
        $result = $this->postManager->Delete_Posts($posts_id);

        $values_send_to_twig = [
            'result' => $result,
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
            ];

        $this->displayHTML->displayHTML('delete_posts_result.twig',$values_send_to_twig);
    }

    public function Display_post_delete_page()
    {
        $values_send_to_twig = [
            'posts' => $this->postManager->Get_Posts(),
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
            ];

        $this->displayHTML->displayHTML('Display_post_delete_page.twig',$values_send_to_twig);
    }
    public function Modify_post($post_id,$post_title,$post_leadParagraph,$post_content)
    {
        $post_modifyDate = date("Y-m-d H:i:s");
        $result = $this->postManager->Modify_post($post_title,$post_leadParagraph,$post_content,$post_modifyDate, $post_id);
        
        $values_send_to_twig = [
            'result' => $result,
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
            ];

        $this->displayHTML->displayHTML('editpost_result.twig',$values_send_to_twig);
    }
    public function Edit_post($post_id)
    {
        $post = $this->postManager->Get_Post($post_id);

        $values_send_to_twig = [
            'post' => $post->To_array(),
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
            ];

        $this->displayHTML->displayHTML('editpost.twig',$values_send_to_twig);
    }
    public function Add_post($title,$leadParagraph,$content)
    {
        $author_id_user = $this->superGlobal->get_key('SESSION','user_id');
        date_default_timezone_set('UTC');
        $creationDate = date("Y-m-d H:i:s");  
        $modificationDate = date("Y-m-d H:i:s");

        $result = $this->postManager->Add_post($title,$leadParagraph,$content,$author_id_user,$creationDate,$modificationDate);
        
        $values_send_to_twig = [
            'result' => $result,
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
        ];

        $this->displayHTML->displayHTML('create_new_poste_result.twig',$values_send_to_twig);
    }

    public function Get_create_new_poste_page()
    {
        $values_send_to_twig = [
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
        ];

        $this->displayHTML->displayHTML('create_new_poste_page.twig',$values_send_to_twig);
    }

    public function DisplayPost(int $post_id, ?bool $add_comment, ?string $comment, ?int $author_id_user)
    {
        $post = $this->postManager->Get_Post($post_id);
        $commentManager = new CommentManager;
        if ($add_comment == true)
        {
            
            $add_comment_result = $commentManager->add_comment($comment, $author_id_user,$post_id);
        }

        $comments = $commentManager->Get_Comments($post_id);

        $values_send_to_twig = [
            'post' => $post->To_array(),
            'comments' => $comments,
            'add_comment' => $add_comment,
            'add_comment_result' => $add_comment_result,
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
        ];

        $this->displayHTML->displayHTML('diplayOnePost.twig',$values_send_to_twig);
    }
    public function DisplayAllPosts(bool $admin = false)
    {
        $admin = 0;
        if ($admin && $this->superGlobal->get_key('SESSION','isLog')){
            $admin = 1;
        }
        $posts = $this->postManager->Get_Posts();

        $values_send_to_twig = [
            'posts' => $posts,
            'admin' => $admin,
            'admin_mode' => $this->superGlobal->get_key('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->get_key('SESSION','is_admin'),
            'isLog' => $this->superGlobal->get_key('SESSION','isLog'),
            'firstname' => $this->superGlobal->get_key('SESSION','firstname'),
        ];

        $this->displayHTML->displayHTML('DisplayAllPosts.twig',$values_send_to_twig);
        
    }
}