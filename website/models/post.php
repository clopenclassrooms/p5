<?php

 declare(strict_types=1);

 namespace models;

class Post
{
    //int max value is 2147483647 on 32bit system and 9223372036854775807 on 64bit system.
    //So max date is 19 January 2038 on 32bit system and 11 April 2262 on 64bit system.
    private int $id;

    private string $leadParagraph;
    private string $creationDate;
    private string $modificationDate;
    private string $title;
    private string $content;
    private string $author;



    Public function __construct()
    {

    }

    public function To_array():array
    {
        $array = ['id' => $this->id, 
                  'title' => $this->title, 
                  'content' => $this->content, 
                  'creationDate' => $this->creationDate,
                  'modificationDate' => $this->modificationDate];
        return $array;
    }

    // GETTERS //
    public function Get_id()
    {
        return $this->id;
    }
 
    public function Get_title()
    {
        return $this->title;
    }

    public function Get_leadParagraph()
    {
        return $this->leadParagraph;
    }

    public function Get_content()
    {
        return $this->content;
    }

    public function Get_author()
    {
        return $this->author;
    }
 
    public function Get_creationDate()
    {
        return $this->creationDate;
    }
 
    public function Get_modificationDate()
    {
        return $this->modificationDate;
    }
 
    // SETTERS //
    public function Set_id(int $id)
    {
        if (!is_integer($id)  || is_null($id)) {
            throw new \RuntimeException('the variable id must be an integer and not null');
        }
 
        $this->id = $id;
    }

    public function Set_title(string $title)
    {
        if (!is_string($title) || empty($title)) {
            throw new \RuntimeException('the variable title must be an string and not empty');
        }
 
        $this->title = $title;
    }

    public function Set_leadParagraph($leadParagraph)
    {
        if (!is_string($leadParagraph) || empty($leadParagraph)) {
            throw new \RuntimeException('the variable leadParagraph must be an string and not empty');
        }
 
        $this->leadParagraph = $leadParagraph;
    }

    public function Set_content($content)
    {
        if (!is_string($content) || empty($content)) {
            throw new \RuntimeException('the variable content must be an string and not empty');
        }
 
        $this->content = $content;
    }

    public function Set_author($author)
    {
        if (!is_string($author) || empty($author)) {
            throw new \RuntimeException('the variable author must be an string and not empty');
        }
 
        $this->author = $author;
    }
  
    public function Set_creationDate($creationDate)
    {
        if (!is_string($creationDate)  || empty($creationDate)) {
            throw new \RuntimeException('the variable creationDate must be an integer and empty');
        }
        $this->creationDate = $creationDate;
    }
 
    public function Set_modificationDate($modificationDate)
    {
        if (!is_string($modificationDate)  || empty($modificationDate)) {
            // throw new \RuntimeException('the variable modificationDate must be an integer and empty');   
            $this->modificationDate = "";
        }else{
            $this->modificationDate = $modificationDate;
        }
        
    }
}
