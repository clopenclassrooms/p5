<?php
declare(strict_types=1);

namespace Models;

class Comment
{
  protected int $commentId,$postID,$authorUserId;
  protected string $comment,$authorLogin;
  protected bool $validated;
  protected $creationDate;

  public function toArray():array
  {
      $array = [
                'id' => $this->commentId, 
                'comment' => $this->comment, 
                'validated' => $this->validated, 
                'creationDate' => $this->creationDate,
                'author_login' => $this->authorLogin,
                'author_user_id' => $this->authorUserId
              ];
      return $array;
  }
 
  // GETTERS //

  public function getId()
  {
    return $this->commentId;
  }
 
  public function getComment()
  {
    return $this->comment;
  }

  public function getValidated()
  {
    return $this->validated;
  }

  public function getCreationDate()
  {
    return $this->creationDate;
  }

  public function getAuthorLogin()
  {
    return $this->authorLogin;
  }

  public function getAuthorUserId()
  {
    return $this->authorUserId;
  }

  public function getPostID()
  {
    return $this->postID;
  }

  public function setId($commentId)
  {
    if (!is_integer($commentId) || ($commentId === null))
    {
        throw new \RuntimeException('the variable id must be an integer and not null');
    }
 
    $this->commentId = $commentId;
  }
 
  public function setComment($comment)
  {
    if (!is_string($comment) || empty($comment))
    {
      throw new \RuntimeException('the variable comment must be an string and not empty');
    }
 
    $this->comment = $comment;
  }
 
  public function setValidated($validated)
  {
    if (!is_bool($validated) || ($validated === null))
    {
      throw new \RuntimeException('the variable validated must be an boolean and not null');
    }
 
    $this->validated = $validated;
  }
 
  public function setCreationDate($creationDate)
  {
    if (!strtotime($creationDate) || ($creationDate === null))
    {
      throw new \RuntimeException('the variable creationDate must be an date and not null');
    }
 
    $this->creationDate = $creationDate;
  }

  public function setAuthorLogin($authorLogin)
  {
    if (!is_string($authorLogin) || empty($authorLogin))
    {
      throw new \RuntimeException('the variable author must be an string and not empty');
    }
 
    $this->authorLogin = $authorLogin;
  }

  public function setAuthorUserId($authorUserId)
  {
    if (!is_integer($authorUserId ))
    {
      throw new \RuntimeException('the variable author must be an integer and not empty');
    }
 
    $this->authorUserId = $authorUserId;
  }

  public function setPostID($postID)
  {
    if (!is_integer($postID) || ($postID === null))
    {
      throw new \RuntimeException('the variable postID must be an string and not null');
    }
 
    $this->postID = $postID;
  }
}