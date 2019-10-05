<?php

namespace App\Models;

final class SchedulePeriodModel 
{
  /**
   * @var int
   */
  private $id;
  /**
   * @var int
   */
  private $scheduleId;
  /**
   * @var int
   */
  private $timePeriodId;

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
   * @return  int
   */ 
  public function getScheduleId(): int
  {
    return $this->scheduleId;
  }

  /**
   * @param  int  $scheduleId
   * @return  self
   */ 
  public function setScheduleId(int $scheduleId): self
  {
    $this->scheduleId = $scheduleId;

    return $this;
  }

  /**
   * @return  int
   */ 
  public function getTimePeriodId(): int
  {
    return $this->timePeriodId;
  }

  /**
   * @param  int  $timePeriodId
   * @return  self
   */ 
  public function setTimePeriodId(int $timePeriodId): self
  {
    $this->timePeriodId = $timePeriodId;

    return $this;
  }
}