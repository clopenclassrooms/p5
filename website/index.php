<?php

require_once ('./models/postManager.php');
require_once ('./models/post.php');
require_once ('./models/database.php');
require_once ('./controllers/postController.php');
require_once ('./vendor/autoload.php');

use models\PostManager;
use models\Post;
use models\Database;
use controllers\postController;

/* => test Add_post

$title = "Titre du post";
$leadParagraph = "Résumé du post";
$content = "contenu du post";
$author = "2";
$creationDate = "2021-06-10";

$post = new Post();
$post->Set_title("coucou");

$database = new Database();
$postManager = new PostManager($database);
$check_add_post_success = $postManager->Add_Post($title, $leadParagraph, $content, $author, $creationDate);

*/

$postController = new PostController;
$postController->DisplayPost(1);

//$id = 1;
//$database = new Database();
//$postManager = new PostManager($database);
//$post = $postManager->Get_Post($id);
//var_dump($post);
