<?php
namespace Router;

session_start();

require_once './vendor/autoload.php';


use models\PostManager;
use models\UserManager;
use models\CommentManager;
use models\Post;
use models\User;
use models\Comment;
use models\Database;
use controllers\PostController;
use controllers\UserController;
use controllers\CommentController;
use controllers\MailController;
use controllers\HomepageController;
use controllers\Error404Controller;
use models\Superglobal;
use views\DisplayHTML;


$router = new router();
$router->selectControler();

class Router
{
    private $superGlobal;

    Public function __construct()
    {
        $this->superGlobal = new SuperGlobal;
    }
    public function getRedirectionUrl():array
    {
        $redirectionUrl = explode("/",$this->superGlobal->getKey('SERVER', 'REDIRECT_URL'));
        return $redirectionUrl;
    }
    public function getRedirectionVariables():array
    {
        if($this->superGlobal->getKey('SERVER','REQUEST_METHOD') == 'GET')
        {
            $redirectionVars = $this->superGlobal->get('GET');
        }
        if($this->superGlobal->getKey('SERVER','REQUEST_METHOD') == 'POST')
        {
            $redirectionVars = $this->superGlobal->get('POST');
        }
        $secureVars = [];
        foreach($redirectionVars as $key => $value)
        {
            $secureVars[$key] = $value;
        }
        return $secureVars;
    }
    public function selectControler()
    {
        $actionRequest = $this->getRedirectionUrl()[1];
        $variablesReceved = $this->getRedirectionVariables();
        switch ($actionRequest) 
        {
            case "user_management" : 
                $controler = new UserController;
                if ($variablesReceved['change_right'] == "1")
                {
                    $usersFromPost = $variablesReceved['users_from_post'];
                    $userValided = $variablesReceved['user_valided'];
                    $userIsAdmin = $variablesReceved['user_is_admin'];
                }
                $controler->manageUserRight(
                    $variablesReceved['change_right'],
                    $usersFromPost,
                    $userValided,
                    $userIsAdmin
                );
                break;
            case "contact" :
                $controler = new MailController;
                if ($variablesReceved['sendMail'] == 1)
                {
                    $controler->sendMail(
                        $variablesReceved['firstname'],
                        $variablesReceved['lastname'],
                        $variablesReceved['email'],
                        $variablesReceved['message']
                    );
                }else
                {
                    $controler->displayMailForm();
                }
                break;
            case "delete_post" :
                $controler = new PostController;
                if ($variablesReceved['posts_id'])
                {
                    $controler->deletePost($variablesReceved['posts_id']);
                }else{
                    $controler->displayPostDeletePage();
                }
                break;
            case "editPost" :  
                $controler = new PostController;
                $controler->editPost($variablesReceved['post_id']);
                break;
            case "commentValidation" : 
                $controler = new CommentController;
                if (isset($variablesReceved['commentsValided']))
                {
                    $controler->commentValidation($variablesReceved['commentsValided']);
                }else{
                    $controler->displayCommentsForValidation();
                }
                break;
            case "display_post" : 
                
                $postId = (int) $variablesReceved['post_id'];
                $addComment = false;
                if ($variablesReceved['addComment'] == 1 && $this->superGlobal->getKey('SESSION','isLog') == true)
                {
                    $addComment = true;
                    $comment = (string) $variablesReceved['comment'];
                    $authorIdUser = $this->superGlobal->getKey('SESSION','user_id');
                }
                $controler = new PostController;
                $controler->displayPost(
                    $postId, 
                    $addComment,
                    $comment,
                    $authorIdUser
                );
                break;
            case "display_all_posts" : 
                $controler = new PostController;
                $controler->displayAllPosts((bool) $variablesReceved['admin']);
                break;
            case "create_new_post_page" : 
                $controler = new PostController;
                $controler->getCreateNewPostPage();
                break;
            case "create_new_post" : 
                $controler = new PostController;
                $controler->addPost(
                    $variablesReceved['title'],
                    $variablesReceved['leadParagraph'],
                    $variablesReceved['content']
                );
                break;
            case "modifyPost" : 
                $controler = new PostController;
                $controler->modifyPost(
                    $variablesReceved['post_id'],
                    $variablesReceved['post_title'],
                    $variablesReceved['post_leadParagraph'],
                    $variablesReceved['post_content'],
                    $variablesReceved['author_id']
                );
                break;
            case "user_create_page" : 
                $controler = new UserController;
                $controler->getUserCreationPage();
                break;
            case "createUser" :
                $controler = new UserController;
                $controler->createUser(
                    $variablesReceved['firstname'],
                    $variablesReceved['lastname'],
                    $variablesReceved['login'],
                    $variablesReceved['password']
                );
                break;
            case "loggingUser" : 
                $controler = new UserController;
                $controler->loggingUser(
                    $variablesReceved['login'],
                    $variablesReceved['password']
                );
                $actionRequest = "";
            case "" :
                $controler = new HomepageController;
                $controler->displayHomepage(
                    $variablesReceved['sign_out'],
                    $variablesReceved['admin_mode'],
                    $variablesReceved['user_mode']
                );
                break;
            default :
                $controler = new Error404Controller;
                $controler->display404();
        }
    }
}