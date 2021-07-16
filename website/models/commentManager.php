<?php

declare(strict_types=1);

namespace models;

use models\CommentManager;

class CommentManager
{
    private $PHPDataObject;

    public function __construct(){
        $database = new Database();
        $this->PHPDataObject = $database;
    }

    public function comment_validation($comments_valided)
    {
        
        $sql_condition = "";
        foreach($comments_valided as $comment_valided)
        {
            $sql_condition = $sql_condition . "`id` = " . $comment_valided;
        }
        $sql="UPDATE `comment` SET `validated` = 1 WHERE " . $sql_condition;
        try{
            $prepare = $this->PHPDataObject->prepare($sql);
            $execute = $prepare->execute();
        }catch(Exception $e) {
            return false;
        }
        return true;
        
    }

    public function Display_comments_for_validation()
    {
        $sql = "SELECT 
                    comment.id as comment_id,
                    comment.comment as comment_comment,
                    comment.creationDate as comment_creationDate,
                    user.login as user_login,
                    comment.validated as comment_validated,
                    comment.author_id_user as comment_author_id_user
                FROM comment 
                INNER JOIN user 
                            ON comment.author_id_user = user.id 
                WHERE validated = 0";

        $comments = [];
        try{
            $prepare = $this->PHPDataObject->prepare($sql);
            $execute = $prepare->execute();
            while ($fetch = $prepare->fetch()) {
                $comment = new Comment;
                $comment->Set_id(intval((string)$fetch['comment_id']));
                $comment->Set_comment((string) $fetch['comment_comment']);
                $comment->Set_creationDate($fetch['comment_creationDate']);
                $comment->Set_author_login((string)$fetch['user_login']);
                $comment->Set_validated((bool) $fetch['comment_validated']);
                $comment->Set_author_user_id((int) $fetch['comment_author_id_user']);
                
                array_push($comments,$comment->To_array());
            }

        }catch(Exception $e) {
            return NULL;
        }
        return $comments;
    }

    public function add_comment($comment, $author_id_user, $post_id)
    {
        $sql = "INSERT INTO comment 
                (
                    `comment`,
                    `creationDate`,
                    `author_id_user`,
                    `post_id`
                ) VALUES
                (
                    ?,
                    ?,
                    ?,
                    ?
                )"; 
        $creationDate = date("Y-m-d H:i:s"); 

        try{
            $this->PHPDataObject->beginTransaction();
            $prepare = $this->PHPDataObject->prepare($sql);
            $execute = $prepare->execute([$comment,$creationDate,$author_id_user,$post_id]);
            $this->PHPDataObject->commit();
            
        }catch(Exception $e) {
            $this->PHPDataObject->rollback();
            return false;
        }
        if ($execute){
            return true;
        }else{
            return false;
        }
    }

    public function Get_Comments($post_id)
    {
        $sql = "SELECT * FROM comment 
                INNER JOIN post 
                    ON comment.post_id = post.id 
                INNER JOIN user 
                    ON comment.author_id_user = user.id
                WHERE post.id = ?
                ";

        $comments = [];
        try{
            $prepare = $this->PHPDataObject->prepare($sql);
            $execute = $prepare->execute([$post_id]);
            while ($fetch = $prepare->fetch()) {
                // validated ?
                $comment = new Comment;
                $comment->Set_id(intval((string)$fetch['comment.id']));
                $comment->Set_comment((string) $fetch['comment']);
                $comment->Set_creationDate($fetch['creationDate']);
                $comment->Set_author_login((string)$fetch['login']);
                $comment->Set_validated((bool) $fetch['validated']);
                $comment->Set_author_user_id((int) $fetch['author_id_user']);
                array_push($comments,$comment->To_array());
            }

        }catch(Exception $e) {
            return NULL;
        }
        return $comments;
    }
}