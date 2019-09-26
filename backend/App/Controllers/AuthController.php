<?php

namespace App\Controllers;

use App\DAO\CustomersDAO;
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

    if ($user->getCustomerId() > 0) {
      // montar payload customer aqui
    } else {
      // montar payload studio aqui
    }
    // payload provisorio
    $tokenPayload = array(
      'id' => $user->getId(),
      'email' => $user->getEmail(),
      'expired_at' => $expiredAt
    );

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
