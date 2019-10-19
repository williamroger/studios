<?php

namespace App\Controllers;

require_once __DIR__ . '/../../vendor/autoload.php';

use App\DAO\StudiosDAO;
use App\DAO\UsersDAO;
use App\Models\RoomModel;
use App\Models\StudioModel;
use App\Models\TimePeriodModel;
use App\Models\UserModel;
use App\Controllers\UtilController;


use DateTimeZone;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class StudioController 
{
  public function getAllStudios(Request $request, Response $response, array $args): Response 
  {
    try {
      $studioDAO = new StudiosDAO();
      $studios = $studioDAO->getAllStudios();

      $response = $response->withJson([
        'success' => true,
        'studios' => $studios
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage() 
      ], 500);
    }
  }
  
  public function getStudioById(Request $request, Response $response, array $args): Response 
  {
    try {
      $idStudio = intval($args['id']);
      
      $studioDAO = new StudiosDAO();
      $studio = new StudioModel();

      if (!$idStudio)
        throw new \Exception("Erro na aplicação, tente novamente.");

      if ($studioDAO->studioExists($idStudio) == 0)
        throw new \Exception("Não encontramos esse estúdio em nossa base de dados.");

      $studio = $studioDAO->getStudioById($idStudio);
      
      $response = $response->withJson([
        'success' => true,
        'studio' => $studio,
      ], 200);

      return $response;
    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage()
      ], 500);
    }
  }

  public function getStudiosByCityIdCustomer(Request $request, Response $response, array $args): Response
  {
    try {
      $idCustomer = intval($args['id']);
      $studioDAO = new StudiosDAO();
      
      if (!$idCustomer) 
        throw new \Exception("Você precisa informar o ID do cliente.");
        
      $studios = $studioDAO->getStudiosByCityIdCustomer($idCustomer);

      $response = $response->withJson([
        'success' => true,
        'studios' => $studios
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage()
      ], 500);
    }
  } 
  
  public function insertStudio(Request $request, Response $response, array $args): Response
  {
    try {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d H:i:s');

      $studioDAO = new StudiosDAO();
      $userDAO = new UsersDAO();
      $newUser = new UserModel();

      if (!$data['name'] || $data['name'] === '')
        throw new \Exception("O nome do estúdio é obrigatório.");

      if (!$data['email'] || $data['email'] === '')
        throw new \Exception("O email é obrigatório.");

      if (!$data['password'] || $data['password'] === '')
        throw new \Exception("A senha é obrigatória.");

      if ($studioDAO->studioNameExists($data['name']) > 0)
        throw new \Exception('Já existe um estúdio com esse nome cadastrado.');

      if ($userDAO->emailExists($data['email']) > 0)
        throw new Exception('Este email já está cadastrado.');

      $password = password_hash($data['password'], PASSWORD_ARGON2I);

      $idNewStudio = $studioDAO->insertStudio($data['name'], $now);

      $newUser->setEmail($data['email'])
        ->setPassword($password)
        ->setCreatedAt($now)
        ->setStudioId(intval($idNewStudio))
        ->setIsStudio(1)
        ->setIsCustomer(0);

      $userDAO->insertUserStudio($newUser);

      $response = $response->withJson([
        'success' => true,
        'msg' => 'Estúdio cadastrado com sucesso!',
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage()
      ], 500);
    }
  }
  
  public function updateStudio(Request $request, Response $response, array $args): Response
  {
    try {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d H:i:s');
      $studioID = intval($data['id']);

      $studioDAO = new StudiosDAO();
      $studio = new StudioModel();

      if (!$studioID)
        throw new \Exception("Erro na aplicação, tente novamente.");
      
      if (!$data['name'] || $data['name'] === '')
        throw new \Exception("O nome do estúdio é obrigatório.");

      if (!$data['zip_code'] || $data['zip_code'] === '')
        throw new \Exception("O CEP do estúdio é obrigatório.");

      if (!$data['street'] || $data['street'] === '')
        throw new \Exception("O endereço do estúdio é obrigatório.");

      if (!$data['district'] || $data['district'] === '')
        throw new \Exception("O bairro do estúdio é obrigatório.");

      if (!$data['description'] || $data['description'] === '')
        throw new \Exception("A descrição do estúdio é obrigatória.");
      
      if (!$data['city_id'] || $data['city_id'] === '')
        throw new \Exception("A cidade e estado do estúdo são obrigatórios.");
      
      if ($studioDAO->studioExists($studioID) == 0)
        throw new \Exception("Não encontramos esse estúdio em nossa base de dados.");

      if ($studioDAO->studioCNPJExists($data['cnpj'], $studioID) > 0)
        throw new \Exception('Já existe um estúdio com esse CNPJ cadastrado.');

      $studio->setId($studioID)
        ->setName($data['name'])
        ->setPhone($data['phone'])
        ->setDescription($data['description'])
        ->setCnpj($data['cnpj'])
        ->setTelephone($data['telephone'])
        ->setUpdatedAt($now)
        ->setHasParking(intval($data['has_parking']))
        ->setHasWifi(intval($data['has_wifi']))
        ->setIs24Hours(intval($data['is_24_hours']))
        ->setCityId(intval($data['city_id']))
        ->setRateCancellation(intval($data['rate_cancellation']))
        ->setDaysCancellation(intval($data['days_cancellation']))
        ->setZipCode($data['zip_code'])
        ->setStreet($data['street'])
        ->setComplement($data['complement'])
        ->setDistrict($data['district'])
        ->setNumber($data['number'])
        ->setImage($data['image']);

      $studioDAO->updateStudio($studio);

      $response = $response->withJson([
        'success' => true,
        'msg' => 'Dados do estúdio atualizado com sucesso!'
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage()
      ], 500);
    }
  }
  
  public function deleteStudio(Request $request, Response $response, array $args): Response
  {
    try {
      $idStudio = intval($args['id']);
      
      if (!$idStudio)
        throw new \Exception("Erro na aplicação, tente novamente.");

      $studioDAO = new StudiosDAO();
      $userDAO = new UsersDAO();
  
      $userDAO->deleteUserStudio($idStudio);
      $studioDAO->deleteStudio($idStudio);
  
      $response = $response->withJson([
        'error' => false,
        'msg' => 'Estúdio excluído com sucesso!',
        'status' => 200
      ], 200);
  
      return $response;

    } catch(\Exception $ex) {
      return $response->withJson([
        'error' => true,
        'status' => 500,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage()
      ], 500);
    }
  }
  
  public function insertRoom(Request $request, Response $response, array $args): Response
  {
    try {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d H:i:s');

      $studioDAO = new StudiosDAO();
      $room = new RoomModel();

      if (!$data['name'] || $data['name'] === "")
        throw new \Exception("O nome da sala de ensaio é obriatório.");

      if (!$data['description'] || $data['description'] === "")
        throw new \Exception("A descrição da sala de ensaio é obriatória.");
      
      if (!$data['maximum_capacity'] || $data['maximum_capacity'] === "")
        throw new \Exception("A capacidade máxima da sala é obrigatória.");
      
      if (!$data['color'] || $data['color'] === "")
        throw new \Exception("A cor identificadora da sala é obrigatória.");

      $room->setName($data['name'])
        ->setDescription($data['description'])
        ->setStudioId(intval($data['studio_id']))
        ->setMaximumCapacity(intval($data['maximum_capacity']))
        ->setColor($data['color'])
        ->setCreatedAt($now)
        ->setImage($data['image']);

      $studioDAO->insertRoom($room);

      $response = $response->withJson([
        'success' => true,
        'msg' => 'Sala de Ensaio cadastrada com sucesso!',
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage()
      ], 500);
    }
  }
  
  public function getAllRooms(Request $request, Response $response, array $args): Response
  {
    try {
      $studioDAO = new StudiosDAO();
  
      $rooms = $studioDAO->getAllRooms();
  
      $response = $response->withJson([
        'error' => false,
        'data' => $rooms,
        'status' => 200
      ], 200);
  
      return $response;

    } catch(\Exception $ex) {
      return $response->withJson([
        'error' => true,
        'status' => 500,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage()
      ], 500);
    }
  }

  public function updateRoom(Request $request, Response $response, array $args): Response
  {
    try {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d H:i:s');
      $idRoom = intval($data['id']);

      $studioDAO = new StudiosDAO();
      $room = new RoomModel();

      if (!$idRoom)
        throw new \Exception("Erro na aplicação, tente novamente.");

      if ($studioDAO->roomExists($idRoom) == 0)
        throw new \Exception("Não encontramos essa sala em nossa base de dados.");

      if (!$data['name'] || $data['name'] === "")
        throw new \Exception("O nome da sala de ensaio é obriatório.");

      if (!$data['description'] || $data['description'] === "")
        throw new \Exception("A descrição da sala de ensaio é obriatória.");

      if (!$data['maximum_capacity'] || $data['maximum_capacity'] === "")
        throw new \Exception("A capacidade máxima da sala é obrigatória.");

      if (!$data['color'] || $data['color'] === "")
        throw new \Exception("A cor identificadora da sala é obrigatória.");

      $room->setId($idRoom)
        ->setName($data['name'])
        ->setDescription($data['description'])
        ->setStudioId(intval($data['studio_id']))
        ->setMaximumCapacity(intval($data['maximum_capacity']))
        ->setColor($data['color'])
        ->setUpdatedAt($now);

      $studioDAO->updateRoom($room);

      $response = $response->withJson([
        'success' => true,
        'msg' => 'Sala de ensaio atualizada com sucesso!'
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage()
      ], 500);
    }
  }
  
  public function deleteRoom(Request $request, Response $response, array $args): Response
  {
    try {
      $idRoom = intval($args['id']);

      if (!$idRoom)
        throw new \Exception("Erro na aplicação, tente novamente.");

      $studioDAO = new StudiosDAO();

      $studioDAO->deleteRoom($idRoom);

      $response = $response->withJson([
        'success' => true,
        'msg' => 'Sala de Ensaio excluída com sucesso!'
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage()
      ], 500);
    }
  }
 
  public function getRoomsByStudioId(Request $request, Response $response, array $args): Response
  {
    try {
      $idStudio = intval($args['id']);;
      $studioDAO = new StudiosDAO();

      if (!$idStudio)
        throw new \Exception("Erro na aplicação, tente novamente.");

      if ($studioDAO->studioExists($idStudio) == 0)
        throw new \Exception("Não encontramos esse estúdio em nossa base de dados.");
      
      $rooms = $studioDAO->getRoomsByStudioId($idStudio);

      $response = $response->withJson([
        'success' => true,
        'rooms' => $rooms
      ], 200);

      return $response;
      
    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }
  
  public function getRoomById(Request $request, Response $response, array $args): Response
  {
    try {
      $idRoom = intval($args['id']);
      $studioDAO = new StudiosDAO();

      if (!$idRoom)
        throw new \Exception("Erro na aplicação, tente novamente.");

      if ($studioDAO->roomExists($idRoom) == 0)
        throw new \Exception("Não encontramos essa sala em nossa base de dados.");

      $room = $studioDAO->getRoomById($idRoom);
   
      $response = $response->withJson([
        'success' => true,
        'room' => $room,
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }

  public function getPeriodsByRoomId(Request $request, Response $response, array $args): Response
  {
    try {
      $idRoom = intval($args['id']);
      $studioDAO = new StudiosDAO();

      if (!$idRoom)
        throw new \Exception("Erro na aplicação, tente novamente.");

      if ($studioDAO->roomExists($idRoom) == 0)
        throw new \Exception("Não encontramos essa sala em nossa base de dados.");

      $periods = $studioDAO->getPeriodsByRoomId($idRoom);
      
      $response = $response->withJson([
        'success' => true,
        'periods' => $periods
      ], 200);

      return $response;
    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()  
      ], 500);
    }
  }

  public function getPeriodById(Request $request, Response $response, array $args): Response 
  {
    try {
      $idPeriod = intval($args['id']);
      $studioDAO = new StudiosDAO();

      if (!$idPeriod)
        throw new \Exception("Erro na aplicação, tente novamente.");

      if ($studioDAO->periodExists($idPeriod) == 0)
        throw new \Exception("Não encontramos esse período em nossa base de dados.");

      $period = $studioDAO->getPeriodById($idPeriod);

      $response = $response->withJson([
        'success' => true,
        'period' => $period,
      ], 200);

      return $response;
    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }

  public function insertPeriod(Request $request, Response $response, array $args): Response
  {
    try {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d H:i:s');
      $idRoom = intval($data['room_id']);
      $dayOrder = null;
      $msgFeedback = 'Período cadastrado com sucesso!';
      $mondayToSaturday = array(
        "Monday", 
        "Tuesday", 
        "Wednesday", 
        "Thursday", 
        "Friday", 
        "Saturday"
      );

      if (!$idRoom)
        throw new Exception('Erro na aplicação, tente novamente.');
      
      if (!$data['amount'] || $data['amount'] == '')
        throw new Exception('Você precisa informar o valor do período');

      if (!$data['day'] || $data['day'] == '')
        throw new Exception('Você precisa informar um dia da semana');
      
      if (!$data['begin_period'] || $data['begin_period'] == '')
        throw new Exception('Você precisa infomar a hora incial do período');

      if (!$data['end_period'] || $data['end_period'] == '')
        throw new Exception('Você precisa informar a hora final do período');

      $period = new TimePeriodModel();
      $studioDAO = new StudiosDAO();

      if ($data['day'] == 'MondayToSaturday') {
        foreach($mondayToSaturday as $day) {
          $msgFeedback = 'Períodos cadastrados com sucesso!';
          $dayOrder = UtilController::setDayOrder($day);

          $period->setRoomId($idRoom)
            ->setAmount($data['amount'])
            ->setDay($day)
            ->setDayOrder($dayOrder)
            ->setBeginPeriod($data['begin_period'])
            ->setEndPeriod($data['end_period'])
            ->setCreatedAt($now);

          $studioDAO->insertPeriod($period);
        }
      } else {
        $dayOrder = UtilController::setDayOrder($data['day']);
     
        $period->setRoomId($idRoom)
          ->setAmount($data['amount'])
          ->setDay($data['day'])
          ->setDayOrder($dayOrder)
          ->setBeginPeriod($data['begin_period'])
          ->setEndPeriod($data['end_period'])
          ->setCreatedAt($now);

        $studioDAO->insertPeriod($period);
      }

      $response = $response->withJson([
        'success' => true,
        'msg' => $msgFeedback,
      ], 200);

      return $response;
      
    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }

  }

  public function updatePeriod(Request $request, Response $response, array $args): Response
  {
    try {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d H:i:s');
      $idPeriod = intval($data['id']);
      $dayOrder = null;

      if (!$idPeriod)
        throw new Exception('Erro na aplicação, tente novamente.');

      if (!$data['amount'] || $data['amount'] == '')
        throw new Exception('Você precisa informar o valor do período');

      if (!$data['day'] || $data['day'] == '')
        throw new Exception('Você precisa informar um dia da semana');

      if (!$data['begin_period'] || $data['begin_period'] == '')
        throw new Exception('Você precisa infomar a hora incial do período');

      if (!$data['end_period'] || $data['end_period'] == '')
        throw new Exception('Você precisa informar a hora final do período');

      $studioDAO = new StudiosDAO();
      $period = new TimePeriodModel();
      $dayOrder = UtilController::setDayOrder($data['day']);

      $period->setId($idPeriod)
      ->setAmount($data['amount'])
      ->setDay($data['day'])
      ->setDayOrder($dayOrder)
      ->setBeginPeriod($data['begin_period'])
      ->setEndPeriod($data['end_period'])
      ->setUpdatedAt($now);
      
      $studioDAO->updatePeriod($period);
      
      $response = $response->withJson([
        'success' => true,
        'msg' => 'Período atualizado com sucesso!'
      ]);

      return $response;
    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }

  public function deletePeriod(Request $request, Response $response, array $args): Response
  {
    try {
      $idPeriod = intval($args['id']);

      if (!$idPeriod)
        throw new \Exception("Erro na aplicação, tente novamente.");

      $studioDAO = new StudiosDAO();

      $studioDAO->deletePeriod($idPeriod);

      $response = $response->withJson([
        'success' => true,
        'msg' => 'Período excluído com sucesso!'
      ], 200);

      return $response;
    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }

  public function logoUpload(Request $request, Response $response, array $args): Response
  {
    try {
      $dir = __DIR__;
      $dir = str_replace('/Controllers', '/', $dir);
      $directory = $dir . 'public/uploads';

      $uploadedFiles = $request->getUploadedFiles();
      $idStudio = $args['id'];
      $studioDAO = new StudiosDAO();

      // trabalhar com um único arquivo
      $uploadedFile = $uploadedFiles['logostudio'];

      if (!$studioDAO->studioExists($idStudio))
        throw new Exception('Erro na aplicação, tente novamente.');

      if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        $pathlogo = UtilController::moveUploadedLogoFile($directory, $idStudio, $uploadedFile);

        $studioDAO->logoUpload(intval($idStudio), $pathlogo);

        $response = $response->withJson([
          'success' => true,
          'msg' => 'upload realizado com sucesso!',
          'pathlogo' => $pathlogo
        ], 200);

      } else {
        $response = $response->withJson([
          'success' => false,
          'msg' => 'Ocorreu um erro no upload.'
        ], 500);
      }

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }

  public function getLogoStudio(Request $request, Response $response, array $args): Response 
  {
    try {
      $idStudio = intval($args['id']);
      $studioDAO = new StudiosDAO();
      
      if (!$studioDAO->studioExists($idStudio))
        throw new Exception('Erro na aplicação, tente novamente.');
        
      $pathlogo = $studioDAO->getLogoStudio($idStudio);
      $image = readfile($pathlogo);
     
      $response->getBody($image);
      return $response->withHeader('Content-Type', 'image/png');

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
    
  }

  public function imageRoomUpload(Request $request, Response $response, array $args): Response
  {
    try {
      $dir = __DIR__;
      $dir = str_replace('/Controllers', '/', $dir);
      $directory = $dir . 'public/uploads';

      $uploadedFiles = $request->getUploadedFiles();
      $idStudio = intval($args['studioid']);
      $roomId = intval($args['id']);
      $studioDAO = new StudiosDAO();

      // trabalhar com um único arquivo
      $uploadedFile = $uploadedFiles['image'];

      if (!$studioDAO->studioExists($idStudio))
        throw new Exception('Erro na aplicação, tente novamente.');

      if (!$studioDAO->roomExists($roomId))
        throw new Exception('Erro na aplicação, tente novamente.');
      
      if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        $pathImage = UtilController::moveUploadedImageRoom($directory, $idStudio, $roomId, $uploadedFile);

        $studioDAO->imageRoomUpload($roomId, $idStudio, $pathImage);

        $response = $response->withJson([
          'success' => true,
          'msg' => 'upload realizado com sucesso!',
          'pathlogo' => $pathImage
        ], 200);

      } else {
        $response = $response->withJson([
          'success' => false,
          'msg' => 'upload realizado com sucesso!'
        ], 500);
      }

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }

  public function getImageRoom(Request $request, Response $response, array $args): Response
  {
    try {
      $idRoom = intval($args['id']);
      $idStudio = intval($args['studioid']);
      $studioDAO = new StudiosDAO();

      if (!$studioDAO->studioExists($idStudio))
        throw new Exception('Erro na aplicação, tente novamente.');

      if (!$studioDAO->roomExists($idRoom))
        throw new Exception('Erro na aplicação, tente novamente.');

      $pathimage = $studioDAO->getImageRoom($idStudio, $idRoom);
      $image = readfile($pathimage);

      $response->getBody($image);
      return $response->withHeader('Content-Type', 'image/png');

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => $ex->getMessage()
      ], 500);
    }
  }
}