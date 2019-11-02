<?php

namespace App\Controllers;

use App\Controllers\UtilController;
use App\DAO\SchedulesDAO;
use App\DAO\StudiosDAO;
use App\Models\ScheduleModel;
use App\Models\SchedulePeriodModel;
use DateTimeZone;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ScheduleController 
{
  public function newSchedule(Request $request, Response $response, array $args): Response 
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

      $idSchedule = $scheduleDAO->newSchedule($schedule);

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

  public function getSchedulesByStudioId(Request $request, Response $response, array $args): Response
  {
    try {
      $studioId = intval($args['id']);
      $studioDAO = new StudiosDAO();
      $scheduleDAO = new SchedulesDAO();
      
      if (!$studioId)
        throw new Exception('Erro na aplicação, tente novamente.');

      if ($studioDAO->studioExists($studioId) == 0)
        throw new \Exception("Não encontramos esse estúdio em nossa base de dados.");

      $schedules = $scheduleDAO->getSchedulesByStudioId($studioId);
      
      $response = $response->withJson([
        'success' => true,
        'schedules' => $schedules
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);      
    }
  }

  public function getSchedulesByStudioIdAndDate(Request $request, Response $response, array $args): Response 
  {
    try {
      $studioId = intval($args['id']);
      $date = $args['date'];
      
      if (!$studioId)
        throw new Exception('Erro na aplicação, tente novamente.');
      
      if (!$date || $date == '')
        throw new Exception('Você precisa informar uma data');

      $scheduleDAO = new SchedulesDAO();
      
      $schedules = $scheduleDAO->getSchedulesByStudioIdAndDate($studioId, $date);

      $response = $response->withJson([
        'success' => true,
        'schedules' => $schedules
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }

  public function getSchedulesByCustomerId(Request $request, Response $response, array $args): Response
  {
    try {
      $idCustomer = intval($args['id']);
      
      if (!$idCustomer)
        throw new Exception('Erro na aplicação, tente novamente.');
      
      $scheduleDAO = new SchedulesDAO();

      $schedules = $scheduleDAO->getSchedulesByCustomerId($idCustomer);

      $response = $response->withJson([
        'success' => true,
        'schedules' => $schedules
      ], 200);

      return $response;
      
    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }

  public function getPeriodsFreeByRoomIdAndDate(Request $request, Response $response, array $args): Response 
  {
    try {
      $roomId = intval($args['id']);
      $day = $args['day'];
      $date = $args['date'];

      if (!$roomId)
        throw new Exception('Erro na aplicação, tente novamente.');
      
      if (!$date || $date == '')
        throw new Exception('Você precisa informar uma data');
      
      $scheduleDAO = new SchedulesDAO();

      $periods = $scheduleDAO->getPeriodsFreeByRoomIdAndDate($roomId, $day, $date);

      $response = $response->withJson([
        'success' => true,
        'periods' => $periods
      ], 200);

      return $response;
        
    } catch (\Exception $ex) {
      return $request->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }
}