<?php

namespace App\Controllers;

use App\DAO\UtilDAO;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile;

class UtilController
{
  public static function getAllStates(Request $request, Response $response, array $args): Response
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

  public static function getAllCities(Request $request, Response $response, array $args): Response
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

  public static function getCitiesByStateId(Request $request, Response $response, array $args): Response
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

  public static function setDayOrder($day): int {
    switch($day) {
      case 'Monday':
        return 1;
        break;
      case 'Tuesday':
        return 2;
        break;
      case 'Wednesday':
        return 3;
        break;
      case 'Thursday':
        return 4;
        break;
      case 'Friday':
        return 5;
        break;
      case 'Saturday':
        return 6;
        break;
      case 'Sunday':
        return 7;
        break;
    }
  }

  public static function moveUploadedFile($directory, $id, UploadedFile $uploadedFile): string {
    // todas as extensões que serão permitidas
    $fileExtensions = ['jpeg', 'jpg', 'png'];

    // pegar a extensão do arquivo
    $extension = pathinfo($uploadedFile->getClientFileName(), PATHINFO_EXTENSION);
    if (!in_array($extension, $fileExtensions))
      throw new Exception('Qual a parte de apenas .jpeg, .jpg ou .png você não entendeu?');
    
    // renomear o arquivo concatenando com id do estúdio
    // $basename = bin2hex(random_bytes(8));
    $filename = sprintf('%s.%0.8s', 'logo_studio', $extension);
    $directoryStudio = $directory . '/studio_' . $id;
    
    if (!is_dir($directoryStudio)) {
      mkdir($directoryStudio, 0777, true);
    }

    if (is_dir($directoryStudio)) {
      $dir = dir($directoryStudio);
      while ($file = $dir->read()) {
        if (($file != '.') && ($file != '..') && ($extension != 'DS_Store')) {
          unlink($directoryStudio.'/'.$file);
        }
      }
      $dir->close();
    }

    $uploadedFile->moveTo($directoryStudio . DIRECTORY_SEPARATOR . $filename);
    
    return $directoryStudio . '/' . $filename;
  }
}
