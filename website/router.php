<?php
namespace router;

session_start();


include_once './models/postManager.php';
include_once './models/userManager.php';
include_once './models/commentManager.php';
include_once './models/post.php';
include_once './models/user.php';
include_once './models/comment.php';
include_once './models/database.php';
include_once './controllers/postController.php';
include_once './controllers/userController.php';
include_once './controllers/commentController.php';
include_once './vendor/autoload.php';


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
                
                $post_id = (integer) intval($variables_receved['post_id']);

                if ($variables_receved['add_comment'] == 1 && $_SESSION['isLog'] = true)
                {
                    $add_comment = true;
                    $comment = (string) $variables_receved['comment'];
                    $author_id_user = $_SESSION['user_id'];
                }else{
                    $add_comment = false;
                    $comment = NULL;
                    $author_id_user = NULL;
                }
                $controler = new PostController;
                $controler->DisplayPost($post_id, $add_comment,$comment,$author_id_user);
                break;
            case "display_all_posts" : 
                $controler = new PostController;
                $controler->DisplayAllPosts();
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
                break;
            case "" :
                if ($variables_receved['sign_out'] == 1)
                {
                    $_SESSION['isLog'] =     false;
                }
                if ($_SESSION['isLog'] == true)
                {
                    ?>
                    <p><span>bonjour <?= $_SESSION['firstname']; ?><span></p>
                    <p><a href="/?sign_out=1">déconnection</a></p>
                    <?php
                }else
                {
                    ?>
                    <p>logging : </p>
                    <form action="/logging_user/" method="post">
                        <p>login : <input type="text" name="login" /></p>
                        <p>password : <input type="text" name="password" /></p>
                        <p><input type="submit" value="OK"></p>
                    </form>
                    <br>
                    <?php
                }
                

                ?>
                <h1>Accueil</h1><br>
                <a href='/display_post/?post_id=1'>Display post 1</a><br>
                <a href='/display_all_posts'>Display all post</a><br>
                <a href='/create_new_post_page/'>Create new post </a><br>
                <a href='/user_create_page/'>Create user</a><br><br>
                <a href='/comment_validation/'>Valide comment</a><br><br>
                <a href='/edit_post/?post_id=1'>Modifier un post</a><br><br>
                <a href='/delete_post/'>supprimer des posts</a><br><br>
                <?php
                break;
            default :
            print("Erreur dans l'url");
        }
    }
}