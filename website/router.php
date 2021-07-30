<?php
namespace router;

session_start();


require_once './models/postManager.php';
require_once './models/userManager.php';
require_once './models/commentManager.php';
require_once './models/post.php';
require_once './models/user.php';
require_once './models/comment.php';
require_once './models/database.php';
require_once './controllers/postController.php';
require_once './controllers/userController.php';
require_once './controllers/commentController.php';
require_once './controllers/mailController.php';
require_once './controllers/homepageController.php';
require_once './vendor/autoload.php';


use models\PostManager;
use models\UserManager;
use models\CommentManager;
use models\Post;
use models\User;
use models\Comment;
use models\Database;
use controllers\postController;
use controllers\userController;
use controllers\CommentController;
use controllers\MailController;
use controllers\homepageController;




$router = new router();
$router->Select_controler();

class Router
{
    public function Get_redirection_url():array
    {
        $redirection_url = explode("/",$_SERVER['REDIRECT_URL']);
        return $redirection_url;
    }
    public function Get_redirection_variables():array
    {
        if($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $redirection_variables = $_GET;
            return $redirection_variables;
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $redirection_variables = $_POST;
            return $redirection_variables;
        }
    }
    public function Select_controler()
    {
        $action_request = $this->Get_redirection_url()[1];
        $variables_receved = $this->Get_redirection_variables();
        switch ($action_request) 
        {
            case "user_management" : 
                $controler = new UserController;
                $change_right = $variables_receved['change_right'];
                if ($change_right == "1")
                {
                    $users_from_post = $variables_receved['users_from_post'];
                    $user_valided = $variables_receved['user_valided'];
                    $user_is_admin = $variables_receved['user_is_admin'];
                }
                $controler->Manage_user_right($change_right,$users_from_post,$user_valided,$user_is_admin);
                break;
            case "contact" :
                $controler = new MailController;
                if ($variables_receved['send_mail'] == 1)
                {
                    $firstname = $variables_receved['firstname'];
                    $lastname = $variables_receved['lastname'];
                    $email = $variables_receved['email'];
                    $message = $variables_receved['message'];
                    $controler->Send_mail($firstname,$lastname,$email,$message);
                }else
                {
                    
                    $controler->Display_mail_form();
                }
                break;
            case "delete_post" :
                $controler = new PostController;
                if ($variables_receved['posts_id'])
                {
                    $posts_id = $variables_receved['posts_id'];
                    $controler->delete_posts($posts_id);
                }else{
                    $controler->Display_post_delete_page();
                }
                break;
            case "edit_post" :  
                $controler = new PostController;
                $controler->edit_post($variables_receved['post_id']);
                break;
            case "comment_validation" : 
                $controler = new CommentController;
                if (isset($variables_receved['comments_valided']))
                {
                    $controler->comment_validation($variables_receved['comments_valided']);
                }else{
                    $controler->Display_comments_for_validation();
                }


                break;
            case "display_post" : 
                
                $post_id = (int) $variables_receved['post_id'];
                if ($variables_receved['add_comment'] == 1 && $_SESSION['isLog'] == true)
                {
                    $add_comment = true;
                    $comment = (string) $variables_receved['comment'];
                    $author_id_user = $_SESSION['user_id'];
                }elseif ($variables_receved['add_comment'] == 1 && $_SESSION['isLog'] == false){
                    $add_comment = true;
                    $comment = $variables_receved['comment'];;
                    $author_id_user = 0;
                }
                $controler = new PostController;
                $controler->DisplayPost($post_id, $add_comment,$comment,$author_id_user);
                break;
            case "display_all_posts" : 
                $controler = new PostController;
                $admin = (bool) $variables_receved['admin'];
                $controler->DisplayAllPosts($admin);
                break;
            case "create_new_post_page" : 
                $controler = new PostController;
                $controler->Get_create_new_poste_page();
                break;
            case "create_new_post" : 
                $controler = new PostController;
                $title = $variables_receved['title'];
                $leadParagraph = $variables_receved['leadParagraph'];
                $content = $variables_receved['content'];
                $controler->Add_post($title,$leadParagraph,$content);
                break;
            case "modify_post" : 
                $controler = new PostController;
                $post_id = $variables_receved['post_id'];
                $post_title = $variables_receved['post_title'];
                $post_content = $variables_receved['post_content'];
                $post_leadParagraph = $variables_receved['post_leadParagraph'];
                $controler->Modify_post($post_id,$post_title,$post_leadParagraph,$post_content);
                break;
            case "user_create_page" : 
                $controler = new UserController;
                $controler->Get_user_creation_page();
                break;
            case "create_user" :
                $controler = new UserController;
                $variables_receved = $this->Get_redirection_variables();
                $firstname = $variables_receved['firstname'];
                $lastname = $variables_receved['lastname'];
                $login = $variables_receved['login'];
                $password = $variables_receved['password'];
                $controler->Create_user($firstname,$lastname,$login,$password);
                break;
            case "logging_user" : 
                $controler = new UserController;
                $variables_receved = $this->Get_redirection_variables();
                $login = $variables_receved['login'];
                $password = $variables_receved['password'];
                $controler->Logging_user($login,$password);
                $action_request = "";
            case "" :
                if ($variables_receved['sign_out'] == 1)
                {
                    $_SESSION['isLog'] =     false;
                }
                $controler = new HomepageController;
                $controler->Display_homepage();
                break;
            default :
            print("Erreur dans l'url");
        }
    }
}