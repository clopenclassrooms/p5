<?php

declare(strict_types=1);

namespace Models;

class PostManager
{
    private $PHPDataObject;

    public function __construct(){
        $this->PHPDataObject = new Database();
    }

    public function deletePost($postsId)
    {
        $sql = "DELETE FROM post WHERE `id` IN ";
        $ids = "";
        foreach ($postsId as $id)
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

    public function modifyPost($postId,$postTitle,$postLeadParagraph,$postContent,$authorId)
    {
        $sql="UPDATE post SET `author_id_user` = ? , `title` = ? , `leadParagraph` = ?, `content` = ?,`modificationDate` = ? WHERE `id` =  ?";
        try{
            $post_modifyDate = date("Y-m-d H:i:s");
            $this->PHPDataObject->beginTransaction();
            $prepare = $this->PHPDataObject->prepare($sql);
            $post_modifyDate = date("Y-m-d H:i:s"); 
            $execute = $prepare->execute([$authorId,$postTitle,$postLeadParagraph,$postContent,$post_modifyDate, $postId]);
            
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
    public function addPost($title,$leadParagraph,$content,$authorIdUser,$creationDate,$modificationDate):bool
    {
        $sql = "INSERT INTO `post` (`title`,`leadParagraph`, `content`, `author_id_user`, `creationDate`, `modificationDate` ) VALUES (?,?, ?, ?, ?, ?) ";
        try{
            $this->PHPDataObject->beginTransaction();
            $this->PHPDataObject->setAttribute(Database::ATTR_ERRMODE, Database::ERRMODE_EXCEPTION);
            $prepare = $this->PHPDataObject->prepare($sql);
            $execute = $prepare->execute([$title,$leadParagraph,$content,$authorIdUser,$creationDate,$modificationDate]);
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
    public function getPost($postId):?Post
    {
        $sql = "SELECT 
                    post.id as post_id,
                    post.title as post_title,
                    post.leadParagraph as post_leadParagraph,
                    post.content as post_content,
                    post.creationDate as post_creationDate,
                    post.modificationDate as post_modificationDate,
                    user.login as post_author,
                    post.author_id_user as author_id_user
                FROM post 
                INNER JOIN user 
                    ON post.author_id_user = user.id
                WHERE post.id = ?";
        $post = new Post();
        try{
            $prepare = $this->PHPDataObject->prepare($sql);
            $prepare->execute([$postId]);
            $fetch = $prepare->fetch();
            if ($fetch) {
                $post->setId((int)$fetch['post_id']);
                $post->setTitle($fetch['post_title']);
                $post->setLeadParagraph($fetch['post_leadParagraph']);
                $post->setContent($fetch['post_content']);
                $post->setCreationDate($fetch['post_creationDate']);
                $post->setModificationDate($fetch['post_modificationDate']);
                $post->setAuthor($fetch['post_author']);
                $post->setAuthorId($fetch['author_id_user']);
            }else{
                return NULL;
            }
        }catch(Exception $e) {
            return NULL;
        }
        return $post;
    }
    public function getPosts()
    {
        $sql = "SELECT 
                    post.id as post_id,
                    post.title as post_title,
                    post.leadParagraph as post_leadParagraph,
                    post.content as post_content,
                    post.creationDate as post_creationDate,
                    post.modificationDate as post_modificationDate,
                    post.author_id_user as post_author_id,
                    user.login as post_author
                FROM post INNER JOIN user ON post.author_id_user = user.id
                ORDER BY post.creationDate DESC";
        $posts = [];
        try{
            $prepare = $this->PHPDataObject->prepare($sql);
            $prepare->execute();
            while ($fetch = $prepare->fetch()) {
                $post = new Post();
                $post->setId((int)$fetch['post_id']);
                $post->setTitle($fetch['post_title']);
                $post->setLeadParagraph($fetch['post_leadParagraph']);
                $post->setContent($fetch['post_content']);
                $post->setCreationDate($fetch['post_creationDate']);
                $post->setModificationDate($fetch['post_modificationDate']);
                $post->setAuthor($fetch['post_author']);
                $post->setAuthorId($fetch['post_author_id']);
                array_push($posts,$post->toArray());
            }

        }catch(Exception $e) {
            return NULL;
        }
        return $posts;
    }
}
