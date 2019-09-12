<?php

namespace App\Controllers;

use App\DAO\StudiosDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class StudiosController 
{
  public function getStudios(Request $request, Response $response, array $args): Response 
  {
    $response = $response->withJson([
      "message" => "Listando todos os Estúdios"
    ]);

    $studioDao = new StudiosDAO();
    $studioDao->testEstados();
    
    return $response;
  }
}