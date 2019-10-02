<?php

namespace App\Models;

final class TimePeriodModel
{
  /**
   * @var int
   */
  private $id;
  /**
   * @var int
   */
  private $roomId;
  /**
   * @var string
   */
  private $amount;
  /**
   * @var string
   */
  private $day;
  /**
   * @var string
   */
  private $priceRate;
  /**
   * @var string
   */
  private $beginPeriod;
  /**
   * @var string
   */
  private $endPeriod;
  /**
   * @var string
   */
  private $createdAt;
  /**
   * @var string
   */
  private $updatedAt;

  /**
   * @return  int
   */ 
  public function getId(): int
  {
    return $this->id;
  }

  /**
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
   * @return  int
   */ 
  public function getRoomId(): int
  {
    return $this->roomId;
  }

  /**
   * @param  int  $roomId
   *
   * @return  self
   */ 
  public function setRoomId(int $roomId): self
  {
    $this->roomId = $roomId;

    return $this;
  }

  /**
   * @return  string
   */ 
  public function getAmount(): string
  {
    return $this->amount;
  }

  /**
   * @param  string  $amount
   *
   * @return  self
   */ 
  public function setAmount(string $amount): self
  {
    $this->amount = $amount;

    return $this;
  }

  /**
   * @return  string
   */ 
  public function getDay(): string
  {
    return $this->day;
  }

  /**
   * @param  string  $day
   *
   * @return  self
   */ 
  public function setDay(string $day): self
  {
    $this->day = $day;

    return $this;
  }

  /**
   * @return  string
   */ 
  public function getPriceRate(): ?string
  {
    return $this->priceRate;
  }

  /**
   * @param  string  $priceRate
   *
   * @return  self
   */ 
  public function setPriceRate(?string $priceRate): self
  {
    $this->priceRate = $priceRate;

    return $this;
  }

  /**
   * @return  string
   */ 
  public function getBeginPeriod(): string
  {
    return $this->beginPeriod;
  }

  /**
   * @param  string  $beginPeriod
   *
   * @return  self
   */ 
  public function setBeginPeriod(string $beginPeriod): self
  {
    $this->beginPeriod = $beginPeriod;

    return $this;
  }

  /**
   * @return  string
   */ 
  public function getEndPeriod(): string
  {
    return $this->endPeriod;
  }

  /**
   * @param  string  $endPeriod
   *
   * @return  self
   */ 
  public function setEndPeriod(string $endPeriod): self
  {
    $this->endPeriod = $endPeriod;

    return $this;
  }

  /**
   * @return  string
   */ 
  public function getCreatedAt(): string
  {
    return $this->createdAt;
  }

  /**
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
   * @return  string
   */ 
  public function getUpdatedAt(): string
  {
    return $this->updatedAt;
  }

  /**
   * @param  string  $updatedAt
   *
   * @return  self
   */ 
  public function setUpdatedAt(string $updatedAt): self
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }
}
