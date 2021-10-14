<?php

 declare(strict_types=1);

 namespace Models;

class Post
{
    private int $postId;
    private int $authorId;

    private string $leadParagraph;
    private string $creationDate;
    private string $modificationDate;
    private string $title;
    private string $content;
    private string $author;

    public function toArray():array
    {
        $array = [
                  'id' => $this->post_id, 
                  'title' => $this->title,
                  'leadParagraph' => $this->leadParagraph,
                  'content' => $this->content, 
                  'creationDate' => $this->creationDate,
                  'modificationDate' => $this->modificationDate,
                  'author' => $this->author,
                  'author_id' => $this->authorId,
                ];
        return $array;
    }

    public function getId()
    {
        return $this->post_id;
    }
 
    public function getTitle()
    {
        return $this->title;
    }

    public function getLeadParagraph()
    {
        return $this->leadParagraph;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getAuthorId($authorId){
        return $this->authorId;
    }
 
    public function getCreationDate()
    {
        return $this->creationDate;
    }
 
    public function getModificationDate()
    {
        return $this->modificationDate;
    }
 
    // SETTERS //
    public function setId(int $postId)
    {
        if (!is_integer($postId)  || ($postId === null)) {
            throw new \RuntimeException('the variable id must be an integer and not null');
        }
 
        $this->post_id = $postId;
    }

    public function setTitle(string $title)
    {
        if (!is_string($title) || empty($title)) {
            throw new \RuntimeException('the variable title must be an string and not empty');
        }
 
        $this->title = $title;
    }

    public function setLeadParagraph($leadParagraph)
    {
        if (!is_string($leadParagraph) || empty($leadParagraph)) {
            throw new \RuntimeException('the variable leadParagraph must be an string and not empty');
        }
 
        $this->leadParagraph = $leadParagraph;
    }

    public function setContent($content)
    {
        if (!is_string($content) || empty($content)) {
            throw new \RuntimeException('the variable content must be an string and not empty');
        }
 
        $this->content = $content;
    }

    public function setAuthor($author)
    {
        if (!is_string($author) || empty($author)) {
            throw new \RuntimeException('the variable author must be an string and not empty');
        }
 
        $this->author = $author;
    }

    public function setAuthorId($authorId){
        $this->authorId = $authorId;
    }
  
    public function setCreationDate($creationDate)
    {
        if (!is_string($creationDate)  || empty($creationDate)) {
            throw new \RuntimeException('the variable creationDate must be an integer and empty');
        }
        $this->creationDate = $creationDate;
    }
 
    public function setModificationDate($modificationDate)
    {
        if (!is_string($modificationDate)  || empty($modificationDate)) {
            // throw new \RuntimeException('the variable modificationDate must be an integer and empty');   
            $this->modificationDate = "";
        }else{
            $this->modificationDate = $modificationDate;
        }
        
    }
}
