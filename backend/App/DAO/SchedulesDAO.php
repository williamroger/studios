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
      ->prepare('SELECT 
                    schedules_time_periods.*, 
                    studios.name AS studio_name,
                    schedules.status,
                    schedules.date_cancellation,
                    schedules.user_cancellation,
                    schedules.created_at,
                    schedules.updated_at,
                    schedules.customer_id,
                    schedules.comment,
                    schedules.date_scheduling,
                    time_periods.id AS time_period_id, 
                    time_periods.amount,
                    time_periods.room_id,
                    time_periods.day,
                    time_periods.price_rate,
                    time_periods.begin_period,
                    time_periods.end_period,
                    time_periods.day_order,
                    rooms.studio_id,
                    rooms.name AS room_name,
                    rooms.maximum_capacity
                  FROM schedules_time_periods
                  INNER JOIN schedules ON schedules.id = schedules_time_periods.schedule_id
                  INNER JOIN time_periods ON time_periods.id = schedules_time_periods.time_period_id
                  INNER JOIN rooms ON time_periods.room_id = rooms.id
                  INNER JOIN studios ON studios.id = rooms.studio_id 
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
												                    WHERE schedules.date_scheduling = :date AND schedules_time_periods.schedule_cancelled IS NULL
                                            )
                 OR time_periods.id IN (
                                        SELECT schedules_time_periods.time_period_id FROM schedules_time_periods
                                        INNER JOIN schedules ON schedules.id = schedules_time_periods.schedule_id
                                        LEFT JOIN time_periods ON time_periods.id = schedules_time_periods.time_period_id AND time_periods.room_id = :id
                                        WHERE schedules.date_scheduling = :date AND schedules_time_periods.schedule_cancelled = "true"
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

  public function schedulingExists(int $idSchedule, int $idCustomer): int 
  {
    $statement = $this->pdo
      ->prepare('SELECT 
                    id,
                    customer_id
                 FROM 
                    schedules
                 WHERE id = :id AND customer_id = :customer_id;');

    $statement->execute([
      'id' => $idSchedule,
      'customer_id' => $idCustomer
    ]);

    return $statement->rowCount(\PDO::FETCH_ASSOC);
  }

  public function confirmScheduling(int $idSchedule, string $date): void 
  {
    $statement = $this->pdo
      ->prepare('UPDATE schedules SET
                  status = 1,
                  updated_at = :updated_at
                 WHERE id = :id;');

    $statement->execute([
      'id' => $idSchedule,
      'updated_at' => $date
    ]);
  }

  public function studioCancelScheduling(int $idSchedule, string $date): void
  {
    $statement = $this->pdo
      ->prepare('UPDATE schedules SET
                  status = 2,
                  updated_at = :updated_at,
                  date_cancellation = :date_cancellation,
                  user_cancellation = "Estúdio"
                 WHERE id = :id;');

    $statement->execute([
      'id' => $idSchedule,
      'updated_at' => $date,
      'date_cancellation' => $date
    ]);
  }

  public function userCancelScheduling(int $idSchedule, string $date): void
  {
    $statement = $this->pdo
      ->prepare('UPDATE schedules, schedules_time_periods SET
                  schedules.status = 2,
                  schedules.updated_at = :updated_at,
                  schedules.date_cancellation = :date_cancellation,
                  schedules.user_cancellation = "Usuário",
                  schedules_time_periods.schedule_cancelled = "true"
                 WHERE schedules.id = :id AND schedules_time_periods.schedule_id = :id;');

    $statement->execute([
      'id' => $idSchedule,
      'updated_at' => $date,
      'date_cancellation' => $date
    ]);
  }
}