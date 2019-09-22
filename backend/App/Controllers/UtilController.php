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

  public function getCityByStateId(Request $request, Response $response, array $args): Response
  {
    try {
      $data = $request->getParsedBody();
      $idState = intval($data['id']);

      if (!$idState)
        throw new \Exception('Você precisa informar o ID do cliente.');

      $utilDAO = new UtilDAO();
      $cities = $utilDAO->getCityByStateId($idState);
      
      if (!$cities)
        throw new \Exception('Nenhuma cidade encontrada.');

      $response = $response->withJson([
        'error' => false,
        'data' => $cities,
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
}
