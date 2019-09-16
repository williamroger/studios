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
  private $name;

  /**
   * @var string
   */
  private $phone;

  /**
   * @var string
   */
  private $created_at;

  /**
   * @var string
   */
  private $updated_at;
  
  /**
   * @var string
   */
  private $cpf;
  
  /**
   * @var int
   */
  private $city_id;

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
  public function setId(int $id): self
  {
      $this->id = $id;

      return $this;
  }

  /**
   * Get the value of name
   *
   * @return  string
   */ 
  public function getName(): string
  {
      return $this->name;
  }

  /**
   * Set the value of name
   *
   * @param  string  $name
   *
   * @return  self
   */ 
  public function setName(string $name): self
  {
      $this->name = $name;

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
  public function setPhone(string $phone): self
  {
      $this->phone = $phone;

      return $this;
  }

  /**
   * Get the value of created_at
   *
   * @return  string
   */ 
  public function getCreated_at(): string
  {
      return $this->created_at;
  }

  /**
   * Set the value of created_at
   *
   * @param  string  $created_at
   *
   * @return  self
   */ 
  public function setCreated_at(string $created_at): self
  {
      $this->created_at = $created_at;

      return $this;
  }

  /**
   * Get the value of updated_at
   *
   * @return  string
   */ 
  public function getUpdated_at(): string
  {
      return $this->updated_at;
  }

  /**
   * Set the value of updated_at
   *
   * @param  string  $updated_at
   *
   * @return  self
   */ 
  public function setUpdated_at(string $updated_at): self
  {
      $this->updated_at = $updated_at;

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
  public function setCpf(string $cpf): self
  {
      $this->cpf = $cpf;

      return $this;
  }

  /**
   * Get the value of city_id
   *
   * @return  int
   */ 
  public function getCity_id(): int
  {
      return $this->city_id;
  }

  /**
   * Set the value of city_id
   *
   * @param  int  $city_id
   *
   * @return  self
   */ 
  public function setCity_id(int $city_id): self
  {
      $this->city_id = $city_id;

      return $this;
  }
}