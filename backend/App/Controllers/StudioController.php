<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class StudioController 
{
  public function getStudios(Request $request, Response $response, array $args): Response 
  {
    $response = $response->withJson([
      "message" => "Listando todos os Estúdios"
    ]);

    return $response;
  }
}