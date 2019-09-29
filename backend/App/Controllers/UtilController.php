<?php

namespace App\Controllers;

use App\DAO\UtilDAO;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class UtilController
{
  public function getAllStates(Request $request, Response $response, array $args): Response
  {
    try {
      $utilDAO = new UtilDAO();
      $states = $utilDAO->getAllStates();

      $response = $response->withJson([
        'error' => false,
        'data' => $states,
        'status' => 200
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'error' => true,
        'status' => 500,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage()
      ], 500);
    }
  }

  public function getAllCities(Request $request, Response $response, array $args): Response
  {
    try {
      $utilDAO = new UtilDAO();
      $cities = $utilDAO->getAllCities();

      $response = $response->withJson([
        'error' => false,
        'data' => $cities,
        'statu' => 200
      ], 200);

      return $response;      

    } catch (\Exception $ex) {
      return $response->withJson([
        'error' => true,
        'status' => 500,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage()
      ], 500);
    }
  }

  public function getCitiesByStateId(Request $request, Response $response, array $args): Response
  {
    try {
      $idState = intval($args['id']);
     
      if (!$idState)
        throw new \Exception('Erro na aplicação, tente novamente.');

      $utilDAO = new UtilDAO();
      $cities = $utilDAO->getCityByStateId($idState);

      if (!$cities)
        throw new \Exception('Nenhuma cidade encontrada.');

      $response = $response->withJson([
        'success' => true,
        'cities' => $cities,
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => true,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage()
      ], 500);
    }
  }
}
