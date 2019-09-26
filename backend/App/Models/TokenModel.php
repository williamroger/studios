<?php

namespace App\Models;

final class TokenModel 
{ 
  /**
   * @var int
   */
  private $id;
  /**
   * @var string
   */
  private $token;
  /**
   * @var string
   */
  private $refreshToken;
  /**
   * @var string
   */
  private $expiredAt;
  /**
   * @var int
   */
  private $userId;
  /**
   * @var int
   */
  private $active;

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
   * Get the value of token
   *
   * @return  string
   */ 
  public function getToken(): string
  {
    return $this->token;
  }

  /**
   * Set the value of token
   *
   * @param  string  $token
   *
   * @return  self
   */ 
  public function setToken(string $token): self
  {
    $this->token = $token;

    return $this;
  }

  /**
   * Get the value of refreshToken
   *
   * @return  string
   */ 
  public function getRefreshToken(): string
  {
    return $this->refreshToken;
  }

  /**
   * Set the value of refreshToken
   *
   * @param  string  $refreshToken
   *
   * @return  self
   */ 
  public function setRefreshToken(string $refreshToken): self
  {
    $this->refreshToken = $refreshToken;

    return $this;
  }

  /**
   * Get the value of expiredAt
   *
   * @return  string
   */ 
  public function getExpiredAt(): string
  {
    return $this->expiredAt;
  }

  /**
   * Set the value of expiredAt
   *
   * @param  string  $expiredAt
   *
   * @return  self
   */ 
  public function setExpiredAt(string $expiredAt): self
  {
    $this->expiredAt = $expiredAt;

    return $this;
  }

  /**
   * Get the value of userId
   *
   * @return  int
   */ 
  public function getUserId(): int
  {
    return $this->userId;
  }

  /**
   * Set the value of userId
   *
   * @param  int  $userId
   *
   * @return  self
   */ 
  public function setUserId(int $userId): self
  {
    $this->userId = $userId;

    return $this;
  }

  /**
   * Get the value of active
   *
   * @return  int
   */ 
  public function getActive(): int
  {
    return $this->active;
  }

  /**
   * Set the value of active
   *
   * @param  int  $active
   *
   * @return  self
   */ 
  public function setActive(?int $active): self
  {
    $this->active = $active;

    return $this;
  }
}