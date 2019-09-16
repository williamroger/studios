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
  private $studio_id;
  /**
   * @var string
   */
  private $name;
  /**
   * @var int
   */
  private $maximum_capacity;
  /**
   * @var string
   */
  private $color;
  /**
   * @var string
   */
  private $created_at;
  /**
   * @var string
   */
  private $updated_at;

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
  public function setId(int $id)
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
  public function setDescription(string $description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get the value of studio_id
   *
   * @return  int
   */ 
  public function getStudio_id()
  {
    return $this->studio_id;
  }

  /**
   * Set the value of studio_id
   *
   * @param  int  $studio_id
   *
   * @return  self
   */ 
  public function setStudio_id(int $studio_id)
  {
    $this->studio_id = $studio_id;

    return $this;
  }

  /**
   * Get the value of name
   *
   * @return  string
   */ 
  public function getName()
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
  public function setName(string $name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * Get the value of maximum_capacity
   *
   * @return  int
   */ 
  public function getMaximum_capacity()
  {
    return $this->maximum_capacity;
  }

  /**
   * Set the value of maximum_capacity
   *
   * @param  int  $maximum_capacity
   *
   * @return  self
   */ 
  public function setMaximum_capacity(int $maximum_capacity)
  {
    $this->maximum_capacity = $maximum_capacity;

    return $this;
  }

  /**
   * Get the value of color
   *
   * @return  string
   */ 
  public function getColor()
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
  public function setColor(string $color)
  {
    $this->color = $color;

    return $this;
  }

  /**
   * Get the value of created_at
   *
   * @return  string
   */ 
  public function getCreated_at()
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
  public function setCreated_at(string $created_at)
  {
    $this->created_at = $created_at;

    return $this;
  }

  /**
   * Get the value of updated_at
   *
   * @return  string
   */ 
  public function getUpdated_at()
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
  public function setUpdated_at(string $updated_at)
  {
    $this->updated_at = $updated_at;

    return $this;
  }
}