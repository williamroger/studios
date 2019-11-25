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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

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

      if ($schedules != null) {
        $response = $response->withJson([
          'success' => true,
          'schedules' => $schedules
        ], 200);
      } else {
        $response = $response->withJson([
          'success' => false,
          'msg' => 'Não tem nenhum ensaio agendado para hoje!'
        ], 200);
      }

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
      
      if ($schedules != null) {
        $response = $response->withJson([
          'success' => true,
          'schedules' => $schedules
        ], 200);
      } else {
        $response = $response->withJson([
          'success' => false,
          'msg' => 'Você ainda não tem nenhum agendamento!'
        ], 200);
      }

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
      
      if ($periods != null) {
        $response = $response->withJson([
          'success' => true,
          'periods' => $periods
        ], 200);
      } else {
        $response = $response->withJson([
          'success' => false,
          'msg' => 'Não temos nenhum período disponível para esta data!'
        ], 200);
      }

      return $response;
        
    } catch (\Exception $ex) {
      return $request->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }

  public function confirmScheduling(Request $request, Response $response, array $args): Response 
  {
    try {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d');
      $idSchedule = intval($data['schedule_id']);
      $idCustomer = intval($data['customer_id']);

      if (!$idSchedule)
        throw new \Exception("Erro na aplicação, tente novamente.");

      $scheduleDAO = new SchedulesDAO();
      
      if (!$scheduleDAO->schedulingExists($idSchedule, $idCustomer)) 
        throw new Exception('Este agendamento não está mais disponível.');

      $scheduleDAO->confirmScheduling($idSchedule, $now);

      $response = $response->withJson([
        'success' => true,
        'msg' => 'Agendamento confirmado com sucesso!'
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  } 

  public function studioCancelScheduling(Request $request, Response $response, array $args): Response
  {
    try {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d');
      $idSchedule = intval($data['schedule_id']);
      $idCustomer = intval($data['customer_id']);

      
      if (!$idSchedule)
        throw new \Exception("Erro na aplicação, tente novamente.");

      $scheduleDAO = new SchedulesDAO();

      if (!$scheduleDAO->schedulingExists($idSchedule, $idCustomer))
        throw new Exception('Este agendamento não está mais disponível.');

      $scheduleDAO->studioCancelScheduling($idSchedule, $now);

      $response = $response->withJson([
        'success' => true,
        'msg' => 'Agendamento cancelado com sucesso!'
      ], 200);

      return $response;
    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    } 
  }

  public function userCancelScheduling(Request $request, Response $response, array $args): Response
  {
    try {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d');
      $idSchedule = intval($data['schedule_id']);
      $idCustomer = intval($data['customer_id']);


      if (!$idSchedule)
        throw new \Exception("Erro na aplicação, tente novamente.");

      $scheduleDAO = new SchedulesDAO();

      if (!$scheduleDAO->schedulingExists($idSchedule, $idCustomer))
        throw new Exception('Este agendamento não está mais disponível.');

      $scheduleDAO->userCancelScheduling($idSchedule, $now);

      $response = $response->withJson([
        'success' => true,
        'msg' => 'Agendamento cancelado com sucesso!'
      ], 200);

      return $response;
    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }

  public function sendEmail(Request $request, Response $response, array $args) 
  {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';                  // Enable verbose debug output
    $mail->Host = 'smtp.gmail.com';
    $mail->Port       = 587;                                    // TCP port to connect to
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->SMTPAuth   = true;
    $mail->CharSet = "UTF-8";                                // Enable SMTP authentication
    $mail->SMTPOptions = array(
      'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
      )
    );
                                                             // Send using SMTP                          // Set the SMTP server to send through
    $mail->Username   = 'williamroger.frontend@gmail.com';                     // SMTP username
    $mail->Password   = 'web3d8874366347';                               // SMTP password

    $mail->setFrom('williamroger.frontend@gmail.com', 'Studios');
    $mail->addAddress('usuariostudios@outlook.com', 'Usuário Studios');
    // $mail->addReplyTo('williamroger.frontend@gmail.com');

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
    $mail->send();

    if (!$mail->send()) {
      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
      echo 'Message sent!';
    }
  }
}