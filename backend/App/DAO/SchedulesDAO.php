<?php

namespace App\DAO;

use App\Models\ScheduleModel;
use App\Models\SchedulePeriodModel;

class SchedulesDAO extends ConnectionDataBase 
{
  public function __construct()
  {
    parent::__construct();
  }

  public function insertSchedule(ScheduleModel $schedule): string 
  { 
    $statement = $this->pdo
      ->prepare('INSERT INTO schedules
	                  (date_scheduling,
                     status,
                     created_at,
                     customer_id,
                     comment)
                 VALUES
                    (:date_scheduling,
                     :status,
                     :created_at,
                     :customer_id,
                     :comment);');
    
    $statement->execute([
      'date_scheduling' => $schedule->getDateScheduling(),
      'status'          => $schedule->getStatus(),
      'created_at'      => $schedule->getCreatedAt(),
      'customer_id'     => $schedule->getCustomerId(),
      'comment'         => $schedule->getComment()
    ]);

    return $this->pdo->lastInsertId();
  }

  public function insertScheduleTimePeriod(SchedulePeriodModel $schedulePeriod): void 
  {
    $statement = $this->pdo
      ->prepare('INSERT INTO schedules_time_periods
                   (schedule_id, time_period_id)
                 VALUES
                   (:schedule_id, :time_period_id);');
    $statement->execute([
      'schedule_id'    => $schedulePeriod->getScheduleId(),
      'time_period_id' => $schedulePeriod->getTimePeriodId()
    ]);
  }
}