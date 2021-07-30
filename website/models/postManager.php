<?php

declare(strict_types=1);

namespace models;

class PostManager
{
    private $PHPDataObject;

    public function __construct(){
        $database = new Database();
        $this->PHPDataObject = $database;
    }

    public function Delete_Posts($posts_id)
    {
        $sql = "DELETE FROM post WHERE `id` IN ";
        $ids = "";
        foreach ($posts_id as $id)
        {
            $ids = $ids . "'" . $id . "'" . " , " ; 
        }
        $ids = substr($ids, 0, -2);
        $sql = $sql . "(" . $ids . ")";

        try{
            
            $this->PHPDataObject->beginTransaction();
            $this->PHPDataObject->setAttribute(Database::ATTR_ERRMODE, Database::ERRMODE_EXCEPTION);
            $prepare = $this->PHPDataObject->prepare($sql);
            $execute = $prepare->execute();
            
            $this->PHPDataObject->commit();
            
        }catch(Exception $e) {
            $this->PHPDataObject->rollback();
            return false;
        }
        if ($execute){
            return true;
        }
        return false;
        
    }

    public function Modify_post($post_title,$post_leadParagraph,$post_content,$post_modificationDate, $post_id)
    {
        $sql="UPDATE post SET `title` = ? , `leadParagraph` = ?, `content` = ?,`modificationDate` = ? WHERE `id` =  ?";
        try{
            
            $this->PHPDataObject->beginTransaction();
            $prepare = $this->PHPDataObject->prepare($sql);
            $execute = $prepare->execute([$post_title,$post_leadParagraph,$post_content,$post_modificationDate, $post_id]);
            
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
    public function Add_Post($title,$leadParagraph,$content,$author_id_user,$creationDate,$modificationDate):bool
    {
        $sql = "INSERT INTO `post` (`title`,`leadParagraph`, `content`, `author_id_user`, `creationDate`, `modificationDate` ) VALUES (?,?, ?, ?, ?, ?) ";
        try{
            $this->PHPDataObject->beginTransaction();
            $this->PHPDataObject->setAttribute(Database::ATTR_ERRMODE, Database::ERRMODE_EXCEPTION);
            $prepare = $this->PHPDataObject->prepare($sql);
            $execute = $prepare->execute([$title,$leadParagraph,$content,$author_id_user,$creationDate,$modificationDate]);
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
    public function Get_Post($post_id):Post
    {
        $sql = "SELECT 
                    post.id as post_id,
                    post.title as post_title,
                    post.leadParagraph as post_leadParagraph,
                    post.content as post_content,
                    post.creationDate as post_creationDate,
                    post.modificationDate as post_modificationDate,
                    user.login as post_author
                FROM post 
                INNER JOIN user 
                    ON post.author_id_user = user.id
                WHERE post.id = ?";
        $post = new Post();
        try{
            $prepare = $this->PHPDataObject->prepare($sql);
            $prepare->execute([$post_id]);
            $fetch = $prepare->fetch();
            $post->Set_id((int)$fetch['post_id']);
            $post->Set_title($fetch['post_title']);   
            $post->Set_leadParagraph($fetch['post_leadParagraph']);
            $post->Set_Content($fetch['post_content']);
            $post->Set_creationDate($fetch['post_creationDate']);
            $post->Set_modificationDate($fetch['post_modificationDate']);
            $post->Set_author($fetch['post_author']);
        }catch(Exception $e) {
            return NULL;
        }
        return $post;
    }
    public function Get_Posts()
    {
        $sql = "SELECT 
                    post.id as post_id,
                    post.title as post_title,
                    post.leadParagraph as post_leadParagraph,
                    post.content as post_content,
                    post.creationDate as post_creationDate,
                    post.modificationDate as post_modificationDate,
                    user.login as post_author
                FROM post INNER JOIN user ON post.author_id_user = user.id
                ORDER BY post.creationDate DESC";
        $posts = [];
        try{
            $prepare = $this->PHPDataObject->prepare($sql);
            $prepare->execute();
            while ($fetch = $prepare->fetch()) {
                $post = new Post();
                $post->Set_id((int)$fetch['post_id']);
                $post->Set_title($fetch['post_title']);
                $post->Set_leadParagraph($fetch['post_leadParagraph']);
                $post->Set_Content($fetch['post_content']);
                $post->Set_creationDate($fetch['post_creationDate']);
                $post->Set_modificationDate($fetch['post_modificationDate']);
                $post->Set_author($fetch['post_author']);
                array_push($posts,$post->To_array());
            }

        }catch(Exception $e) {
            return NULL;
        }
        return $posts;
    }
}
