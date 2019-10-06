<?php

namespace App\Models;

final class CustomerModel
{
  /**
   * @var int
   */
  private $id;
  /**
   * @var string
   */
  private $firstname;
  /**
   * @var string
   */
  private $lastname;
  /**
   * @var string
   */
  private $phone;

  /**
   * @var string
   */
  private $createdAt;

  /**
   * @var string
   */
  private $updatedAt;
  
  /**
   * @var string
   */
  private $cpf;
  
  /**
   * @var int
   */
  private $cityId;
  /**
   * @var string
   */
  private $image;

  /**
   * Get the value of id
   *
   * @return  int
   */ 
  public function getId(): int
  {
      return $this->id;
  }

  /**
   * Set the value of id
   *
   * @param  int  $id
   *
   * @return  self
   */ 
  public function setId(?int $id): self
  {
      $this->id = $id;

      return $this;
  }

  /**
   * Get the value of firstname
   *
   * @return  string
   */
  public function getFirstname(): string
  {
    return $this->firstname;
  }

  /**
   * Set the value of firstname
   *
   * @param  string  $firstname
   *
   * @return  self
   */
  public function setFirstname(?string $firstname): self
  {
    $this->firstname = $firstname;

    return $this;
  }

  /**
   * Get the value of lastname
   *
   * @return  string
   */
  public function getLastname()
  {
    return $this->lastname;
  }

  /**
   * Set the value of lastname
   *
   * @param  string  $lastname
   *
   * @return  self
   */
  public function setLastname(?string $lastname): self
  {
    $this->lastname = $lastname;

    return $this;
  }

  /**
   * Get the value of phone
   *
   * @return  string
   */ 
  public function getPhone(): string
  {
      return $this->phone;
  }

  /**
   * Set the value of phone
   *
   * @param  string  $phone
   *
   * @return  self
   */ 
  public function setPhone(?string $phone): self
  {
      $this->phone = $phone;

      return $this;
  }

  /**
   * Get the value of createdAt
   *
   * @return  string
   */ 
  public function getCreatedAt(): string
  {
      return $this->createdAt;
  }

  /**
   * Set the value of createdAt
   *
   * @param  string  $createdAt
   *
   * @return  self
   */ 
  public function setCreatedAt(?string $createdAt): self
  {
      $this->createdAt = $createdAt;

      return $this;
  }

  /**
   * Get the value of updatedAt
   *
   * @return  string
   */ 
  public function getUpdatedAt(): string
  {
      return $this->updatedAt;
  }

  /**
   * Set the value of updatedAt
   *
   * @param  string  $updatedAt
   *
   * @return  self
   */ 
  public function setUpdatedAt(?string $updatedAt): self
  {
      $this->updatedAt = $updatedAt;

      return $this;
  }

  /**
   * Get the value of cpf
   *
   * @return  string
   */ 
  public function getCpf(): string
  {
      return $this->cpf;
  }

  /**
   * Set the value of cpf
   *
   * @param  string  $cpf
   *
   * @return  self
   */ 
  public function setCpf(?string $cpf): self
  {
      $this->cpf = $cpf;

      return $this;
  }

  /**
   * Get the value of cityId
   *
   * @return  int
   */ 
  public function getCityId(): int
  {
      return $this->cityId;
  }

  /**
   * Set the value of cityId
   *
   * @param  int  $cityId
   *
   * @return  self
   */ 
  public function setCityId(?int $cityId): self
  {
      $this->cityId = $cityId;

      return $this;
  }

  /**
   * Get the value of image
   *
   * @return  string
   */ 
  public function getImage(): ?string
  {
    return $this->image;
  }

  /**
   * Set the value of image
   *
   * @param  string  $image
   *
   * @return  self
   */ 
  public function setImage(?string $image): self
  {
    $this->image = $image;

    return $this;
  }
}