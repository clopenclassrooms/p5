<?php

declare(strict_types=1);

namespace Models;

use Models\CommentManager;

class CommentManager
{
    private $PHPDataObject;

    public function __construct(){
        $database = new Database();
        $this->PHPDataObject = $database;
    }

    public function deleteCommentsByPost($postID)
    {
        $sql = "DELETE FROM comment WHERE comment.post_id = " . $postID;
        try{
            $prepare = $this->PHPDataObject->prepare($sql);
            $prepare->execute();
        }catch(Exception $e) {
            return false;
        }
        return true;
    }

    public function commentValidation($commentsValided)
    {
        
        $sql_condition = "";
        foreach($commentsValided as $commentValided)
        {
            $sql_condition = $sql_condition . "`id` = " . $commentValided . " OR ";
        }
        $sql_condition = substr($sql_condition, 0, -4);
        $sql="UPDATE `comment` SET `validated` = 1 WHERE " . $sql_condition;    
        try{
            $prepare = $this->PHPDataObject->prepare($sql);
            $prepare->execute();
        }catch(Exception $e) {
            return false;
        }
        return true;
        
    }

    public function displayCommentsForValidation()
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
            $prepare->execute();
            while ($fetch = $prepare->fetch()) {
                $comment = new Comment;
                $comment->setId((int)$fetch['comment_id']);
                $comment->setComment((string) $fetch['comment_comment']);
                $comment->setCreationDate($fetch['comment_creationDate']);
                $comment->setAuthorLogin((string)$fetch['user_login']);
                $comment->setValidated((bool) $fetch['comment_validated']);
                $comment->setAuthorUserId((int) $fetch['comment_author_id_user']);
                
                array_push($comments,$comment->toArray());
            }

        }catch(Exception $e) {
            return NULL;
        }
        return $comments;
    }

    public function addComment($comment, $authorIdUser, $postId,$isAdmin)
    {
        if ($comment != "")
        {
            $sql = "INSERT INTO comment 
                    (
                        `comment`,
                        `creationDate`,
                        `author_id_user`,
                        `post_id`,
                        `validated`
                    ) VALUES
                    (
                        ?,
                        ?,
                        ?,
                        ?,
                        ?
                    )";
            $creationDate = date("Y-m-d H:i:s");
            $validated = 0;
            if ($isAdmin == 1) {
                $validated = 1;
            }
            try {
                $this->PHPDataObject->beginTransaction();
                $prepare = $this->PHPDataObject->prepare($sql);
                $execute = $prepare->execute([$comment,$creationDate,$authorIdUser,$postId,$validated]);
                $this->PHPDataObject->commit();
            } catch (Exception $e) {
                $this->PHPDataObject->rollback();
                return false;
            }
            if ($execute) {
                return true;
            }
        }
        return false;
        
    }

    public function getComments($postId)
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
            $prepare->execute([$postId]);
            while ($fetch = $prepare->fetch()) {
                $comment = new Comment;
                $comment->setId((int)$fetch['comment.id']);
                $comment->setComment((string) $fetch['comment']);
                $comment->setCreationDate($fetch['creationDate']);
                $comment->setAuthorLogin((string)$fetch['login']);
                $comment->setValidated((bool) $fetch['validated']);
                $comment->setAuthorUserId((int) $fetch['author_id_user']);
                array_push($comments,$comment->toArray());
            }

        }catch(Exception $e) {
            return NULL;
        }
        
        return $comments;
    }
}
