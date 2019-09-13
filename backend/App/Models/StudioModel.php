<?php

namespace App\Models;

final class StudioModel 
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
  private $address;
  /**
   * @var string
   */
  private $phone;
  /**
   * @var string
   */
  private $description;
  /**
   * @var string
   */
  private $cnpj;
  /**
   * @var string
   */
  private $telephone;
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
  private $hasParking;
  /**
   * @var int
   */
  private $is24Hours;
  /**
   * @var int
   */
  private $cityId;
  /**
   * @var int
   */
  private $rateCancellation;
  /**
   * @var int
   */
  private $daysCancellation;

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
   * Get the value of name
   * @return  string
   */ 
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * Set the value of name
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
   * Get the value of address
   * @return  string
   */ 
  public function getAddress(): string
  {
    return $this->address;
  }

  /**
   * Set the value of address
   * @param  string  $address
   *
   * @return  self
   */ 
  public function setAddress(string $address): self
  {
    $this->address = $address;

    return $this;
  }

  /**
   * Get the value of phone
   * @return  string
   */ 
  public function getPhone(): string
  {
    return $this->phone;
  }

  /**
   * Set the value of phone
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
   * Get the value of description
   * @return  string
   */ 
  public function getDescription(): string
  {
    return $this->description;
  }

  /**
   * Set the value of description
   * @param  string  $description
   *
   * @return  self
   */ 
  public function setDescription(string $description): self
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get the value of cnpj
   * @return  string
   */ 
  public function getCnpj(): string
  {
    return $this->cnpj;
  }

  /**
   * Set the value of cnpj
   * @param  string  $cnpj
   *
   * @return  self
   */ 
  public function setCnpj(string $cnpj): self
  {
    $this->cnpj = $cnpj;

    return $this;
  }

  /**
   * Get the value of telephone
   * @return  string
   */ 
  public function getTelephone(): string
  {
    return $this->telephone;
  }

  /**
   * Set the value of telephone
   * @param  string  $telephone
   *
   * @return  self
   */ 
  public function setTelephone(string $telephone): self
  {
    $this->telephone = $telephone;

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
   * Get the value of hasParking
   * @return  int
   */ 
  public function getHasParking(): int
  {
    return $this->hasParking;
  }

  /**
   * Set the value of hasParking
   * @param  int  $hasParking
   *
   * @return  self
   */ 
  public function setHasParking(int $hasParking): self
  {
    $this->hasParking = $hasParking;

    return $this;
  }

  /**
   * Get the value of is24Hours
   * @return  int
   */ 
  public function getIs24Hours(): int
  {
    return $this->is24Hours;
  }

  /**
   * Set the value of is24Hours
   * @param  int  $is24Hours
   *
   * @return  self
   */ 
  public function setIs24Hours(int $is24Hours): self
  {
    $this->is24Hours = $is24Hours;

    return $this;
  }

  /**
   * Get the value of cityId
   * @return  int
   */ 
  public function getCityId(): int
  {
    return $this->cityId;
  }

  /**
   * Set the value of cityId
   * @param  int  $cityId
   *
   * @return  self
   */ 
  public function setCityId(int $cityId): self
  {
    $this->cityId = $cityId;

    return $this;
  }

  /**
   * Get the value of rateCancellation
   * @return  int
   */ 
  public function getRateCancellation(): int
  {
    return $this->rateCancellation;
  }

  /**
   * Set the value of rateCancellation
   * @param  int  $rateCancellation
   *
   * @return  self
   */ 
  public function setRateCancellation(int $rateCancellation): self
  {
    $this->rateCancellation = $rateCancellation;

    return $this;
  }

  /**
   * Get the value of daysCancellation
   * @return  int
   */ 
  public function getDaysCancellation(): int
  {
    return $this->daysCancellation;
  }

  /**
   * Set the value of daysCancellation
   * @param  int  $daysCancellation
   *
   * @return  self
   */ 
  public function setDaysCancellation(int $daysCancellation): self
  {
    $this->daysCancellation = $daysCancellation;

    return $this;
  }
}