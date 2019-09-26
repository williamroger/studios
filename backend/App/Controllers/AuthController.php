<?php

namespace App\Controllers;

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

    $user = $userDAO->getUserByEmail($email);

    if (is_null($user))
      return $response->withStatus(401);

    if (!password_verify($password, $user->getPassword())) 
      return $response->withStatus(401);

    return $response;
  }
}
