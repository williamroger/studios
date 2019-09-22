<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class UserController 
{
  public function getAllStates(Request $request, Response $respose, array $args): Response
  {
    return $respose;
  }

  public function getAllCities(Request $request, Response $response, array $args): Response 
  {
    return $response;
  }

  public function getCityByStateId(Request $request, Response $response, array $args): Response
  {
    return $response;
  }
}