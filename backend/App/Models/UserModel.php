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
  private $created_at;
  /**
   * @var string
   */
  private $updated_at;
  /**
   * @var int
   */
  private $customer_id;
  /**
   * @var int
   */
  private $studio_id;
  /**
   * @var int
   */
  private $is_studio;
  /**
   * @var int
   */
  private $is_customer;

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
   * Get the value of created_at
   * @return  string
   */ 
  public function getCreated_at(): string
  {
    return $this->created_at;
  }

  /**
   * Set the value of created_at
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
   * @return  string
   */ 
  public function getUpdated_at(): string
  {
    return $this->updated_at;
  }

  /**
   * Set the value of updated_at
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
   * Get the value of customer_id
   * @return  int
   */ 
  public function getCustomer_id(): int
  {
    return $this->customer_id;
  }

  /**
   * Set the value of customer_id
   * @param  int  $customer_id
   *
   * @return  self
   */ 
  public function setCustomer_id(int $customer_id): self
  {
    $this->customer_id = $customer_id;

    return $this;
  }

  /**
   * Get the value of studio_id
   * @return  int
   */ 
  public function getStudio_id(): int
  {
    return $this->studio_id;
  }

  /**
   * Set the value of studio_id
   * @param  int  $studio_id
   *
   * @return  self
   */ 
  public function setStudio_id(int $studio_id): self
  {
    $this->studio_id = $studio_id;

    return $this;
  }

  /**
   * Get the value of is_studio
   * @return  int
   */ 
  public function getIs_studio(): int
  {
    return $this->is_studio;
  }

  /**
   * Set the value of is_studio
   * @param  int  $is_studio
   *
   * @return  self
   */ 
  public function setIs_studio(int $is_studio): self
  {
    $this->is_studio = $is_studio;

    return $this;
  }

  /**
   * Get the value of is_customer
   * @return  int
   */ 
  public function getIs_customer(): int
  {
    return $this->is_customer;
  }

  /**
   * Set the value of is_customer
   * @param  int  $is_customer
   *
   * @return  self
   */ 
  public function setIs_customer(int $is_customer): self
  {
    $this->is_customer = $is_customer;

    return $this;
  }
}
