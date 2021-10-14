<?php

namespace Controllers;

use Models\PostManager;
use Models\CommentManager;
use Models\SuperGlobal;
use Views\DisplayHTML;
use Models\UserManager;

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
        $this->commentManager = new CommentManager;
    }
    public function deletePost($postsId)
    {
        $isAdmin = $this->superGlobal->getKey('SESSION','is_admin');
        if ($isAdmin){
            $result = $this->postManager->deletePost($postsId);
            if ($result){
                $this->commentManager->deleteCommentsByPost($postsId[0]);
                $valuesSendToTwig = [
                    'error' => false,
                    'result' => $result,
                    'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
                    'is_admin' => $isAdmin,
                    'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
                    'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
                    ];
            }else{
                $valuesSendToTwig = [
                    'error' => true,
                    'admin_mode' => $this->superGlobal->getKey('SESSION', 'admin_mode'),
                    'is_admin' => $isAdmin,
                    'isLog' => $isLog,
                    'firstname' => $this->superGlobal->getKey('SESSION', 'firstname'),
                    ];
                    $this->superGlobal->destroy('SESSION');
                    return;
            }
        }
        $this->displayHTML->displayHTML('delete_posts_result.twig',$valuesSendToTwig);
    }
    public function displayPostDeletePage()
    {
        $isAdmin = $this->superGlobal->getKey('SESSION','is_admin');
        if ($isAdmin){
            $valuesSendToTwig = [
                'posts' => $this->postManager->getPosts(),
                'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
                'is_admin' => $isAdmin,
                'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
                'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
                ];

            $this->displayHTML->displayHTML('Display_post_delete_page.twig',$valuesSendToTwig);
        }else{
            $this->superGlobal->destroy('SESSION');
            $controler = new HomepageController;
            $controler->displayHomepage();
        }
    }
    public function modifyPost($postId,$postTitle,$postLeadParagraph,$postContent,$authorId)
    {
        $isAdmin = $this->superGlobal->getKey('SESSION','is_admin');
        if ($isAdmin){
            
            $result = $this->postManager->modifyPost($postId,$postTitle,$postLeadParagraph,$postContent,$authorId);
            
            $valuesSendToTwig = [
                'result' => $result,
                'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
                'is_admin' => $isAdmin,
                'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
                'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
                ];

            $this->displayHTML->displayHTML('editpost_result.twig',$valuesSendToTwig);
        }else{
            $this->superGlobal->destroy('SESSION');
            $controler = new HomepageController;
            $controler->displayHomepage();
        }
    }
    public function editPost($postId)
    {
        $isAdmin = $this->superGlobal->getKey('SESSION','is_admin');
        if ($isAdmin){
            $controler = new UserManager;
            $users = $controler->getAllUsers();

            $post = $this->postManager->getPost($postId);

            $valuesSendToTwig = [
                'users' => $users,
                'post' => $post->toArray(),
                'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
                'is_admin' => $isAdmin,
                'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
                'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
                ];

            $this->displayHTML->displayHTML('editpost.twig',$valuesSendToTwig);
        }else{
            $this->superGlobal->destroy('SESSION');
            $controler = new HomepageController;
            $controler->displayHomepage();
        }
    }
    public function addPost($title,$leadParagraph,$content)
    {
        $isAdmin = $this->superGlobal->getKey('SESSION','is_admin');
        if ($isAdmin){
            $authorIdUser = $this->superGlobal->getKey('SESSION','user_id');
            date_default_timezone_set('UTC');
            $creationDate = date("Y-m-d H:i:s");  
            $modificationDate = date("Y-m-d H:i:s");

            $result = $this->postManager->addPost($title,$leadParagraph,$content,$authorIdUser,$creationDate,$modificationDate);
            
            $valuesSendToTwig = [
                'result' => $result,
                'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
                'is_admin' => $isAdmin,
                'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
                'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
            ];

            $this->displayHTML->displayHTML('create_new_poste_result.twig',$valuesSendToTwig);
        }else{
            $this->superGlobal->destroy('SESSION');
            $controler = new HomepageController;
            $controler->displayHomepage();
        }
    }
    public function getCreateNewPostPage()
    {
        $isAdmin = $this->superGlobal->getKey('SESSION','is_admin');
        if ($isAdmin){
            $valuesSendToTwig = [
                'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
                'is_admin' => $isAdmin,
                'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
                'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
            ];

            $this->displayHTML->displayHTML('create_new_poste_page.twig',$valuesSendToTwig);
        }else{
            $this->superGlobal->destroy('SESSION');
            $controler = new HomepageController;
            $controler->displayHomepage();
        }
    }
    public function displayPost(int $postId, ?bool $addComment, ?string $comment, ?int $authorIdUser)
    {

        $post = $this->postManager->getPost($postId);
        $isAdmin = $this->superGlobal->getKey('SESSION','is_admin');
        $isLog = $this->superGlobal->getKey('SESSION','isLog');

        if ($post != null) {
            $commentManager = new CommentManager;
            if ($addComment and $isLog) {
                $addCommentResult = $commentManager->addComment($comment, $authorIdUser, $postId, $isAdmin);
            }

            $comments = $commentManager->getComments($postId);

            $valuesSendToTwig = [
            'error' => false,
            'post' => $post->toArray(),
            'comments' => $comments,
            'addComment' => $addComment,
            'addComment_result' => $addCommentResult,
            'admin_mode' => $this->superGlobal->getKey('SESSION', 'admin_mode'),
            'is_admin' => $isAdmin,
            'isLog' => $isLog,
            'firstname' => $this->superGlobal->getKey('SESSION', 'firstname'),
            ];
        }else{
            $valuesSendToTwig = [
                'error' => true,
                'admin_mode' => $this->superGlobal->getKey('SESSION', 'admin_mode'),
                'is_admin' => $isAdmin,
                'isLog' => $isLog,
                'firstname' => $this->superGlobal->getKey('SESSION', 'firstname'),
                ];
        }
        $this->displayHTML->displayHTML('diplayOnePost.twig',$valuesSendToTwig);
    }
    public function displayAllPosts(bool $admin = false)
    {
        
        if ($admin && $this->superGlobal->getKey('SESSION','isLog')){
            $admin = 1;
        }else{
            $admin = 0;
        }

        $posts = $this->postManager->getPosts();

        $valuesSendToTwig = [
            'posts' => $posts,
            'admin' => $admin,
            'admin_mode' => $this->superGlobal->getKey('SESSION','admin_mode'),
            'is_admin' => $this->superGlobal->getKey('SESSION','is_admin'),
            'isLog' => $this->superGlobal->getKey('SESSION','isLog'),
            'firstname' => $this->superGlobal->getKey('SESSION','firstname'),
        ];

        $this->displayHTML->displayHTML('DisplayAllPosts.twig',$valuesSendToTwig);
        
    }
}