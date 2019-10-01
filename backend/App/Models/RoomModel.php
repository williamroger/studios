<?php

namespace App\Models;

final class RoomModel 
{
  /**
   * @var int
   */
  private $id;
  /**
   * @var string
   */
  private $description;
  /**
   * @var int
   */
  private $studioId;
  /**
   * @var string
   */
  private $name;
  /**
   * @var int
   */
  private $maximumCapacity;
  /**
   * @var string
   */
  private $color;
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
  private $images;

  /**
   * Get the value of id
   *
   * @return  int
   */ 
  public function getId()
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
  public function setId(?int $id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * Get the value of description
   *
   * @return  string
   */ 
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Set the value of description
   *
   * @param  string  $description
   *
   * @return  self
   */ 
  public function setDescription(?string $description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get the value of $studioId
   *
   * @return  int
   */ 
  public function getStudioId(): int
  {
    return $this->studioId;
  }

  /**
   * Set the value of $studioId
   *
   * @param  int  $$studioId
   *
   * @return  self
   */ 
  public function setStudioId(?int $studioId): self
  {
    $this->studioId = $studioId;

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
  public function setName(?string $name): self
  {
    $this->name = $name;

    return $this;
  }

  /**
   * Get the value of maximumCapacity
   *
   * @return  int
   */ 
  public function getMaximumCapacity(): int
  {
    return $this->maximumCapacity;
  }

  /**
   * Set the value of maximumCapacity
   *
   * @param  int  $maximumCapacity
   *
   * @return  self
   */ 
  public function setMaximumCapacity(?int $maximumCapacity): self
  {
    $this->maximumCapacity = $maximumCapacity;

    return $this;
  }

  /**
   * Get the value of color
   *
   * @return  string
   */ 
  public function getColor(): string
  {
    return $this->color;
  }

  /**
   * Set the value of color
   *
   * @param  string  $color
   *
   * @return  self
   */ 
  public function setColor(?string $color): self
  {
    $this->color = $color;

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
   * Get the value of images
   *
   * @return  string
   */ 
  public function getImages(): ?string
  {
    return $this->images;
  }

  /**
   * Set the value of images
   *
   * @param  string  $images
   *
   * @return  self
   */ 
  public function setImages(string $images): self
  {
    $this->images = $images;

    return $this;
  }
}