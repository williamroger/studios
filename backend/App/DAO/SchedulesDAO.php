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

  public function newSchedule(ScheduleModel $schedule): string 
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

  public function getSchedulesByStudioId(int $scheduleId): ?array 
  {
    $statement = $this->pdo
      ->prepare('SELECT * FROM schedules_time_periods
                 INNER JOIN schedules ON schedules.id = schedules_time_periods.schedule_id
                 INNER JOIN time_periods ON time_periods.id = schedules_time_periods.time_period_id
                 INNER JOIN rooms ON time_periods.room_id = rooms.id
                 WHERE rooms.studio_id = :id;');

    $statement->bindParam('id', $scheduleId);

    $statement->execute();

    $schedules = $statement->fetchAll(\PDO::FETCH_ASSOC);

    if (count($schedules) === 0)
      return null;
    
    return $schedules;
  }

  public function getSchedulesByStudioIdAndDate(int $scheduleId, string $date): ?array 
  {
    $statement = $this->pdo
      ->prepare('SELECT * FROM schedules_time_periods
                 INNER JOIN schedules ON schedules.id = schedules_time_periods.schedule_id
                 INNER JOIN time_periods ON time_periods.id = schedules_time_periods.time_period_id
                 INNER JOIN rooms ON time_periods.room_id = rooms.id
                 INNER JOIN customers ON customers.id = schedules.customer_id
                 WHERE rooms.studio_id = :id AND schedules.date_scheduling = :date');
    
    $statement->execute([
      'id'   => $scheduleId,
      'date' => $date
    ]);

    $schedules = $statement->fetchAll(\PDO::FETCH_ASSOC);

    if (count($schedules) === 0)
      return null;

    return $schedules;
  }

  public function getSchedulesByCustomerId(int $customerId): ?array 
  {
    $statement = $this->pdo
      ->prepare('SELECT * FROM schedules_time_periods
                 INNER JOIN schedules ON schedules.id = schedules_time_periods.schedule_id
                 INNER JOIN time_periods ON time_periods.id = schedules_time_periods.time_period_id
                 INNER JOIN rooms ON time_periods.room_id = rooms.id
                 WHERE schedules.customer_id = :id
                 ORDER BY schedules.date_scheduling DESC;');

    $statement->bindParam('id', $customerId);
    
    $statement->execute();

    $schedules = $statement->fetchAll(\PDO::FETCH_ASSOC);

    if (count($schedules) === 0)
      return null;

    return $schedules;
  }

  public function getPeriodsFreeByRoomIdAndDate(int $roomId, string $day, string $date): ?array
  {
    $statement = $this->pdo
      ->prepare('SELECT * FROM time_periods
                 WHERE  time_periods.room_id = :id 
                 AND time_periods.day = :day 
                 AND time_periods.id NOT IN (
												                    SELECT schedules_time_periods.time_period_id FROM schedules_time_periods
											                      INNER JOIN schedules ON schedules.id = schedules_time_periods.schedule_id
												                    LEFT JOIN time_periods ON time_periods.id = schedules_time_periods.time_period_id AND time_periods.room_id = :id
												                    WHERE schedules.date_scheduling = :date
                                            )
                ORDER BY day_order;');

    $statement->execute([
      'id' => $roomId,
      'day' => $day,
      'date' => $date
    ]);

    $periods = $statement->fetchAll(\PDO::FETCH_ASSOC);

    if (count($periods) === 0)
      return null;
    
    return $periods;
  }
}