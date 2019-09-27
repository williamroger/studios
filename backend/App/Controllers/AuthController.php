<?php

namespace App\Controllers;

use App\DAO\CustomersDAO;
use App\DAO\StudiosDAO;
use App\DAO\TokensDAO;
use App\DAO\UsersDAO;
use App\Models\TokenModel;
use DateTime;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

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
    
    $expiredAt = (new \DateTime())->modify('+2 days')->format('Y-m-d H:i:s');
    
    if ($user->getIsCustomer() == 1) {
      $custumer = $customerDAO->getCustomerById(intval($user->getCustomerId()));
      
      $tokenPayload = array(
        'id' => $user->getId(),
        'customer_id' => $user->getCustomerId(),
        'email' => $user->getEmail(),
        'firstname' => $custumer['firstname'],
        'lastname' => $custumer['lastname'],
        'phone' => $custumer['phone'],
        'cpf' => $custumer['cpf'],
        'city_id' => $custumer['city_id'],
        'expired_at' => $expiredAt
      );
    } else {
      $studio = $studioDAO->getStudioById(intval($user->getStudioId()));
     
      $tokenPayload = array(
        'id' => $user->getId(),
        'studio_id' => $user->getStudioId(),
        'email' => $user->getEmail(),
        'name' => $studio['name'],
        'city_id' => $studio['city_id'],
        'expired_at' => $expiredAt
      );
    }

    $token = JWT::encode($tokenPayload, getenv('JWT_SECRET_KEY'));

    $refreshTokenPayload = array(
      'email' => $user->getEmail()
    );

    $refreshToken = JWT::encode($refreshTokenPayload, getenv('JWT_SECRET_KEY'));
    
    $tokenModel = new TokenModel();
    $tokenModel->setToken($token)
    ->setRefreshToken($refreshToken)
    ->setExpiredAt($expiredAt)
    ->setUserId($user->getId());

    $tokenDAO = new TokensDAO();
    $tokenDAO->createToken($tokenModel);

    $response = $response->withJson([
      'success' => true,
      'token' => $token,
      'refresh_token' => $refreshToken
    ]);
    
    return $response;
  }
}
