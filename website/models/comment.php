<?php
declare(strict_types=1);

namespace models;

class Comment
{
  protected int $id,$postID,$author_user_id;
  protected string $comment,$author_login;
  protected bool $validated;
  protected $creationDate;


  //Contructor
  Public function __construct()
  {

  }

  public function To_array():array
  {
      $array = [
                'id' => $this->id, 
                'comment' => $this->comment, 
                'validated' => $this->validated, 
                'creationDate' => $this->creationDate,
                'author_login' => $this->author_login,
                'author_user_id' => $this->author_user_id
              ];
      return $array;
  }
 

  // GETTERS //

  public function Get_id()
  {
    return $this->id;
  }
 
  public function Get_comment()
  {
    return $this->comment;
  }

  public function Get_validated()
  {
    return $this->validated;
  }

  public function Get_creationDate()
  {
    return $this->creationDate;
  }

  public function Get_author_login()
  {
    return $this->author_login;
  }

  public function Get_author_user_id()
  {
    return $this->author_user_id;
  }

  public function Get_postID()
  {
    return $this->postID;
  }


  public function Set_id($id)
  {
    if (!is_integer($id) || ($id === null))
    {
        throw new \RuntimeException('the variable id must be an integer and not null');
    }
 
    $this->id = $id;
  }
 
  public function Set_comment($comment)
  {
    if (!is_string($comment) || empty($comment))
    {
      throw new \RuntimeException('the variable comment must be an string and not empty');
    }
 
    $this->comment = $comment;
  }
 
  public function Set_validated($validated)
  {
    if (!is_bool($validated) || ($validated === null))
    {
      throw new \RuntimeException('the variable validated must be an boolean and not null');
    }
 
    $this->validated = $validated;
  }
 
  public function Set_creationDate($creationDate)
  {
    if (!strtotime($creationDate) || ($creationDate === null))
    {
      throw new \RuntimeException('the variable creationDate must be an date and not null');
    }
 
    $this->creationDate = $creationDate;
  }

  public function Set_author_login($author_login)
  {
    if (!is_string($author_login) || empty($author_login))
    {
      throw new \RuntimeException('the variable author must be an string and not empty');
    }
 
    $this->author_login = $author_login;
  }

  public function Set_author_user_id($author_user_id)
  {
    if (!is_integer($author_user_id) || empty($author_user_id))
    {
      throw new \RuntimeException('the variable author must be an integer and not empty');
    }
 
    $this->author_user_id = $author_user_id;
  }

  public function Set_postID($postID)
  {
    if (!is_integer($postID) || ($postID === null))
    {
      throw new \RuntimeException('the variable postID must be an string and not null');
    }
 
    $this->postID = $postID;
  }
}