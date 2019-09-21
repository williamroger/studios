<?php

namespace App\Controllers;

use App\DAO\CustomersDAO;
use App\DAO\UsersDAO;
use App\Models\CustomerModel;
use App\Models\UserModel;
use DateTimeZone;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class CustomerController{

  public function getAllCustomers(Request $request, Response $response, array $args): Response
  {
    try {
      $customerDAO = new CustomersDAO();
      $customers = $customerDAO->getAllCustomers();

      $response = $response->withJson([
        'error' => false,
        'data' => $customers,
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

  public function insertCustomer(Request $request, Response $response, array $args): Response
  {
    try {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d H:i:s');

      $customersDAO = new CustomersDAO();
      $userDAO = new UsersDAO();
      $newUser = new UserModel();

      if (!$data['name'] || $data['name'] === '')
        throw new Exception("O nome é obrigatório");

      if (!$data['email'] || $data['email'] === '')
        throw new Exception("O email é obrigatório");

      if (!$data['password'] || $data['password'] === '')
        throw new Exception("O senha é obrigatório");

      $idNewCustomer = $customersDAO->insertCustomer($data['name'], $now);

      $newUser->setEmail($data['email'])
        ->setPassword($data['password'])
        ->setCreated_at($now)
        ->setCustomer_id(intval($idNewCustomer))
        ->setIs_studio(0)
        ->setIs_customer(1);

      $userDAO->insertUserCustomer($newUser);

      $response = $response->withJson([
        'error' => false,
        'msg' => 'Cliente cadastrado com sucesso!',
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

  public function updateCustomer(Request $request, Response $response, array $args): Response
  {
    try {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d H:i:s');
      $customerID = intval($data['id']);

      if (!$customerID)
        throw new Exception("Erro na aplicação, tente novamente.");

      if (!$data['name'] || $data['name'] === '')
        throw new Exception("O nome é obrigatório");

      if (!$data['phone'] || $data['phone'] === '')
        throw new Exception("O telefone é obrigatório");

      if (!$data['cpf'] || $data['cpf'] === '')
        throw new Exception("O CPF é obrigatório");

      if (!$data['city_id'] || $data['city_id'] === '')
        throw new Exception("A cidade e estado são obrigatórios.");

      if (!$data['email'] || $data['email'] === '')
        throw new Exception("O email é obrigatório");

      if (!$data['password'] || $data['password'] === '')
        throw new Exception("O senha é obrigatório");

      $customerDAO = new CustomersDAO();
      $userDAO = new UsersDAO();
      $customer = new CustomerModel();
      $user = new UserModel();

      $customer->setId($customerID)
        ->setName($data['name'])
        ->setPhone($data['phone'])
        ->setUpdated_at($now)
        ->setCpf($data['cpf'])
        ->setCity_id(intval($data['city_id']));

      $user->setEmail($data['email'])
        ->setUpdated_at($now)
        ->setCustomer_id($customerID);

      $customerDAO->updateCustomer($customer);

      $userDAO->updateUserCustomer($user);

      $response = $response->withJson([
        'error' => false,
        'msg' => 'Dados atualizado com sucesso!',
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
  
  public function deleteCustomer(Request $request, Response $response, array $args): Response
  {
    try {
      $data = $request->getParsedBody();
      $idCustomer = intval($data['id']);

      if (!$idCustomer)
        throw new \Exception("Erro na aplicação, tente novamente.");

      $customerDAO = new CustomersDAO();
      $userDAO = new UsersDAO();

      $userDAO->deleteUserCustomer($idCustomer);
      $customerDAO->deleteCustomer($idCustomer);

      $response = $response->withJson([
        "message" => "Usuário excluído com sucesso!"
      ]);

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