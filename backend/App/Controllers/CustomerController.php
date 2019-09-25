<?php

namespace App\Controllers;

use App\DAO\CustomersDAO;
use App\DAO\UsersDAO;
use App\Models\CustomerModel;
use App\Models\UserModel;
use DateTimeZone;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class CustomerController{
  
  public function getAllCustomers(Request $request, Response $response, array $args): Response
  {
    try {
      $customerDAO = new CustomersDAO();
      $customers = $customerDAO->getAllCustomers();

      $response = $response->withJson([
        'success' => true,
        'customers' => $customers,
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
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

      if (!$data['firstname'] || $data['firstname'] === '')
        throw new Exception("O nome é obrigatório");

      if (!$data['lastname'] || $data['lastname'] === '')
        throw new Exception("O sobrenome é obrigatório");

      if (!$data['email'] || $data['email'] === '')
        throw new Exception("O email é obrigatório");

      if (!$data['password'] || $data['password'] === '')
        throw new Exception("O senha é obrigatório");

      if ($userDAO->emailExists($data['email']) > 0)
        throw new Exception('Este email já está cadastrado.');

      $idNewCustomer = $customersDAO->insertCustomer($data['firstname'], $data['lastname'], $now);

      $newUser->setEmail($data['email'])
        ->setPassword($data['password'])
        ->setCreatedAt($now)
        ->setCustomerId(intval($idNewCustomer))
        ->setIsStudio(0)
        ->setIsCustomer(1);

      $userDAO->insertUserCustomer($newUser);

      $response = $response->withJson([
        'success' => true,
        'msg' => 'Cliente cadastrado com sucesso!'
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
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

      $customerDAO = new CustomersDAO();
      $userDAO = new UsersDAO();
      $customer = new CustomerModel();
      $user = new UserModel();

      if (!$customerID)
        throw new Exception("Erro na aplicação, tente novamente.");
      if (!$data['firstname'] || $data['firstname'] === '')
        throw new Exception("O nome é obrigatório");

      if (!$data['lastname'] || $data['lastname'] === '')
        throw new Exception("O sobrenome é obrigatório");

      if (!$data['phone'] || $data['phone'] === '')
        throw new Exception("O telefone é obrigatório");

      if (!$data['cpf'] || $data['cpf'] === '')
        throw new Exception("O CPF é obrigatório");

      if (!$data['city_id'] || $data['city_id'] === '')
        throw new Exception("A cidade e estado são obrigatórios.");

      if (!$data['email'] || $data['email'] === '')
        throw new Exception("O email é obrigatório");

      if ($customerDAO->customerExists($customerID) == 0)
        throw new \Exception("Não encontramos esse usuário em nossa base de dados.");

      $customer->setId($customerID)
        ->setFirstName($data['firstname'])
        ->setLastName($data['lastname'])
        ->setPhone($data['phone'])
        ->setUpdatedAt($now)
        ->setCpf($data['cpf'])
        ->setCityId(intval($data['city_id']))
        ->setImage($data['image']);

      $user->setEmail($data['email'])
        ->setUpdatedAt($now)
        ->setCustomerId($customerID);

      $customerDAO->updateCustomer($customer);

      $userDAO->updateUserCustomer($user);

      $response = $response->withJson([
        'success' => true,
        'msg' => 'Dados atualizado com sucesso!',
      ], 200);

      return $response;

    } catch (\Exception $ex) {
      return $response->withJson([
        'success' => false,
        'msg' => 'Erro na aplicação, tente novamente.',
        'msgDev' => $ex->getMessage()
      ], 500);
    }
  }
 
  public function deleteCustomer(Request $request, Response $response, array $args): Response
  {
    try {
      $idCustomer = intval($args['id']);
     
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