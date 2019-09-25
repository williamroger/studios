<?php

namespace App\Models;

final class UserModel
{
  /**
   * @var int
   */
  private $id;
  /**
   * @var string
   */
  private $email;
  /**
   * @var string
   */
  private $password;
  /**
   * @var string
   */
  private $createdAt;
  /**
   * @var string
   */
  private $updatedAt;
  /**
   * @var int
   */
  private $customerId;
  /**
   * @var int
   */
  private $studioId;
  /**
   * @var int
   */
  private $isStudio;
  /**
   * @var int
   */
  private $isCustomer;

  /**
   * Get the value of id
   * @return  int
   */ 
  public function getId(): int
  {
    return $this->id;
  }

  /**
   * Set the value of id
   * @param  int  $id
   *
   * @return  self
   */ 
  public function setId(int $id): self
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of email
   * @return  string
   */ 
  public function getEmail(): string
  {
    return $this->email;
  }

  /**
   * Set the value of email
   * @param  string  $email
   *
   * @return  self
   */ 
  public function setEmail(string $email): self
  {
    $this->email = $email;

    return $this;
  }

  /**
   * Get the value of password
   * @return  string
   */ 
  public function getPassword(): string
  {
    return $this->password;
  }

  /**
   * Set the value of password
   * @param  string  $password
   *
   * @return  self
   */ 
  public function setPassword(string $password): self
  {
    $this->password = $password;

    return $this;
  }

  /**
   * Get the value of createdAt
   * @return  string
   */ 
  public function getCreatedAt(): string
  {
    return $this->createdAt;
  }

  /**
   * Set the value of createdAt
   * @param  string  $createdAt
   *
   * @return  self
   */ 
  public function setCreatedAt(string $createdAt): self
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  /**
   * Get the value of updatedAt
   * @return  string
   */ 
  public function getUpdatedAt(): string
  {
    return $this->updatedAt;
  }

  /**
   * Set the value of updatedAt
   * @param  string  $updatedAt
   *
   * @return  self
   */ 
  public function setUpdatedAt(string $updatedAt): self
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }

  /**
   * Get the value of customerId
   * @return  int
   */ 
  public function getCustomerId(): int
  {
    return $this->customerId;
  }

  /**
   * Set the value of customerId
   * @param  int  $customerId
   *
   * @return  self
   */ 
  public function setCustomerId(int $customerId): self
  {
    $this->customerId = $customerId;

    return $this;
  }

  /**
   * Get the value of studioId
   * @return  int
   */ 
  public function getStudioId(): int
  {
    return $this->studioId;
  }

  /**
   * Set the value of studioId
   * @param  int  $studioId
   *
   * @return  self
   */ 
  public function setStudioId(int $studioId): self
  {
    $this->studioId = $studioId;

    return $this;
  }

  /**
   * Get the value of isStudio
   * @return  int
   */ 
  public function getIsStudio(): int
  {
    return $this->isStudio;
  }

  /**
   * Set the value of isStudio
   * @param  int  $isStudio
   *
   * @return  self
   */ 
  public function setIsStudio(int $isStudio): self
  {
    $this->isStudio = $isStudio;

    return $this;
  }

  /**
   * Get the value of isCustomer
   * @return  int
   */ 
  public function getIsCustomer(): int
  {
    return $this->isCustomer;
  }

  /**
   * Set the value of isCustomer
   * @param  int  $isCustomer
   *
   * @return  self
   */ 
  public function setIsCustomer(int $isCustomer): self
  {
    $this->isCustomer = $isCustomer;

    return $this;
  }
}
