<?php

namespace App\Controllers;

use App\DAO\CustomersDAO;
use App\DAO\StudiosDAO;
use App\DAO\UsersDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class AuthController
{ 
  public function login(Request $request, Response $response, array $args): Response
  {
    $data = $request->getParsedBody();
    $email = $data['email'];
    $password = $data['password'];

    $userDAO = new UsersDAO();
    $customerDAO = new CustomersDAO();
    $studioDAO = new StudiosDAO();

    $user = $userDAO->getUserByEmail($email);

    if (is_null($user)) {
      return $response->withJson([
        'success' => false,
        'msg' => 'Verifique seu e-mail, este usuário não existe.'
      ], 401);
    }

    if (!password_verify($password, $user->getPassword())) {
      return $response->withJson([
        'success' => false,
        'msg' => 'Verifique sua senha, há algo errado.'
      ], 401);
    }
    
    if ($user->getIsCustomer() == 1) {
      $custumer = $customerDAO->getCustomerById(intval($user->getCustomerId()));
    
      $userPayload = array(
        'id' => $user->getId(),
        'is_customer' => $user->getIsCustomer(),
        'customer_id' => $user->getCustomerId(),
        'email' => $user->getEmail(),
        'firstname' => $custumer['firstname'],
        'lastname' => $custumer['lastname'],
        'phone' => $custumer['phone'],
        'cpf' => $custumer['cpf'],
        'city_id' => $custumer['city_id']
      );
    } else {
      $studio = $studioDAO->getStudioById(intval($user->getStudioId()));

      $userPayload = array(
        'id' => $user->getId(),
        'is_studio' => $user->getIsStudio(),
        'studio_id' => $user->getStudioId(),
        'email' => $user->getEmail(),
        'name' => $studio['name'],
        'city_id' => $studio['city_id']
      );
    }

    $response = $response->withJson([
      'success' => true,
      'msg' => 'Login realizado com sucesso!',
      'userPayload' => $userPayload
    ], 200);
    
    return $response;
  }
}
