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
        $customerDAO = new CustomersDAO();
        $customer = $customerDAO->getAllCustomers();

        $response = $response->withJson($customer);

        return $response;
    }

    public function insertCustomer(Request $request, Response $response, array $args): Response
    {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d H:i:s');
      
      $customersDAO = new CustomersDAO();
      $userDAO = new UsersDAO();
      $newUser = new UserModel();
      
      $idNewCustomer = $customersDAO->insertCustomer($data['name'], $now);
      
      $newUser->setEmail($data['email'])
        ->setPassword($data['password'])
        ->setCreated_at($now)
        ->setCustomer_id(intval($idNewCustomer))
        ->setIs_studio(0)
        ->setIs_customer(1);
      
      $userDAO->insertUserCustomer($newUser);
  
      $response = $response->withJson([
        'message' => 'Customizador cadastrado com sucesso!'
      ]);
  
      return $response;
    }
    public function updateCustomer(Request $request, Response $response, array $args): Response
    {
      $data = $request->getParsedBody();
      $date = new \DateTime("now", new DateTimeZone('America/Sao_Paulo'));
      $now = $date->format('Y-m-d H:i:s');
      $customerID = intval($data['id']);
  
      $customerDAO = new CustomersDAO();
      $userDAO = new UsersDAO();
      $customer = new CustomerModel();
      $user = new UserModel();
  
      $customer->setId($customerID)
      ->setName($data['name'])
      ->setPhone($data['phone'])
      ->setUpdated_at($now)
      ->setCpf($data['cpf'])
      ->setCitiesId(intval($data['cities_id']));

      $user->setEmail($data['email'])
      ->setPassword($data['password'])
      ->setUpdated_at($now)
      ->setCustomer_id($customerID);
  
      $customerDAO->updateCustomer($customer);
      $userDAO->updateUserCustomer($user);
  
      $response = $response->withJson([
        'message' => 'Cliente alterado com sucesso!'
      ]);
  
      return $response;
    }
  
}