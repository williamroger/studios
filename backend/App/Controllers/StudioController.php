<?php

namespace App\Controllers;

use App\DAO\StudiosDAO;
use App\DAO\UsersDAO;
use App\Models\StudioModel;
use App\Models\UserModel;
use DateTimeZone;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class StudioController 
{
  public function getAllStudios(Request $request, Response $response, array $args): Response 
  {
    $studioDao = new StudiosDAO();
    $studios = $studioDao->getAllStudios();
    
    $response = $response->withJson($studios);

    return $response;
  }

  public function insertStudio(Request $request, Response $response, array $args): Response
  {
    $data = $request->getParsedBody();
    $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
    $now = $date->format('Y-m-d H:i:s');
    
    $studioDAO = new StudiosDAO();
    $userDAO = new UsersDAO();
    $newUser = new UserModel();
    
    $idNewStudio = $studioDAO->insertStudio($data['name']);
   
    $newUser->setEmail($data['email'])
      ->setPassword($data['password'])
      ->setCreated_at($now)
      ->setStudio_id(intval($idNewStudio))
      ->setIs_studio(1)
      ->setIs_customer(0);
    
    $userDAO->insertUserStudio($newUser);

    $response = $response->withJson([
      'message' => 'Estúdio cadastrado com sucesso!'
    ]);

    return $response;
  }

  public function updateStudio(Request $request, Response $response, array $args): Response
  {
    $response = $response->withJson([
      "message" => "Listando todos os Estúdios"
    ]);

    $studioDao = new StudiosDAO();
    $studioDao->testEstados();

    return $response;
  }

  public function deleteStudio(Request $request, Response $response, array $args): Response
  {
    $response = $response->withJson([
      "message" => "Listando todos os Estúdios"
    ]);

    $studioDao = new StudiosDAO();
    $studioDao->testEstados();

    return $response;
  }
}