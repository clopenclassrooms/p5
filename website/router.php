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
require_once './controllers/Error404Controller.php';
require_once './vendor/autoload.php';
require_once './models/superglobal.php';
require_once './views/php/display_html.php';


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
use controllers\Error404Controller;
use models\Superglobal;
use views\DisplayHTML;


$router = new router();
$router->Select_controler();

class Router
{
    private $superGlobal;

    Public function __construct()
    {
        $this->superGlobal = new SuperGlobal;
    }

    public function Get_redirection_url():array
    {
        $redirection_url = explode("/",$this->superGlobal->get_key('SERVER', 'REDIRECT_URL'));
        return $redirection_url;
    }
    public function Get_redirection_variables():array
    {
        if($this->superGlobal->get_key('SERVER','REQUEST_METHOD') == 'GET')
        {
            $redirection_var = $this->superGlobal->get('GET');
            return $redirection_var;
        }
        if($this->superGlobal->get_key('SERVER','REQUEST_METHOD') == 'POST')
        {
            $redirection_var = $this->superGlobal->get('POST');
            return $redirection_var;
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
                if ($change_right == "1")
                {
                    $users_from_post = $variables_receved['users_from_post'];
                    $user_valided = $variables_receved['user_valided'];
                    $user_is_admin = $variables_receved['user_is_admin'];
                }
                $controler->Manage_user_right(
                    $variables_receved['change_right'],
                    $users_from_post,
                    $user_valided,
                    $user_is_admin
                );
                break;
            case "contact" :
                $controler = new MailController;
                if ($variables_receved['send_mail'] == 1)
                {
                    $controler->Send_mail(
                        $variables_receved['firstname'],
                        $variables_receved['lastname'],
                        $variables_receved['email'],
                        $variables_receved['message']
                    );
                }else
                {
                    $controler->Display_mail_form();
                }
                break;
            case "delete_post" :
                $controler = new PostController;
                if ($variables_receved['posts_id'])
                {
                    $controler->delete_posts($variables_receved['posts_id']);
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
                if ($variables_receved['add_comment'] == 1 && $this->superGlobal->get_key('SESSION','isLog') == true)
                {
                    $add_comment = true;
                    $comment = (string) $variables_receved['comment'];
                    $author_id_user = $this->superGlobal->get_key('SESSION','user_id');
                }elseif ($variables_receved['add_comment'] == 1 && $this->superGlobal->get_key('SESSION','isLog') == false){
                    $add_comment = true;
                    $comment = $variables_receved['comment'];;
                    $author_id_user = 0;
                }
                $controler = new PostController;
                $controler->DisplayPost(
                    $post_id, 
                    $add_comment,
                    $comment,
                    $author_id_user
                );
                break;
            case "display_all_posts" : 
                $controler = new PostController;
                $controler->DisplayAllPosts((bool) $variables_receved['admin']);
                break;
            case "create_new_post_page" : 
                $controler = new PostController;
                $controler->Get_create_new_poste_page();
                break;
            case "create_new_post" : 
                $controler = new PostController;
                $controler->Add_post(
                    $variables_receved['title'],
                    $variables_receved['leadParagraph'],
                    $variables_receved['content']
                );
                break;
            case "modify_post" : 
                $controler = new PostController;
                $controler->Modify_post(
                    $variables_receved['post_id'],
                    $variables_receved['post_title'],
                    $variables_receved['post_leadParagraph'],
                    $variables_receved['post_content']
                );
                break;
            case "user_create_page" : 
                $controler = new UserController;
                $controler->Get_user_creation_page();
                break;
            case "create_user" :
                $controler = new UserController;
                $controler->Create_user(
                    $variables_receved['firstname'],
                    $variables_receved['lastname'],
                    $variables_receved['login'],
                    $variables_receved['password']
                );
                break;
            case "logging_user" : 
                $controler = new UserController;
                $controler->Logging_user(
                    $variables_receved['login'],
                    $variables_receved['password']
                );
                $action_request = "";
            case "" :
                $controler = new HomepageController;
                $controler->Display_homepage(
                    $variables_receved['sign_out'],
                    $variables_receved['admin_mode'],
                    $variables_receved['user_mode']
                );
                break;
            default :
                $controler = new Error404Controller;
                $controler->Display_404();
        }
    }
}