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
  private $createdAt;
  /**
   * @var string
   */
  private $updatedAt;
  /**
   * @var int
   */
  private $hasParking;
  /**
   * @var int
   */
  private $hasWifi;
  /**
   * @var int
   */
  private $hasRecording;
  /**
   * @var int
   */
  private $hasMixingMastering;
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
   * @var string
   */
  private $zipCode;
  /**
   * @var string
   */
  private $street;
  /**
   * @var string
   */
  private $complement;
  /**
   * @var string
   */
  private $district;
  /**
   * @var string
   */
  private $number;
  /**
   * @var string
   */
  private $image;


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
  public function setId(?int $id): self
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
  public function setName(?string $name): self
  {
    $this->name = $name;

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
  public function setPhone(?string $phone): self
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
  public function setDescription(?string $description): self
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get the value of cnpj
   * @return  string
   */ 
  public function getCnpj(): ?string
  {
    return $this->cnpj;
  }

  /**
   * Set the value of cnpj
   * @param  string  $cnpj
   *
   * @return  self
   */ 
  public function setCnpj(?string $cnpj): self
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
  public function setTelephone(?string $telephone): self
  {
    $this->telephone = $telephone;

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
  public function setCreatedAt(?string $createdAt): self
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
  public function setUpdatedAt(?string $updatedAt): self
  {
    $this->updatedAt = $updatedAt;

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
  public function setHasParking(?int $hasParking): self
  {
    $this->hasParking = $hasParking;

    return $this;
  }

  /**
   * Get the value of hasWifi
   * @return  int
   */
  public function getHasWifi(): int
  {
    return $this->hasWifi;
  }

  /**
   * Set the value of hasWifi
   * @param  int  $hasWifi
   *
   * @return  self
   */
  public function setHasWifi(?int $hasWifi): self
  {
    $this->hasWifi = $hasWifi;

    return $this;
  }

  /**
   * Get the value of hasRecording
   * @return  int
   */
  public function getHasRecording(): int
  {
    return $this->hasRecording;
  }

  /**
   * Set the value of hasRecording
   * @param  int  $hasRecording
   * @return  self
   */
  public function setHasRecording(?int $hasRecording): self
  {
    $this->hasRecording = $hasRecording;

    return $this;
  }

  /**
   * Get the value of hasMixingMastering
   * @return  int
   */
  public function getHasMixingMastering(): int
  {
    return $this->hasMixingMastering;
  }

  /**
   * Set the value of hasMixingMastering
   * @param  int  $hasMixingMastering
   * @return  self
   */
  public function setHasMixingMastering(?int $hasMixingMastering): self
  {
    $this->hasMixingMastering = $hasMixingMastering;

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
  public function setIs24Hours(?int $is24Hours): self
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
  public function setCityId(?int $cityId): self
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
  public function setRateCancellation(?int $rateCancellation): self
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
  public function setDaysCancellation(?int $daysCancellation): self
  {
    $this->daysCancellation = $daysCancellation;

    return $this;
  }

  /**
   * Get the value of zipCode
   *
   * @return  string
   */ 
  public function getZipCode(): string
  {
    return $this->zipCode;
  }

  /**
   * Set the value of zipCode
   *
   * @param  string  $zipCode
   *
   * @return  self
   */ 
  public function setZipCode(?string $zipCode): self
  {
    $this->zipCode = $zipCode;

    return $this;
  }

  /**
   * Get the value of street
   *
   * @return  string
   */ 
  public function getStreet(): string
  {
    return $this->street;
  }

  /**
   * Set the value of street
   *
   * @param  string  $street
   *
   * @return  self
   */ 
  public function setStreet(?string $street): self
  {
    $this->street = $street;

    return $this;
  }

  /**
   * Get the value of complement
   *
   * @return  string
   */ 
  public function getComplement(): string
  {
    return $this->complement;
  }

  /**
   * Set the value of complement
   *
   * @param  string  $complement
   *
   * @return  self
   */ 
  public function setComplement(?string $complement): self
  {
    $this->complement = $complement;

    return $this;
  }

  /**
   * Get the value of district
   *
   * @return  string
   */ 
  public function getDistrict(): string
  {
    return $this->district;
  }

  /**
   * Set the value of district
   *
   * @param  string  $district
   *
   * @return  self
   */ 
  public function setDistrict(?string $district): self
  {
    $this->district = $district;

    return $this;
  }

  /**
   * Get the value of number
   *
   * @return  string
   */ 
  public function getNumber(): string
  {
    return $this->number;
  }

  /**
   * Set the value of number
   *
   * @param  string  $number
   *
   * @return  self
   */ 
  public function setNumber(?string $number): self
  {
    $this->number = $number;

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