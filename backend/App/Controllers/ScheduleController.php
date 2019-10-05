<?php

namespace App\Controllers;

use App\Controllers\UtilController;
use App\DAO\SchedulesDAO;
use App\Models\ScheduleModel;
use App\Models\SchedulePeriodModel;
use DateTimeZone;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ScheduleController 
{
  public function insertSchedule(Request $request, Response $response, array $args) 
  {
    try {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d H:i:s');
      $idCustomer = intval($data['customer_id']);
      $idSchedule = null;

      if (!$idCustomer)
        throw new Exception('Erro na aplicação, tente novamente.');
      
      if (!$data['date_scheduling'] || $data['date_scheduling'] == '')
        throw new Exception('Você precisa informar a data do agendamento.');
      
      if (!$data['time_period_id'] || $data['time_period_id'] == '')
        throw new Exception('Você precisa escolher um período de ensaio.');
        
      $schedule = new ScheduleModel();
      $schedulePeriod = new SchedulePeriodModel();
      $scheduleDAO = new SchedulesDAO();

      $schedule->setDateScheduling($data['date_scheduling'])
      ->setStatus(0)
      ->setCreatedAt($now)
      ->setCustomerId($idCustomer)
      ->setComment($data['comment']);

      $idSchedule = $scheduleDAO->insertSchedule($schedule);

      $schedulePeriod->setScheduleId(intval($idSchedule))
      ->setTimePeriodId($data['time_period_id']);

      $scheduleDAO->insertScheduleTimePeriod($schedulePeriod);

      $response = $response->withJson([
        'success' => true,
        'msg' => 'Ensaio agendado com sucesso!'
      ], 200);

      return $response;
    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }
}