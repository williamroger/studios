<?php 

namespace App\Models;

final class ScheduleModel 
{ 
  /**
   * @var int
   */
  private $id;
  /**
   * @var string
   */
  private $dateScheduling;
  /**
   * @var int
   */
  private $status;
  /**
   * @var string
   */
  private $dateCancellation;
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
   * @var string
   */
  private $comment;

  /**
   * @return  int
   */ 
  public function getId(): int
  {
    return $this->id;
  }

  /**
   * @param  int  $id
   * @return  self
   */ 
  public function setId(int $id): self
  {
    $this->id = $id;

    return $this;
  }

  /**
   * @return  string
   */ 
  public function getDateScheduling(): string
  {
    return $this->dateScheduling;
  }

  /**
   * @param  string  $dateScheduling
   * @return  self
   */ 
  public function setDateScheduling(string $dateScheduling): self
  {
    $this->dateScheduling = $dateScheduling;

    return $this;
  }

  /**
   * @return  int
   */ 
  public function getStatus(): ?int
  {
    return $this->status;
  }

  /**
   * @param  int  $status
   * @return  self
   */ 
  public function setStatus(int $status): self
  {
    $this->status = $status;

    return $this;
  }

  /**
   * @return  string
   */ 
  public function getDateCancellation(): ?string
  {
    return $this->dateCancellation;
  }

  /**
   * @param  string  $dateCancellation
   * @return  self
   */ 
  public function setDateCancellation(string $dateCancellation): self
  {
    $this->dateCancellation = $dateCancellation;

    return $this;
  }

  /**
   * @return  string
   */ 
  public function getCreatedAt(): ?string
  {
    return $this->createdAt;
  }

  /**
   * @param  string  $createdAt
   * @return  self
   */ 
  public function setCreatedAt(string $createdAt): self
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  /**
   * @return  string
   */ 
  public function getUpdatedAt(): ?string
  {
    return $this->updatedAt;
  }

  /**
   * @param  string  $updatedAt
   * @return  self
   */ 
  public function setUpdatedAt(string $updatedAt): self
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }

  /**
   * @return  int
   */ 
  public function getCustomerId(): int
  {
    return $this->customerId;
  }

  /**
   * @param  int  $customerId
   * @return  self
   */ 
  public function setCustomerId(int $customerId): self
  {
    $this->customerId = $customerId;

    return $this;
  }

  /**
   * @return  string
   */ 
  public function getComment(): ?string
  {
    return $this->comment;
  }

  /**
   * @param  string  $comment
   * @return  self
   */ 
  public function setComment(string $comment): self
  {
    $this->comment = $comment;

    return $this;
  }
}