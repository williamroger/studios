<?php

namespace App\Controllers;

use App\DAO\StudiosDAO;
use App\DAO\UsersDAO;
use App\Models\RoomModel;
use App\Models\StudioModel;
use App\Models\UserModel;
use DateTimeZone;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class StudioController 
{
  public function getAllStudios(Request $request, Response $response, array $args): Response 
  {
    $studioDAO = new StudiosDAO();
    $studios = $studioDAO->getAllStudios();
    
    $response = $response->withJson($studios);

    return $response;
  }

  public function getStudiosByCityIdCustomer(Request $request, Response $response, array $args): Response
  {
    try {
      $data = $request->getParsedBody();
      $studioDAO = new StudiosDAO();
      $idCustomer = intval($data['id']);
      
      if (!$idCustomer) 
        throw new \Exception("Informe o ID do cliente.");
        
      $studios = $studioDAO->getStudiosByCityIdCustomer($idCustomer);

      $response = $response->withJson([
        'error' => false,
        'data' => $studios,
        'status' => 200
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'error' => true,
        'status' => 500,
        'message' => 'Erro na aplicação, tente novamente.',
        'devMessage' => $ex->getMessage()
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
        throw new \Exception("O nome é obrigatório.");

      if (!$data['email'] || $data['email'] === '')
        throw new \Exception("O email é obrigatório.");

      if (!$data['password'] || $data['password'] === '')
        throw new \Exception("A senha é obrigatória.");

      $idNewStudio = $studioDAO->insertStudio($data['name'], $now);

      $newUser->setEmail($data['email'])
        ->setPassword($data['password'])
        ->setCreated_at($now)
        ->setStudio_id(intval($idNewStudio))
        ->setIs_studio(1)
        ->setIs_customer(0);

      $userDAO->insertUserStudio($newUser);

      $response = $response->withJson([
        'error' => false,
        'message' => 'Estúdio cadastrado com sucesso!',
        'status' => 200
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'error' => true,
        'status' => 500,
        'message' => 'Erro na aplicação, tente novamente.',
        'devMessage' => $ex->getMessage()
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
      $userDAO = new UsersDAO();
      $studio = new StudioModel();
      $user = new UserModel();

      $studio->setId($studioID)
        ->setName($data['name'])
        ->setAddress($data['address'])
        ->setPhone($data['phone'])
        ->setDescription($data['description'])
        ->setCnpj($data['cnpj'])
        ->setTelephone($data['telephone'])
        ->setUpdated_at($now)
        ->setHasParking(intval($data['has_parking']))
        ->setIs24Hours(intval($data['is_24_hours']))
        ->setCityId(intval($data['city_id']))
        ->setRateCancellation(intval($data['rate_cancellation']))
        ->setDaysCancellation(intval($data['days_cancellation']));

      $user->setEmail($data['email'])
        ->setPassword($data['password'])
        ->setUpdated_at($now)
        ->setStudio_id($studioID);

      $studioDAO->updateStudio($studio);
      $userDAO->updateUserStudio($user);

      $response = $response->withJson([
        'error' => false,
        'message' => 'Estúdio alterado com sucesso!',
        'status' => 200
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'error' => true,
        'status' => 500,
        'message' => 'Erro na aplicação, tente novamente.',
        'devMessage' => $ex->getMessage()
      ], 500);
    }
  }

  public function deleteStudio(Request $request, Response $response, array $args): Response
  {
    try{
      $data = $request->getParsedBody();
      $idStudio = intval($data['id']);
  
      $studioDAO = new StudiosDAO();
      $userDAO = new UsersDAO();
  
      $userDAO->deleteUserStudio($idStudio);
      $studioDAO->deleteStudio($idStudio);
  
      $response = $response->withJson([
        "message" => "Estúdio excluído com sucesso!"
      ]);
  
      return $response;
    }
    catch(\Exception $ex){
      return $response->withJson([
        'error' => true,
        'status' => 500,
        'message' => 'Erro na aplicação, tente novamente.',
        'devMessage' => $ex->getMessage()
      ], 500);
    }
  }

  public function insertRoom(Request $request, Response $response, array $args): Response
  {
    $data = $request->getParsedBody();
    $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
    $now = $date->format('Y-m-d H:i:s');
    
    $studioDAO = new StudiosDAO();
    $room = new RoomModel();

    $room->setName($data['name'])
    ->setDescription($data['description'])
    ->setStudio_id(intval($data['studio_id']))
    ->setMaximum_capacity(intval($data['maximum_capacity']))
    ->setColor($data['color'])
    ->setCreated_at($now);

    $studioDAO->insertRoom($room);

    $response = $response->withJson([
      "message" => "Sala de Ensaio cadastrada com sucesso!"
    ]);

    return $response;
  }

  public function getAllRooms(Request $request, Response $response, array $args): Response
  {
    try{
      $studioDAO = new StudiosDAO();
  
      $rooms = $studioDAO->getAllRooms();
  
      $response = $response->withJson($rooms);
  
      return $response;
    }catch(\Exception $ex){
      return $response->withJson([
        'error' => true,
        'status' => 500,
        'message' => 'Erro na aplicação, tente novamente.',
        'devMessage' => $ex->getMessage()
      ], 500);
    }
  }

  public function updateRoom(Request $request, Response $response, array $args): Response
  {
    $data = $request->getParsedBody();
    $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
    $now = $date->format('Y-m-d H:i:s');

    $studioDAO = new StudiosDAO();
    $room = new RoomModel();

    $room->setId(intval($data['id']))
    ->setName($data['name'])
    ->setDescription($data['description'])
    ->setStudio_id(intval($data['studio_id']))
    ->setMaximum_capacity(intval($data['maximum_capacity']))
    ->setColor($data['color'])
    ->setUpdated_at($now);

    $studioDAO->updateRoom($room);

    $response = $response->withJson([
      "message" => "Sala de ensaio atualizada com sucesso!"
    ]);

    return $response;
  }

  public function deleteRoom(Request $request, Response $response, array $args): Response
  {
    $data = $request->getParsedBody();
    $idRoom = intval($data['id']);

    $studioDAO = new StudiosDAO();

    $studioDAO->deleteRoom($idRoom);

    $response = $response->withJson([
      "message" => "Sala de Ensaio excluída com sucesso!"
    ]);

    return $response;
  }

  public function getRoomsByStudioId(Request $request, Response $response, array $args): Response
  {
    $data = $request->getParsedBody();
    $idStudio = intval($data['id']);

    $studioDAO = new StudiosDAO();
    $rooms = $studioDAO->getRoomsByStudioId($idStudio);

    $response = $response->withJson($rooms);

    return $response;
  }
}